<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Carbon\Carbon;

/**
 * Object created and updated dates
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ObjectTimestamps extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public Carbon $createdAt,
        public Carbon $updatedAt,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $createdAt = isset($data['createdAt']) ? Carbon::parse($data['createdAt']) : Carbon::now();

        $updatedAt = isset($data['updatedAt']) ? Carbon::parse($data['updatedAt']) : Carbon::now();

        return new static(
            createdAt: $createdAt,
            updatedAt: $updatedAt,
            attributes: $data,
        );
    }

    /**
     * Get the default fields to request from the API.
     *
     * @return array<string>
     */
    public static function defaultFields(): array
    {
        return [
            'createdAt',
            'updatedAt',
        ];
    }
}
