<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating an approval request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class ApprovalRequestCreateInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?IDInput $requester = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $requester = isset($data['requester']) && is_array($data['requester'])
            ? IDInput::fromArray($data['requester'])
            : null;

        return new static(
            requester: $requester,
            id: $data['id'] ?? '',
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
            'requester { id }',
            'id',
        ];
    }
}
