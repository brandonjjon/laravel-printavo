<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Parses raw GraphQL introspection response into ParsedSchema.
 */
class SchemaParser
{
    /**
     * Parse raw introspection response into a ParsedSchema.
     *
     * @param  array<string, mixed>  $introspectionData  The full introspection response (contains __schema)
     */
    public function parse(array $introspectionData): ParsedSchema
    {
        $schemaData = $introspectionData['__schema'] ?? [];

        return ParsedSchema::fromIntrospection($schemaData);
    }
}
