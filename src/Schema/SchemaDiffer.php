<?php

namespace Brandonjjon\Printavo\Schema;

/**
 * Compares two ParsedSchema instances and produces a structured diff report.
 */
class SchemaDiffer
{
    /**
     * Compare two schemas and produce a diff report.
     */
    public function diff(ParsedSchema $old, ParsedSchema $new): SchemaDiff
    {
        $oldTypeNames = array_keys($old->types);
        $newTypeNames = array_keys($new->types);

        $typesAdded = array_diff($newTypeNames, $oldTypeNames);
        $typesRemoved = array_diff($oldTypeNames, $newTypeNames);
        $commonTypes = array_intersect($oldTypeNames, $newTypeNames);

        $typesModified = [];

        foreach ($commonTypes as $typeName) {
            $oldType = $old->types[$typeName];
            $newType = $new->types[$typeName];

            $fieldChanges = $this->diffType($oldType, $newType);

            if (! $fieldChanges->isEmpty()) {
                $typesModified[$typeName] = $fieldChanges;
            }
        }

        return new SchemaDiff(
            typesAdded: array_values($typesAdded),
            typesRemoved: array_values($typesRemoved),
            typesModified: $typesModified,
        );
    }

    /**
     * Compare two types and produce field-level changes.
     */
    protected function diffType(TypeDefinition $old, TypeDefinition $new): FieldChanges
    {
        // Get fields based on type kind
        $oldFields = $old->isInput() ? $old->inputFields : $old->fields;
        $newFields = $new->isInput() ? $new->inputFields : $new->fields;

        $oldFieldNames = array_keys($oldFields);
        $newFieldNames = array_keys($newFields);

        $fieldsAdded = array_diff($newFieldNames, $oldFieldNames);
        $fieldsRemoved = array_diff($oldFieldNames, $newFieldNames);
        $commonFields = array_intersect($oldFieldNames, $newFieldNames);

        $fieldsTypeChanged = [];

        foreach ($commonFields as $fieldName) {
            $oldField = $oldFields[$fieldName];
            $newField = $newFields[$fieldName];

            if ($oldField->type !== $newField->type) {
                $fieldsTypeChanged[$fieldName] = [
                    'old' => $oldField->type,
                    'new' => $newField->type,
                ];
            }
        }

        // Also diff enum values if this is an enum type
        $enumValuesAdded = [];
        $enumValuesRemoved = [];

        if ($old->isEnum() && $new->isEnum()) {
            $enumValuesAdded = array_diff($new->enumValues, $old->enumValues);
            $enumValuesRemoved = array_diff($old->enumValues, $new->enumValues);
        }

        return new FieldChanges(
            fieldsAdded: array_values($fieldsAdded),
            fieldsRemoved: array_values($fieldsRemoved),
            fieldsTypeChanged: $fieldsTypeChanged,
            enumValuesAdded: array_values($enumValuesAdded),
            enumValuesRemoved: array_values($enumValuesRemoved),
        );
    }
}

/**
 * Represents the diff result between two schemas.
 */
readonly class SchemaDiff
{
    /**
     * @param  array<string>  $typesAdded
     * @param  array<string>  $typesRemoved
     * @param  array<string, FieldChanges>  $typesModified
     */
    public function __construct(
        public array $typesAdded,
        public array $typesRemoved,
        public array $typesModified,
    ) {}

    /**
     * Check if there are no changes.
     */
    public function isEmpty(): bool
    {
        return empty($this->typesAdded)
            && empty($this->typesRemoved)
            && empty($this->typesModified);
    }

    /**
     * Convert to array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'typesAdded' => $this->typesAdded,
            'typesRemoved' => $this->typesRemoved,
            'typesModified' => array_map(
                fn (FieldChanges $changes) => $changes->toArray(),
                $this->typesModified
            ),
        ];
    }
}

/**
 * Represents field-level changes within a type.
 */
readonly class FieldChanges
{
    /**
     * @param  array<string>  $fieldsAdded
     * @param  array<string>  $fieldsRemoved
     * @param  array<string, array{old: string, new: string}>  $fieldsTypeChanged
     * @param  array<string>  $enumValuesAdded
     * @param  array<string>  $enumValuesRemoved
     */
    public function __construct(
        public array $fieldsAdded,
        public array $fieldsRemoved,
        public array $fieldsTypeChanged,
        public array $enumValuesAdded = [],
        public array $enumValuesRemoved = [],
    ) {}

    /**
     * Check if there are no field changes.
     */
    public function isEmpty(): bool
    {
        return empty($this->fieldsAdded)
            && empty($this->fieldsRemoved)
            && empty($this->fieldsTypeChanged)
            && empty($this->enumValuesAdded)
            && empty($this->enumValuesRemoved);
    }

    /**
     * Convert to array for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'fieldsAdded' => $this->fieldsAdded,
            'fieldsRemoved' => $this->fieldsRemoved,
            'fieldsTypeChanged' => $this->fieldsTypeChanged,
            'enumValuesAdded' => $this->enumValuesAdded,
            'enumValuesRemoved' => $this->enumValuesRemoved,
        ];
    }
}
