<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Input for creating an email message
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class EmailMessageInput extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $subject,
        public string $text,
        /** @var array<string> */
        public array $bcc = [],
        /** @var array<string> */
        public array $cc = [],
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
            subject: $data['subject'] ?? '',
            text: $data['text'] ?? '',
            bcc: $data['bcc'] ?? [],
            cc: $data['cc'] ?? [],
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
            'subject',
            'text',
            'bcc',
            'cc',
            'to',
        ];
    }
}
