<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating a payment request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class PaymentRequestCreateInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public float $amount,
        public ?EmailInput $email = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $email = isset($data['email']) && is_array($data['email'])
            ? EmailInput::fromArray($data['email'])
            : null;

        return new static(
            amount: $data['amount'] ?? 0.0,
            email: $email,
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
            'amount',
        ];
    }
}
