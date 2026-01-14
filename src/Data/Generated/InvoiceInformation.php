<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Account invoice information
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class InvoiceInformation extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $currency,
        public float $salesTax,
        public bool $showInvoicePoNumber,
        public ?string $invoiceCommentary = null,
        public ?string $termsAndConditions = null,
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
            currency: $data['currency'] ?? '',
            invoiceCommentary: $data['invoiceCommentary'] ?? null,
            salesTax: $data['salesTax'] ?? 0.0,
            showInvoicePoNumber: $data['showInvoicePoNumber'] ?? false,
            termsAndConditions: $data['termsAndConditions'] ?? null,
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
            'currency',
            'invoiceCommentary',
            'salesTax',
            'showInvoicePoNumber',
            'termsAndConditions',
        ];
    }
}
