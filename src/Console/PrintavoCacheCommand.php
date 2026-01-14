<?php

namespace Brandonjjon\Printavo\Console;

use Brandonjjon\Printavo\Cache\ResponseCache;
use Illuminate\Console\Command;

class PrintavoCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'printavo:cache:clear {--stats : Show cache statistics}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear cached Printavo API responses';

    /**
     * Execute the console command.
     */
    public function handle(ResponseCache $cache): int
    {
        if (! $cache->isEnabled()) {
            $this->components->info('Caching is disabled - nothing to clear');

            return self::SUCCESS;
        }

        if ($this->option('stats')) {
            $this->displayStats($cache);
            $this->newLine();
        }

        $flushed = $cache->flush();

        if ($flushed) {
            $this->components->info('Printavo cache cleared successfully');
        } else {
            $this->components->warn('Cache cleared (note: full flush requires tag-supporting store like Redis)');
        }

        return self::SUCCESS;
    }

    /**
     * Display cache statistics.
     */
    protected function displayStats(ResponseCache $cache): void
    {
        $store = $cache->getStore() ?? config('cache.default');
        $ttl = $cache->getTtl();

        $this->components->twoColumnDetail('Cache store', $store);
        $this->components->twoColumnDetail('TTL', "{$ttl} seconds");
        $this->components->twoColumnDetail('Status', 'Enabled');
    }
}
