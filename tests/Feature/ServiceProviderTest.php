<?php

use Brandonjjon\Printavo\Printavo;
use Brandonjjon\Printavo\PrintavoClient;
use Illuminate\Support\Facades\Artisan;

it('registers the printavo client singleton', function () {
    expect(app('printavo'))->toBeInstanceOf(PrintavoClient::class);
});

it('registers the printavo manager singleton', function () {
    expect(app('printavo.manager'))->toBeInstanceOf(Printavo::class);
});

it('binds PrintavoClient class to the container', function () {
    expect(app(PrintavoClient::class))->toBeInstanceOf(PrintavoClient::class);
});

it('binds Printavo class to the container', function () {
    expect(app(Printavo::class))->toBeInstanceOf(Printavo::class);
});

it('registers artisan commands', function () {
    $commands = Artisan::all();

    expect($commands)->toHaveKey('printavo:test')
        ->and($commands)->toHaveKey('printavo:cache:clear')
        ->and($commands)->toHaveKey('printavo:generate');
});

it('publishes config file', function () {
    $this->artisan('vendor:publish', [
        '--tag' => 'printavo-config',
        '--force' => true,
    ])->assertSuccessful();

    expect(config_path('printavo.php'))->toBeReadableFile();

    // Cleanup
    @unlink(config_path('printavo.php'));
});

it('loads config from package', function () {
    expect(config('printavo.endpoint'))->toBe('https://www.printavo.com/api/v2')
        ->and(config('printavo.email'))->toBe('test@example.com')
        ->and(config('printavo.token'))->toBe('test-token-for-testing')
        ->and(config('printavo.cache.enabled'))->toBe(false);
});
