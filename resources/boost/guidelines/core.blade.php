## Laravel Printavo

This package provides an Eloquent-like interface to the Printavo GraphQL API. Query customers, orders, invoices, and more using familiar Laravel patterns.

### Configuration

Add credentials to `.env`:
```env
PRINTAVO_EMAIL=your-email@example.com
PRINTAVO_TOKEN=your-api-token
```

### Basic Queries

<code-snippet name="Basic Query Examples" lang="php">
use Brandonjjon\Printavo\Facades\Printavo;

// Get all (paginated, default 25)
$customers = Printavo::customers()->get();

// Find by ID
$customer = Printavo::customers()->find('abc123');

// Get first result
$customer = Printavo::customers()->first();

// Limit results
$customers = Printavo::customers()->take(10)->get();
</code-snippet>

### Typed Filter Methods

Each query builder has typed filter methods generated from the GraphQL schema. Use IDE autocomplete to discover available filters.

<code-snippet name="Filtering with Typed Methods" lang="php">
use Brandonjjon\Printavo\Facades\Printavo;
use Brandonjjon\Printavo\Data\Generated\Enums\OrderPaymentStatus;
use Brandonjjon\Printavo\Data\Generated\Enums\OrderSortField;

// Filter by enum
$unpaid = Printavo::invoices()
    ->paymentStatus(OrderPaymentStatus::Unpaid)
    ->get();

// Filter by date range (accepts string or DateTimeInterface)
$invoices = Printavo::invoices()
    ->inProductionAfter('2024-01-01')
    ->inProductionBefore('2024-12-31')
    ->get();

// Sort results
$invoices = Printavo::invoices()
    ->sortOn(OrderSortField::CustomerDueAt)
    ->sortDescending(true)
    ->get();

// Search with query string
$invoices = Printavo::invoices()->query('acme corp')->get();
</code-snippet>

### Field Selection

Use field constants for type-safe field selection:

<code-snippet name="Selecting Fields" lang="php">
use Brandonjjon\Printavo\Data\Generated\Fields\CustomerFields;

$customers = Printavo::customers()
    ->select([
        CustomerFields::ID,
        CustomerFields::COMPANY_NAME,
        CustomerFields::ORDER_COUNT,
    ])
    ->get();
</code-snippet>

### Pagination

<code-snippet name="Cursor-based Pagination" lang="php">
$page = Printavo::customers()->paginate(25);

foreach ($page->items() as $customer) {
    echo $customer->companyName;
}

if ($page->hasMorePages()) {
    $nextPage = Printavo::customers()
        ->cursor($page->getNextCursor())
        ->paginate(25);
}
</code-snippet>

### Mutations (Create, Update, Delete)

<code-snippet name="Creating Records" lang="php">
use Brandonjjon\Printavo\Data\Generated\CustomerCreateInput;

$response = Printavo::customerMutations()->create(
    new CustomerCreateInput(
        companyName: 'Acme Corp',
    )
);

if ($response->successful()) {
    $customer = $response->data();
}
</code-snippet>

<code-snippet name="Updating Records" lang="php">
use Brandonjjon\Printavo\Data\Generated\CustomerInput;

$response = Printavo::customerMutations()->update(
    'customer-id',
    new CustomerInput(companyName: 'Acme Corporation')
);
</code-snippet>

<code-snippet name="Deleting Records" lang="php">
$response = Printavo::customerMutations()->delete('customer-id');
</code-snippet>

### Available Resources

**Queries:** `customers()`, `contacts()`, `invoices()`, `orders()`, `quotes()`, `tasks()`, `threads()`, `statuses()`, `merchStores()`, `paymentRequests()`, `products()`, `inquiries()`, `transactions()`

**Mutations:** `customerMutations()`, `contactMutations()`, `invoiceMutations()`, `quoteMutations()`, `taskMutations()`, `lineItemMutations()`, `lineItemGroupMutations()`, `feeMutations()`, `imprintMutations()`, `customAddressMutations()`, `transactionPaymentMutations()`, `threadMutations()`

### DTOs and Type Safety

All responses are hydrated into typed Data Transfer Objects:

<code-snippet name="Working with DTOs" lang="php">
$customer = Printavo::customers()->find('abc123');

// All properties are typed
$customer->id;           // string
$customer->companyName;  // ?string
$customer->orderCount;   // ?int
$customer->timestamps->createdAt; // ?Carbon
</code-snippet>

### Error Handling

<code-snippet name="Handling Errors" lang="php">
use Brandonjjon\Printavo\Exceptions\PrintavoException;
use Brandonjjon\Printavo\Exceptions\RateLimitException;

try {
    $customers = Printavo::customers()->get();
} catch (RateLimitException $e) {
    // Only thrown if PRINTAVO_RATE_LIMIT_BEHAVIOR=throw
} catch (PrintavoException $e) {
    echo $e->getMessage();
}
</code-snippet>
