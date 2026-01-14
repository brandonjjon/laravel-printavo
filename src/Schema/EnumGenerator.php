<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Generates PHP enum classes from GraphQL enum type definitions.
 */
readonly class EnumGenerator
{
    /**
     * Generate complete PHP enum code from a type definition.
     */
    public function generate(TypeDefinition $type): string
    {
        $cases = $this->generateCases($type->enumValues);
        $description = $type->description ? " * {$type->description}\n *\n" : '';

        return <<<PHP
<?php

namespace Brandonjjon\Printavo\Data\Generated\Enums;

/**
{$description} * @generated from GraphQL schema - do not edit manually
 */
enum {$type->name}: string
{
{$cases}
}
PHP;
    }

    /**
     * Check if this type should have an enum generated.
     *
     * Returns true only for ENUM kind types.
     */
    public function shouldGenerate(TypeDefinition $type): bool
    {
        return $type->isEnum();
    }

    /**
     * Generate enum case declarations.
     *
     * @param  array<string>  $values
     */
    private function generateCases(array $values): string
    {
        $cases = [];

        foreach ($values as $value) {
            $caseName = $this->convertToTitleCase($value);
            $cases[] = "    case {$caseName} = '{$value}';";
        }

        return implode("\n", $cases);
    }

    /**
     * Convert SCREAMING_SNAKE_CASE to TitleCase.
     *
     * Examples:
     * - VALUE_ONE -> ValueOne
     * - SOME_STATUS -> SomeStatus
     * - ACTIVE -> Active
     */
    private function convertToTitleCase(string $screamingSnake): string
    {
        // Split by underscores
        $parts = explode('_', strtolower($screamingSnake));

        // Capitalize first letter of each part
        $parts = array_map(fn ($part) => ucfirst($part), $parts);

        return implode('', $parts);
    }
}
