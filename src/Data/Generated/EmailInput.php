<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for email fields on a payment request
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class EmailInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $body,
        /** @var array<string> */
        public array $cc = [],
        public ?string $subject = null,
        /** @var array<string> */
        public array $to = [],
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        return new static(
            body: $data['body'] ?? '',
            cc: $data['cc'] ?? [],
            subject: $data['subject'] ?? null,
            to: $data['to'] ?? [],
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
            'body',
            'cc',
            'subject',
            'to',
        ];
    }
}
