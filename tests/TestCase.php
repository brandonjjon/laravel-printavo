<?php

namespace Brandonjjon\Printavo\Tests;

use Brandonjjon\Printavo\PrintavoServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PrintavoServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('printavo.email', 'test@example.com');
        $app['config']->set('printavo.token', 'test-token-for-testing');
        $app['config']->set('printavo.endpoint', 'https://www.printavo.com/api/v2');
        $app['config']->set('printavo.cache.enabled', false);
    }
}
