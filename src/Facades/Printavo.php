<?php

namespace Brandonjjon\Printavo\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ApprovalRequestMutations approvalRequestMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ContactMutations contactMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\CustomAddressMutations customAddressMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\CustomerMutations customerMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\DeliveryMethodMutations deliveryMethodMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\EmailMessageMutations emailMessageMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\FeeMutations feeMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ImprintMockupMutations imprintMockupMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ImprintMutations imprintMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\InquiryMutations inquiryMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\InvoiceMutations invoiceMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\LineItemGroupMutations lineItemGroupMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\LineItemMockupMutations lineItemMockupMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\LineItemMutations lineItemMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\MockupMutations mockupMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\PaymentRequestMutations paymentRequestMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\PaymentTermMutations paymentTermMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\PresetTaskGroupMutations presetTaskGroupMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\PresetTaskMutations presetTaskMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ProductionFileMutations productionFileMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\QuoteMutations quoteMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\StatusMutations statusMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\TaskMutations taskMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\ThreadMutations threadMutations()
 * @method static \Brandonjjon\Printavo\Mutations\Generated\TransactionPaymentMutations transactionPaymentMutations()
 * @method static \Brandonjjon\Printavo\Resources\Generated\ContactsBuilder contacts()
 * @method static \Brandonjjon\Printavo\Resources\Generated\CustomersBuilder customers()
 * @method static \Brandonjjon\Printavo\Resources\Generated\InquiriesBuilder inquiries()
 * @method static \Brandonjjon\Printavo\Resources\Generated\InvoicesBuilder invoices()
 * @method static \Brandonjjon\Printavo\Resources\Generated\MerchStoresBuilder merchStores()
 * @method static \Brandonjjon\Printavo\Resources\Generated\OrdersBuilder orders()
 * @method static \Brandonjjon\Printavo\Resources\Generated\PaymentRequestsBuilder paymentRequests()
 * @method static \Brandonjjon\Printavo\Resources\Generated\ProductsBuilder products()
 * @method static \Brandonjjon\Printavo\Resources\Generated\QuotesBuilder quotes()
 * @method static \Brandonjjon\Printavo\Resources\Generated\StatusesBuilder statuses()
 * @method static \Brandonjjon\Printavo\Resources\Generated\TasksBuilder tasks()
 * @method static \Brandonjjon\Printavo\Resources\Generated\ThreadsBuilder threads()
 * @method static \Brandonjjon\Printavo\Resources\Generated\TransactionsBuilder transactions()
 *
 * @see \Brandonjjon\Printavo\Printavo
 */
class Printavo extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'printavo.manager';
    }
}
