<?php

namespace Brandonjjon\Printavo\Cache;

use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Response caching service for Printavo API queries.
 *
 * Wraps Laravel's Cache facade with Printavo-specific logic to cache
 * GraphQL query results and reduce API calls.
 */
class ResponseCache
{
    /**
     * Cache key prefix for all Printavo cache entries.
     */
    protected const CACHE_PREFIX = 'printavo:';

    /**
     * Cache tag name for tag-based cache stores.
     */
    protected const CACHE_TAG = 'printavo';

    /**
     * Create a new ResponseCache instance.
     *
     * @param  bool  $enabled  Whether caching is active
     * @param  int  $ttl  Cache TTL in seconds
     * @param  string|null  $store  Cache store to use (null = default)
     */
    public function __construct(
        protected bool $enabled,
        protected int $ttl,
        protected ?string $store = null,
    ) {}

    /**
     * Remember a query result in the cache.
     *
     * If caching is disabled, executes the callback directly.
     * Otherwise, uses Laravel's cache to store and retrieve results.
     *
     * @param  Closure(): array<string, mixed>  $callback
     * @return array<string, mixed>
     */
    public function remember(string $query, array $variables, Closure $callback): array
    {
        if (! $this->enabled) {
            return $callback();
        }

        $key = $this->buildKey($query, $variables);
        $cache = $this->getCacheStore();

        return $cache->remember($key, $this->ttl, $callback);
    }

    /**
     * Invalidate a specific cached query.
     */
    public function forget(string $query, array $variables): bool
    {
        $key = $this->buildKey($query, $variables);

        return $this->getCacheStore()->forget($key);
    }

    /**
     * Clear all Printavo-related cache entries.
     *
     * Uses cache tags if the driver supports them (Redis, Memcached),
     * otherwise returns false as prefix-based flushing is not supported.
     */
    public function flush(): bool
    {
        if ($this->supportsTags()) {
            return Cache::store($this->store)->tags(self::CACHE_TAG)->flush();
        }

        // For drivers without tag support, we cannot selectively flush
        // Users should use forget() for specific entries or flush the entire cache store
        return false;
    }

    /**
     * Return a new instance with caching disabled for fresh queries.
     *
     * Usage: $cache->bypass() to get uncached results for a single query.
     */
    public function bypass(): static
    {
        return new static(
            enabled: false,
            ttl: $this->ttl,
            store: $this->store,
        );
    }

    /**
     * Check if caching is currently enabled.
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Get the configured TTL in seconds.
     */
    public function getTtl(): int
    {
        return $this->ttl;
    }

    /**
     * Get the configured cache store name.
     */
    public function getStore(): ?string
    {
        return $this->store;
    }

    /**
     * Generate a consistent cache key from query and variables.
     *
     * Uses MD5 hash of normalized query and JSON-encoded variables
     * to create a unique, collision-resistant key.
     *
     * @param  array<string, mixed>  $variables
     */
    protected function buildKey(string $query, array $variables): string
    {
        // Normalize the query by removing extra whitespace
        $normalizedQuery = preg_replace('/\s+/', ' ', trim($query));
        $payload = $normalizedQuery.json_encode($variables, JSON_THROW_ON_ERROR);

        return self::CACHE_PREFIX.md5($payload);
    }

    /**
     * Get the cache store instance, optionally with tags if supported.
     *
     * @return \Illuminate\Contracts\Cache\Repository
     */
    protected function getCacheStore()
    {
        $cache = Cache::store($this->store);

        if ($this->supportsTags()) {
            return $cache->tags(self::CACHE_TAG);
        }

        return $cache;
    }

    /**
     * Check if the configured cache store supports tags.
     */
    protected function supportsTags(): bool
    {
        try {
            $store = Cache::store($this->store);

            return method_exists($store->getStore(), 'tags');
        } catch (\Exception) {
            return false;
        }
    }
}
