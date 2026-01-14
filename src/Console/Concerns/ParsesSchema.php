<?php

namespace Brandonjjon\Printavo\Console\Concerns;

use Brandonjjon\Printavo\Exceptions\AuthenticationException;
use Brandonjjon\Printavo\Exceptions\PrintavoException;
use Brandonjjon\Printavo\PrintavoClient;
use Brandonjjon\Printavo\Schema\FieldDefinition;
use Brandonjjon\Printavo\Schema\IntrospectionQuery;
use Brandonjjon\Printavo\Schema\ParsedSchema;
use Brandonjjon\Printavo\Schema\SchemaParser;
use Brandonjjon\Printavo\Schema\TypeDefinition;

/**
 * Shared schema parsing functionality for Printavo console commands.
 */
trait ParsesSchema
{
    /**
     * Load schema with console output messaging.
     *
     * Use this in commands that have --fresh and --schema options.
     */
    protected function loadSchemaWithOutput(PrintavoClient $client): ParsedSchema
    {
        $fresh = (bool) $this->option('fresh');
        $schemaPath = $this->option('schema') ?? $this->defaultSchemaPath();

        if ($fresh) {
            $this->info('Fetching fresh schema from Printavo API...');
        } else {
            $this->info("Loading schema from {$schemaPath}...");
        }

        $this->newLine();

        return $this->loadSchemaFromFileOrApi($client, $schemaPath, $fresh);
    }

    /**
     * Load schema from file or fetch fresh from API.
     */
    protected function loadSchemaFromFileOrApi(PrintavoClient $client, string $schemaPath, bool $fresh): ParsedSchema
    {
        if ($fresh) {
            return $this->fetchFreshSchema($client);
        }

        if (! file_exists($schemaPath)) {
            throw new \RuntimeException(
                "Schema file not found at {$schemaPath}. ".
                "Run 'php artisan printavo:schema:fetch' first or use --fresh option."
            );
        }

        $json = file_get_contents($schemaPath);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON in schema file: '.json_last_error_msg());
        }

        return $this->parseSerializedSchema($data);
    }

    /**
     * Get the default schema file path.
     */
    protected function defaultSchemaPath(): string
    {
        return base_path('packages/printavo/schema.json');
    }

    /**
     * Fetch fresh schema from the Printavo API.
     */
    protected function fetchFreshSchema(PrintavoClient $client): ParsedSchema
    {
        $introspection = new IntrospectionQuery($client);
        $rawData = $introspection->fetch();

        $parser = new SchemaParser;

        return $parser->parse($rawData);
    }

    /**
     * Parse schema from serialized JSON format.
     *
     * @param  array<string, mixed>  $data
     */
    protected function parseSerializedSchema(array $data): ParsedSchema
    {
        $types = [];

        foreach ($data['types'] ?? [] as $typeData) {
            $type = $this->parseSerializedType($typeData);
            $types[$type->name] = $type;
        }

        return new ParsedSchema(
            queryTypeName: $data['queryTypeName'] ?? 'Query',
            mutationTypeName: $data['mutationTypeName'] ?? null,
            types: $types,
        );
    }

    /**
     * Parse a type from serialized format.
     *
     * @param  array<string, mixed>  $typeData
     */
    protected function parseSerializedType(array $typeData): TypeDefinition
    {
        $fields = [];
        foreach ($typeData['fields'] ?? [] as $fieldData) {
            $field = $this->parseSerializedField($fieldData);
            $fields[$field->name] = $field;
        }

        $inputFields = [];
        foreach ($typeData['inputFields'] ?? [] as $fieldData) {
            $field = $this->parseSerializedField($fieldData);
            $inputFields[$field->name] = $field;
        }

        return new TypeDefinition(
            kind: $typeData['kind'] ?? 'OBJECT',
            name: $typeData['name'] ?? '',
            description: $typeData['description'] ?? null,
            fields: $fields,
            inputFields: $inputFields,
            enumValues: $typeData['enumValues'] ?? [],
            interfaces: $typeData['interfaces'] ?? [],
            possibleTypes: $typeData['possibleTypes'] ?? [],
        );
    }

    /**
     * Parse a field from serialized format.
     *
     * @param  array<string, mixed>  $fieldData
     */
    protected function parseSerializedField(array $fieldData): FieldDefinition
    {
        return new FieldDefinition(
            name: $fieldData['name'] ?? '',
            description: $fieldData['description'] ?? null,
            type: $fieldData['type'] ?? 'Unknown',
            isNullable: $fieldData['isNullable'] ?? true,
            isList: $fieldData['isList'] ?? false,
            isListItemNullable: $fieldData['isListItemNullable'] ?? true,
            args: [],
            isDeprecated: $fieldData['isDeprecated'] ?? false,
            deprecationReason: $fieldData['deprecationReason'] ?? null,
        );
    }

    /**
     * Handle common API exceptions with consistent error output.
     *
     * @return int Command exit code (FAILURE)
     */
    protected function handleApiException(\Throwable $e, string $context = 'generate code'): int
    {
        if ($e instanceof AuthenticationException) {
            $this->components->error('Authentication failed');
            $this->newLine();
            $this->warn('Check your PRINTAVO_EMAIL and PRINTAVO_TOKEN in .env');

            return self::FAILURE;
        }

        if ($e instanceof PrintavoException) {
            $this->components->error('Printavo API error: '.$e->getMessage());

            return self::FAILURE;
        }

        $this->components->error("Failed to {$context}: ".$e->getMessage());

        return self::FAILURE;
    }
}
