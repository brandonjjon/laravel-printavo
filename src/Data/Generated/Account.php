<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * Account
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class Account extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $approvals,
        public ?CatalogInformation $catalogInformation,
        /** @var array<mixed> */
        public array $categories,
        public string $companyEmail,
        /** @var array<mixed> */
        public array $deliveryMethods,
        /** @var array<mixed> */
        public array $emailTemplates,
        public ?LineItemEnabledColumns $enabledLineItemGroupColumns,
        public ?InvoiceInformation $invoiceInformation,
        public string $locale,
        /** @var array<mixed> */
        public array $orderStatuses,
        public bool $paymentProcessorPresent,
        /** @var array<mixed> */
        public array $paymentTerms = [],
        /** @var array<mixed> */
        public array $presetTaskGroups = [],
        /** @var array<mixed> */
        public array $pricingMatrices = [],
        public ?Social $social = null,
        public ?ObjectTimestamps $timestamps = null,
        /** @var array<mixed> */
        public array $typesOfWork = [],
        public ?Address $address = null,
        public ?string $companyName = null,
        /** @var array<Feature> */
        public array $features = [],
        /** @var array<LineItemGroupSize> */
        public array $lineItemGroupSizes = [],
        public ?string $logoUrl = null,
        public ?string $phone = null,
        /** @var array<mixed> */
        public ?array $users = [],
        public ?string $website = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $address = isset($data['address']) && is_array($data['address'])
            ? Address::fromArray($data['address'])
            : null;

        $catalogInformation = isset($data['catalogInformation']) && is_array($data['catalogInformation'])
            ? CatalogInformation::fromArray($data['catalogInformation'])
            : null;

        $enabledLineItemGroupColumns = isset($data['enabledLineItemGroupColumns']) && is_array($data['enabledLineItemGroupColumns'])
            ? LineItemEnabledColumns::fromArray($data['enabledLineItemGroupColumns'])
            : null;

        $features = array_map(
            fn (array $item) => Feature::fromArray($item),
            $data['features'] ?? []
        );

        $invoiceInformation = isset($data['invoiceInformation']) && is_array($data['invoiceInformation'])
            ? InvoiceInformation::fromArray($data['invoiceInformation'])
            : null;

        $lineItemGroupSizes = array_map(
            fn (array $item) => LineItemGroupSize::fromArray($item),
            $data['lineItemGroupSizes'] ?? []
        );

        $social = isset($data['social']) && is_array($data['social'])
            ? Social::fromArray($data['social'])
            : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            address: $address,
            approvals: $data['approvals'] ?? [],
            catalogInformation: $catalogInformation,
            categories: $data['categories'] ?? [],
            companyEmail: $data['companyEmail'] ?? '',
            companyName: $data['companyName'] ?? null,
            deliveryMethods: $data['deliveryMethods'] ?? [],
            emailTemplates: $data['emailTemplates'] ?? [],
            enabledLineItemGroupColumns: $enabledLineItemGroupColumns,
            features: $features,
            id: $data['id'] ?? '',
            invoiceInformation: $invoiceInformation,
            lineItemGroupSizes: $lineItemGroupSizes,
            locale: $data['locale'] ?? '',
            logoUrl: $data['logoUrl'] ?? null,
            orderStatuses: $data['orderStatuses'] ?? [],
            paymentProcessorPresent: $data['paymentProcessorPresent'] ?? false,
            paymentTerms: $data['paymentTerms'] ?? [],
            phone: $data['phone'] ?? null,
            presetTaskGroups: $data['presetTaskGroups'] ?? [],
            pricingMatrices: $data['pricingMatrices'] ?? [],
            social: $social,
            timestamps: $timestamps,
            typesOfWork: $data['typesOfWork'] ?? [],
            users: $data['users'] ?? [],
            website: $data['website'] ?? null,
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
            'companyEmail',
            'companyName',
            'id',
            'locale',
            'logoUrl',
            'paymentProcessorPresent',
            'phone',
            'timestamps { createdAt updatedAt }',
            'website',
        ];
    }
}
