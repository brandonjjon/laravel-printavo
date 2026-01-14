<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates PHP DTO classes from GraphQL type definitions.
 */
readonly class DTOGenerator
{
    /**
     * PHP reserved keywords that cannot be used as class names.
     *
     * @var array<string>
     */
    private const RESERVED_KEYWORDS = [
        'abstract', 'and', 'array', 'as', 'break', 'callable', 'case', 'catch',
        'class', 'clone', 'const', 'continue', 'declare', 'default', 'die', 'do',
        'echo', 'else', 'elseif', 'empty', 'enddeclare', 'endfor', 'endforeach',
        'endif', 'endswitch', 'endwhile', 'eval', 'exit', 'extends', 'false',
        'final', 'finally', 'fn', 'for', 'foreach', 'function', 'global', 'goto',
        'if', 'implements', 'include', 'include_once', 'instanceof', 'insteadof',
        'interface', 'isset', 'list', 'match', 'namespace', 'new', 'null', 'or',
        'print', 'private', 'protected', 'public', 'readonly', 'require',
        'require_once', 'return', 'static', 'switch', 'throw', 'trait', 'true',
        'try', 'unset', 'use', 'var', 'void', 'while', 'xor', 'yield',
    ];

    public function __construct(
        private TypeMapper $typeMapper,
    ) {}

    /**
     * Generate complete PHP class code from a type definition.
     */
    public function generate(TypeDefinition $type): string
    {
        $fields = $type->isInput() ? $type->inputFields : $type->fields;
        $imports = $this->collectImports($fields);
        $constructorParams = $this->generateConstructorParams($fields);
        $fromArrayBody = $this->generateFromArrayBody($fields);
        $defaultFieldsArray = $this->generateDefaultFields($fields);
        $description = $type->description ? " * {$type->description}\n *\n" : '';
        $className = $this->toSafeClassName($type->name);

        $importsCode = $this->generateImports($imports);

        return <<<PHP
<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
{$importsCode}
/**
{$description} * @generated from GraphQL schema - do not edit manually
 */
readonly class {$className} extends BaseData
{
    /**
     * @param  array<string, mixed>  \$attributes
     */
    public function __construct(
{$constructorParams}
        protected array \$attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  \$data
     */
    public static function fromArray(array \$data): static
    {
{$fromArrayBody}
    }

    /**
     * Get the default fields to request from the API.
     *
     * @return array<string>
     */
    public static function defaultFields(): array
    {
        return [
            {$defaultFieldsArray}
        ];
    }
}
PHP;
    }

    /**
     * Check if this type should have a DTO generated.
     */
    public function shouldGenerate(TypeDefinition $type): bool
    {
        return $this->typeMapper->isGeneratableType($type);
    }

    /**
     * Collect all imports needed for the generated class.
     *
     * @param  array<string, FieldDefinition>  $fields
     * @return array<string>
     */
    private function collectImports(array $fields): array
    {
        $imports = [];

        foreach ($fields as $field) {
            $import = $this->typeMapper->requiresImport($field->type);
            if ($import !== null) {
                $imports[$import] = true;
            }

            // Add imports for enum types
            if ($this->typeMapper->isEnum($field->type)) {
                $enumImport = "Brandonjjon\\Printavo\\Data\\Generated\\Enums\\{$field->type}";
                $imports[$enumImport] = true;
            }
        }

        return array_keys($imports);
    }

    /**
     * Generate the imports section.
     *
     * @param  array<string>  $imports
     */
    private function generateImports(array $imports): string
    {
        if (empty($imports)) {
            return '';
        }

        $lines = array_map(fn ($import) => "use {$import};", $imports);

        return implode("\n", $lines)."\n";
    }

    /**
     * Generate constructor parameters.
     *
     * @param  array<string, FieldDefinition>  $fields
     */
    private function generateConstructorParams(array $fields): string
    {
        $params = [];
        $requiredParams = [];
        $optionalParams = [];

        foreach ($fields as $field) {
            $param = $this->generateConstructorParam($field);

            // id field is always first and required
            if ($field->name === 'id') {
                array_unshift($requiredParams, $param);
            } elseif ($field->isNullable || $field->isList) {
                $optionalParams[] = $param;
            } else {
                $requiredParams[] = $param;
            }
        }

        // Combine: required first, then optional
        $params = array_merge($requiredParams, $optionalParams);

        return implode("\n", $params);
    }

    /**
     * Generate a single constructor parameter.
     */
    private function generateConstructorParam(FieldDefinition $field): string
    {
        $phpType = $this->typeMapper->toPhpType($field);
        $phpDocType = $this->typeMapper->toPhpDocType($field);
        $default = '';

        // Connection types are stored as arrays (not parsed to objects)
        if ($this->typeMapper->isConnectionType($field->type)) {
            $phpType = $field->isNullable ? '?array' : 'array';
            $phpDocType = 'array<mixed>';
            $default = ' = []';
        }

        // Nested object types should be nullable to handle sparse API responses
        // This allows queries that don't request nested fields to still work
        $isNestedObject = ! $this->typeMapper->isScalar($field->type)
            && ! $this->typeMapper->isEnum($field->type)
            && ! $this->typeMapper->isConnectionType($field->type)
            && ! $field->isList;

        // Enum types should also be nullable - the API often returns null even for
        // schema-defined non-nullable enum fields
        $isEnum = $this->typeMapper->isEnum($field->type) && ! $field->isList;

        if (($isNestedObject || $isEnum) && ! $field->isNullable) {
            // Make non-nullable nested objects and enums nullable with null default
            $phpType = '?'.$phpType;
            $default = ' = null';
        } elseif ($field->isNullable && ! $field->isList && ! $this->typeMapper->isConnectionType($field->type)) {
            $default = ' = null';
        } elseif ($field->isList && ! $this->typeMapper->isConnectionType($field->type)) {
            $default = ' = []';
        }

        $docComment = '';
        if ($field->isList || $this->typeMapper->isConnectionType($field->type)) {
            $docComment = "        /** @var {$phpDocType} */\n";
        }

        return "{$docComment}        public {$phpType} \${$field->name}{$default},";
    }

    /**
     * Generate the fromArray method body.
     *
     * @param  array<string, FieldDefinition>  $fields
     */
    private function generateFromArrayBody(array $fields): string
    {
        $preParsing = [];
        $constructorArgs = [];

        foreach ($fields as $field) {
            $parsing = $this->generateFieldParsing($field);

            if ($parsing['preParse'] !== null) {
                $preParsing[] = $parsing['preParse'];
            }

            $constructorArgs[] = $parsing['arg'];
        }

        $preParseCode = '';
        if (! empty($preParsing)) {
            $preParseCode = implode("\n\n", $preParsing)."\n\n        ";
        }

        $argsCode = implode("\n", $constructorArgs);

        return <<<PHP
        {$preParseCode}return new static(
{$argsCode}
            attributes: \$data,
        );
PHP;
    }

    /**
     * Generate parsing code for a single field.
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateFieldParsing(FieldDefinition $field): array
    {
        $type = $field->type;
        $isCarbon = $this->typeMapper->requiresImport($type) === 'Carbon\Carbon';
        $isEnum = $this->typeMapper->isEnum($type);
        $isScalar = $this->typeMapper->isScalar($type);

        if ($isCarbon) {
            return $this->generateCarbonParsing($field);
        }

        if ($isEnum && $field->isList) {
            return $this->generateEnumListParsing($field);
        }

        if ($isEnum) {
            return $this->generateEnumParsing($field);
        }

        if (! $isScalar && ! $field->isList) {
            return $this->generateNestedObjectParsing($field);
        }

        if (! $isScalar && $field->isList) {
            return $this->generateListParsing($field);
        }

        return [
            'preParse' => null,
            'arg' => $this->generateSimpleArg($field),
        ];
    }

    /**
     * Generate Carbon date parsing.
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateCarbonParsing(FieldDefinition $field): array
    {
        $name = $field->name;
        $fallback = $field->isNullable ? 'null' : 'Carbon::now()';

        return $this->createPreParseResult(
            $name,
            "isset(\$data['{$name}']) ? Carbon::parse(\$data['{$name}']) : {$fallback}"
        );
    }

    /**
     * Generate enum parsing using ::tryFrom() for safety.
     *
     * Always uses tryFrom because the API often returns null even for
     * schema-defined non-nullable enum fields.
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateEnumParsing(FieldDefinition $field): array
    {
        $name = $field->name;
        $type = $field->type;

        return $this->createPreParseResult(
            $name,
            "isset(\$data['{$name}']) ? {$type}::tryFrom(\$data['{$name}']) : null"
        );
    }

    /**
     * Generate enum list parsing (array of enums).
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateEnumListParsing(FieldDefinition $field): array
    {
        $name = $field->name;
        $type = $field->type;

        return $this->createPreParseResult(
            $name,
            "array_map(\n            fn (string \$value) => {$type}::from(\$value),\n            \$data['{$name}'] ?? []\n        )"
        );
    }

    /**
     * Generate nested object parsing.
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateNestedObjectParsing(FieldDefinition $field): array
    {
        $name = $field->name;
        $type = $field->type;

        // Skip Connection types - store as array
        if ($this->typeMapper->isConnectionType($type)) {
            return [
                'preParse' => null,
                'arg' => "            {$name}: \$data['{$name}'] ?? [],",
            ];
        }

        // Both nullable and non-nullable fields check for data existence
        // to handle sparse API responses where fields weren't requested
        return $this->createPreParseResult(
            $name,
            "isset(\$data['{$name}']) && is_array(\$data['{$name}'])\n            ? {$type}::fromArray(\$data['{$name}'])\n            : null"
        );
    }

    /**
     * Generate list/array parsing.
     *
     * @return array{preParse: ?string, arg: string}
     */
    private function generateListParsing(FieldDefinition $field): array
    {
        $name = $field->name;
        $type = $field->type;

        // Skip Connection types - store as array
        if ($this->typeMapper->isConnectionType($type)) {
            return [
                'preParse' => null,
                'arg' => "            {$name}: \$data['{$name}'] ?? [],",
            ];
        }

        // For list of objects, parse each item
        return $this->createPreParseResult(
            $name,
            "array_map(\n            fn (array \$item) => {$type}::fromArray(\$item),\n            \$data['{$name}'] ?? []\n        )"
        );
    }

    /**
     * Create a pre-parse result with consistent formatting.
     *
     * @return array{preParse: string, arg: string}
     */
    private function createPreParseResult(string $name, string $expression): array
    {
        return [
            'preParse' => "        \${$name} = {$expression};",
            'arg' => "            {$name}: \${$name},",
        ];
    }

    /**
     * Generate a simple scalar argument.
     */
    private function generateSimpleArg(FieldDefinition $field): string
    {
        $name = $field->name;

        if ($field->isList) {
            return "            {$name}: \$data['{$name}'] ?? [],";
        }

        if ($field->isNullable) {
            return "            {$name}: \$data['{$name}'] ?? null,";
        }

        // Non-nullable scalar - use empty string/0/false as fallback
        $default = match ($this->typeMapper->toPhpType($field)) {
            'int' => '0',
            'float' => '0.0',
            'bool' => 'false',
            default => "''",
        };

        return "            {$name}: \$data['{$name}'] ?? {$default},";
    }

    /**
     * Convert a type name to a safe PHP class name.
     *
     * Appends 'Data' suffix if the name is a PHP reserved keyword.
     */
    public function toSafeClassName(string $typeName): string
    {
        if ($this->isReservedKeyword($typeName)) {
            return $typeName.'Data';
        }

        return $typeName;
    }

    /**
     * Check if a name is a PHP reserved keyword (case-insensitive).
     */
    private function isReservedKeyword(string $name): bool
    {
        return in_array(strtolower($name), self::RESERVED_KEYWORDS, true);
    }

    /**
     * Generate the defaultFields() method body.
     *
     * @param  array<string, FieldDefinition>  $fields
     */
    private function generateDefaultFields(array $fields): string
    {
        $defaultFields = [];

        foreach ($fields as $field) {
            $fieldSelection = $this->getDefaultFieldSelection($field);

            if ($fieldSelection !== null) {
                $defaultFields[] = "'{$fieldSelection}'";
            }
        }

        return implode(",\n        ", $defaultFields);
    }

    /**
     * Get the default field selection string for a field, or null to skip it.
     */
    private function getDefaultFieldSelection(FieldDefinition $field): ?string
    {
        $type = $field->type;

        // Skip Connection types - too heavy for default selection
        if ($this->typeMapper->isConnectionType($type)) {
            return null;
        }

        // Skip list of objects - too heavy for default selection
        if ($field->isList && ! $this->typeMapper->isScalar($type) && ! $this->typeMapper->isEnum($type)) {
            return null;
        }

        // Scalar and enum fields get included by name directly
        if ($this->typeMapper->isScalar($type) || $this->typeMapper->isEnum($type)) {
            return $field->name;
        }

        // Handle timestamp fields with common subfields
        if ($type === 'ObjectTimestamps') {
            return "{$field->name} { createdAt updatedAt }";
        }

        // Skip nested objects without an 'id' field (can't select them safely)
        if (! $this->typeMapper->hasIdField($type)) {
            return null;
        }

        // Non-scalar nested objects with 'id' get { id } subselection
        return "{$field->name} { id }";
    }
}
