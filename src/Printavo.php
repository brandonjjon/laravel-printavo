<?php

namespace Brandonjjon\Printavo;

use Brandonjjon\Printavo\Mutations\Generated\ApprovalRequestMutations;
use Brandonjjon\Printavo\Mutations\Generated\ContactMutations;
use Brandonjjon\Printavo\Mutations\Generated\CustomAddressMutations;
use Brandonjjon\Printavo\Mutations\Generated\CustomerMutations;
use Brandonjjon\Printavo\Mutations\Generated\DeliveryMethodMutations;
use Brandonjjon\Printavo\Mutations\Generated\EmailMessageMutations;
use Brandonjjon\Printavo\Mutations\Generated\FeeMutations;
use Brandonjjon\Printavo\Mutations\Generated\ImprintMockupMutations;
use Brandonjjon\Printavo\Mutations\Generated\ImprintMutations;
use Brandonjjon\Printavo\Mutations\Generated\InquiryMutations;
use Brandonjjon\Printavo\Mutations\Generated\InvoiceMutations;
use Brandonjjon\Printavo\Mutations\Generated\LineItemGroupMutations;
use Brandonjjon\Printavo\Mutations\Generated\LineItemMockupMutations;
use Brandonjjon\Printavo\Mutations\Generated\LineItemMutations;
use Brandonjjon\Printavo\Mutations\Generated\MockupMutations;
use Brandonjjon\Printavo\Mutations\Generated\PaymentRequestMutations;
use Brandonjjon\Printavo\Mutations\Generated\PaymentTermMutations;
use Brandonjjon\Printavo\Mutations\Generated\PresetTaskGroupMutations;
use Brandonjjon\Printavo\Mutations\Generated\PresetTaskMutations;
use Brandonjjon\Printavo\Mutations\Generated\ProductionFileMutations;
use Brandonjjon\Printavo\Mutations\Generated\QuoteMutations;
use Brandonjjon\Printavo\Mutations\Generated\StatusMutations;
use Brandonjjon\Printavo\Mutations\Generated\TaskMutations;
use Brandonjjon\Printavo\Mutations\Generated\ThreadMutations;
use Brandonjjon\Printavo\Mutations\Generated\TransactionPaymentMutations;
use Brandonjjon\Printavo\Resources\Generated\ContactsBuilder;
use Brandonjjon\Printavo\Resources\Generated\CustomersBuilder;
use Brandonjjon\Printavo\Resources\Generated\InquiriesBuilder;
use Brandonjjon\Printavo\Resources\Generated\InvoicesBuilder;
use Brandonjjon\Printavo\Resources\Generated\MerchStoresBuilder;
use Brandonjjon\Printavo\Resources\Generated\OrdersBuilder;
use Brandonjjon\Printavo\Resources\Generated\PaymentRequestsBuilder;
use Brandonjjon\Printavo\Resources\Generated\ProductsBuilder;
use Brandonjjon\Printavo\Resources\Generated\QuotesBuilder;
use Brandonjjon\Printavo\Resources\Generated\StatusesBuilder;
use Brandonjjon\Printavo\Resources\Generated\TasksBuilder;
use Brandonjjon\Printavo\Resources\Generated\ThreadsBuilder;
use Brandonjjon\Printavo\Resources\Generated\TransactionsBuilder;

/**
 * Printavo API manager.
 *
 * Provides fluent access to all Printavo resources and mutations.
 *
 * @generated from generated builders - do not edit manually
 */
class Printavo
{
    /**
     * Create a new Printavo manager instance.
     */
    public function __construct(
        protected readonly PrintavoClient $client,
    ) {}

    /**
     * Get a mutation builder for approvalrequests.
     */
    public function approvalRequestMutations(): ApprovalRequestMutations
    {
        return new ApprovalRequestMutations($this->client);
    }

    /**
     * Get a mutation builder for contacts.
     */
    public function contactMutations(): ContactMutations
    {
        return new ContactMutations($this->client);
    }

    /**
     * Get a query builder for contacts.
     */
    public function contacts(): ContactsBuilder
    {
        return new ContactsBuilder($this->client);
    }

    /**
     * Get a mutation builder for customaddresss.
     */
    public function customAddressMutations(): CustomAddressMutations
    {
        return new CustomAddressMutations($this->client);
    }

    /**
     * Get a mutation builder for customers.
     */
    public function customerMutations(): CustomerMutations
    {
        return new CustomerMutations($this->client);
    }

    /**
     * Get a query builder for customers.
     */
    public function customers(): CustomersBuilder
    {
        return new CustomersBuilder($this->client);
    }

    /**
     * Get a mutation builder for deliverymethods.
     */
    public function deliveryMethodMutations(): DeliveryMethodMutations
    {
        return new DeliveryMethodMutations($this->client);
    }

    /**
     * Get a mutation builder for emailmessages.
     */
    public function emailMessageMutations(): EmailMessageMutations
    {
        return new EmailMessageMutations($this->client);
    }

    /**
     * Get a mutation builder for fees.
     */
    public function feeMutations(): FeeMutations
    {
        return new FeeMutations($this->client);
    }

    /**
     * Get a mutation builder for imprintmockups.
     */
    public function imprintMockupMutations(): ImprintMockupMutations
    {
        return new ImprintMockupMutations($this->client);
    }

    /**
     * Get a mutation builder for imprints.
     */
    public function imprintMutations(): ImprintMutations
    {
        return new ImprintMutations($this->client);
    }

    /**
     * Get a query builder for inquiries.
     */
    public function inquiries(): InquiriesBuilder
    {
        return new InquiriesBuilder($this->client);
    }

    /**
     * Get a mutation builder for inquirys.
     */
    public function inquiryMutations(): InquiryMutations
    {
        return new InquiryMutations($this->client);
    }

    /**
     * Get a mutation builder for invoices.
     */
    public function invoiceMutations(): InvoiceMutations
    {
        return new InvoiceMutations($this->client);
    }

    /**
     * Get a query builder for invoices.
     */
    public function invoices(): InvoicesBuilder
    {
        return new InvoicesBuilder($this->client);
    }

    /**
     * Get a mutation builder for lineitemgroups.
     */
    public function lineItemGroupMutations(): LineItemGroupMutations
    {
        return new LineItemGroupMutations($this->client);
    }

    /**
     * Get a mutation builder for lineitemmockups.
     */
    public function lineItemMockupMutations(): LineItemMockupMutations
    {
        return new LineItemMockupMutations($this->client);
    }

    /**
     * Get a mutation builder for lineitems.
     */
    public function lineItemMutations(): LineItemMutations
    {
        return new LineItemMutations($this->client);
    }

    /**
     * Get a query builder for merchStores.
     */
    public function merchStores(): MerchStoresBuilder
    {
        return new MerchStoresBuilder($this->client);
    }

    /**
     * Get a mutation builder for mockups.
     */
    public function mockupMutations(): MockupMutations
    {
        return new MockupMutations($this->client);
    }

    /**
     * Get a query builder for orders.
     */
    public function orders(): OrdersBuilder
    {
        return new OrdersBuilder($this->client);
    }

    /**
     * Get a mutation builder for paymentrequests.
     */
    public function paymentRequestMutations(): PaymentRequestMutations
    {
        return new PaymentRequestMutations($this->client);
    }

    /**
     * Get a query builder for paymentRequests.
     */
    public function paymentRequests(): PaymentRequestsBuilder
    {
        return new PaymentRequestsBuilder($this->client);
    }

    /**
     * Get a mutation builder for paymentterms.
     */
    public function paymentTermMutations(): PaymentTermMutations
    {
        return new PaymentTermMutations($this->client);
    }

    /**
     * Get a mutation builder for presettaskgroups.
     */
    public function presetTaskGroupMutations(): PresetTaskGroupMutations
    {
        return new PresetTaskGroupMutations($this->client);
    }

    /**
     * Get a mutation builder for presettasks.
     */
    public function presetTaskMutations(): PresetTaskMutations
    {
        return new PresetTaskMutations($this->client);
    }

    /**
     * Get a mutation builder for productionfiles.
     */
    public function productionFileMutations(): ProductionFileMutations
    {
        return new ProductionFileMutations($this->client);
    }

    /**
     * Get a query builder for products.
     */
    public function products(): ProductsBuilder
    {
        return new ProductsBuilder($this->client);
    }

    /**
     * Get a mutation builder for quotes.
     */
    public function quoteMutations(): QuoteMutations
    {
        return new QuoteMutations($this->client);
    }

    /**
     * Get a query builder for quotes.
     */
    public function quotes(): QuotesBuilder
    {
        return new QuotesBuilder($this->client);
    }

    /**
     * Get a mutation builder for statuss.
     */
    public function statusMutations(): StatusMutations
    {
        return new StatusMutations($this->client);
    }

    /**
     * Get a query builder for statuses.
     */
    public function statuses(): StatusesBuilder
    {
        return new StatusesBuilder($this->client);
    }

    /**
     * Get a mutation builder for tasks.
     */
    public function taskMutations(): TaskMutations
    {
        return new TaskMutations($this->client);
    }

    /**
     * Get a query builder for tasks.
     */
    public function tasks(): TasksBuilder
    {
        return new TasksBuilder($this->client);
    }

    /**
     * Get a mutation builder for threads.
     */
    public function threadMutations(): ThreadMutations
    {
        return new ThreadMutations($this->client);
    }

    /**
     * Get a query builder for threads.
     */
    public function threads(): ThreadsBuilder
    {
        return new ThreadsBuilder($this->client);
    }

    /**
     * Get a mutation builder for transactionpayments.
     */
    public function transactionPaymentMutations(): TransactionPaymentMutations
    {
        return new TransactionPaymentMutations($this->client);
    }

    /**
     * Get a query builder for transactions.
     */
    public function transactions(): TransactionsBuilder
    {
        return new TransactionsBuilder($this->client);
    }
}
