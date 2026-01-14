<?php

namespace Brandonjjon\Printavo;

use Brandonjjon\Printavo\Cache\ResponseCache;
use Brandonjjon\Printavo\Console\PrintavoCacheCommand;
use Brandonjjon\Printavo\Console\PrintavoGenerateBuildersCommand;
use Brandonjjon\Printavo\Console\PrintavoGenerateCommand;
use Brandonjjon\Printavo\Console\PrintavoGenerateDtosCommand;
use Brandonjjon\Printavo\Console\PrintavoGenerateFacadeCommand;
use Brandonjjon\Printavo\Console\PrintavoSchemaFetchCommand;
use Brandonjjon\Printavo\Console\PrintavoTestCommand;
use Brandonjjon\Printavo\RateLimiter\RateLimiter;
use Illuminate\Support\ServiceProvider;

class PrintavoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/printavo.php',
            'printavo'
        );

        $this->app->singleton('printavo.cache', function ($app) {
            return new ResponseCache(
                enabled: config('printavo.cache.enabled', true),
                ttl: config('printavo.cache.ttl', 300),
                store: config('printavo.cache.store'),
            );
        });

        $this->app->bind(ResponseCache::class, fn ($app) => $app->make('printavo.cache'));

        $this->app->singleton('printavo.rate_limiter', function ($app) {
            return new RateLimiter(
                maxRequests: (int) config('printavo.rate_limit.requests', 10),
                windowSeconds: (int) config('printavo.rate_limit.seconds', 5),
                behavior: config('printavo.rate_limit.behavior', 'wait'),
            );
        });

        $this->app->bind(RateLimiter::class, fn ($app) => $app->make('printavo.rate_limiter'));

        $this->app->singleton('printavo', function ($app) {
            return new PrintavoClient(
                email: config('printavo.email') ?? '',
                token: config('printavo.token') ?? '',
                endpoint: config('printavo.endpoint') ?? 'https://www.printavo.com/api/v2',
                cache: $app->make('printavo.cache'),
                rateLimiter: $app->make('printavo.rate_limiter'),
            );
        });

        $this->app->bind(PrintavoClient::class, fn ($app) => $app->make('printavo'));

        $this->app->singleton('printavo.manager', function ($app) {
            return new Printavo($app->make('printavo'));
        });

        $this->app->bind(Printavo::class, fn ($app) => $app->make('printavo.manager'));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/printavo.php' => config_path('printavo.php'),
            ], 'printavo-config');

            $this->commands([
                PrintavoTestCommand::class,
                PrintavoCacheCommand::class,
                PrintavoSchemaFetchCommand::class,
                PrintavoGenerateCommand::class,
                PrintavoGenerateDtosCommand::class,
                PrintavoGenerateBuildersCommand::class,
                PrintavoGenerateFacadeCommand::class,
            ]);
        }
    }
}
