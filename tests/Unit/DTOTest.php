<?php

use Brandonjjon\Printavo\Data\Generated\Customer;
use Brandonjjon\Printavo\Data\Generated\ObjectTimestamps;
use Carbon\Carbon;

it('can create Customer DTO from array', function () {
    $data = [
        'id' => 'cust_123',
        'companyName' => 'Acme Corp',
        'orderCount' => 5,
        'publicUrl' => 'https://printavo.com/customers/123',
        'taxExempt' => false,
        'contacts' => [],
        'orders' => [],
        'reminders' => [],
    ];

    $customer = Customer::fromArray($data);

    expect($customer)->toBeInstanceOf(Customer::class)
        ->and($customer->id)->toBe('cust_123')
        ->and($customer->companyName)->toBe('Acme Corp')
        ->and($customer->orderCount)->toBe(5)
        ->and($customer->publicUrl)->toBe('https://printavo.com/customers/123')
        ->and($customer->taxExempt)->toBe(false);
});

it('handles nullable fields correctly', function () {
    $data = [
        'id' => 'cust_456',
        'orderCount' => 0,
        'publicUrl' => '',
        'taxExempt' => true,
        'contacts' => [],
        'orders' => [],
        'reminders' => [],
        // companyName is not provided - should be null
        // internalNote is not provided - should be null
    ];

    $customer = Customer::fromArray($data);

    expect($customer->companyName)->toBeNull()
        ->and($customer->internalNote)->toBeNull()
        ->and($customer->resaleNumber)->toBeNull()
        ->and($customer->salesTax)->toBeNull()
        ->and($customer->billingAddress)->toBeNull()
        ->and($customer->shippingAddress)->toBeNull();
});

it('converts date strings to Carbon instances', function () {
    $data = [
        'createdAt' => '2025-01-15T10:30:00Z',
        'updatedAt' => '2025-01-16T14:45:00Z',
    ];

    $timestamps = ObjectTimestamps::fromArray($data);

    expect($timestamps->createdAt)->toBeInstanceOf(Carbon::class)
        ->and($timestamps->updatedAt)->toBeInstanceOf(Carbon::class)
        ->and($timestamps->createdAt->toIso8601String())->toBe('2025-01-15T10:30:00+00:00')
        ->and($timestamps->updatedAt->toIso8601String())->toBe('2025-01-16T14:45:00+00:00');
});

it('provides default fields for API queries', function () {
    $defaultFields = Customer::defaultFields();

    expect($defaultFields)->toBeArray()
        ->and($defaultFields)->toContain('id')
        ->and($defaultFields)->toContain('companyName')
        ->and($defaultFields)->toContain('orderCount');
});

it('can access raw attributes via toArray', function () {
    $data = [
        'id' => 'cust_789',
        'companyName' => 'Test Company',
        'orderCount' => 10,
        'publicUrl' => 'https://example.com',
        'taxExempt' => false,
        'contacts' => [],
        'orders' => [],
        'reminders' => [],
        'customField' => 'custom value',
    ];

    $customer = Customer::fromArray($data);

    expect($customer->toArray())->toBe($data)
        ->and($customer->toArray()['customField'])->toBe('custom value');
});

it('hydrates nested objects correctly', function () {
    $data = [
        'id' => 'cust_nested',
        'companyName' => 'Nested Test',
        'orderCount' => 3,
        'publicUrl' => 'https://example.com',
        'taxExempt' => false,
        'contacts' => [],
        'orders' => [],
        'reminders' => [],
        'timestamps' => [
            'createdAt' => '2025-01-10T08:00:00Z',
            'updatedAt' => '2025-01-12T12:00:00Z',
        ],
    ];

    $customer = Customer::fromArray($data);

    expect($customer->timestamps)->toBeInstanceOf(ObjectTimestamps::class)
        ->and($customer->timestamps->createdAt)->toBeInstanceOf(Carbon::class);
});
