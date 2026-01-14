<?php

use Brandonjjon\Printavo\Printavo;
use Brandonjjon\Printavo\Resources\Generated\ContactsBuilder;
use Brandonjjon\Printavo\Resources\Generated\CustomersBuilder;
use Brandonjjon\Printavo\Resources\Generated\InvoicesBuilder;
use Brandonjjon\Printavo\Resources\Generated\MerchStoresBuilder;
use Brandonjjon\Printavo\Resources\Generated\QuotesBuilder;
use Brandonjjon\Printavo\Resources\Generated\TasksBuilder;
use Brandonjjon\Printavo\Resources\Generated\ThreadsBuilder;

it('can access customers builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->customers())->toBeInstanceOf(CustomersBuilder::class);
});

it('can access invoices builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->invoices())->toBeInstanceOf(InvoicesBuilder::class);
});

it('can access quotes builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->quotes())->toBeInstanceOf(QuotesBuilder::class);
});

it('can access contacts builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->contacts())->toBeInstanceOf(ContactsBuilder::class);
});

it('can access merch stores builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->merchStores())->toBeInstanceOf(MerchStoresBuilder::class);
});

it('can access tasks builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->tasks())->toBeInstanceOf(TasksBuilder::class);
});

it('can access threads builder', function () {
    $printavo = app(Printavo::class);

    expect($printavo->threads())->toBeInstanceOf(ThreadsBuilder::class);
});

it('returns new builder instances on each call', function () {
    $printavo = app(Printavo::class);

    $builder1 = $printavo->customers();
    $builder2 = $printavo->customers();

    expect($builder1)->not->toBe($builder2);
});
