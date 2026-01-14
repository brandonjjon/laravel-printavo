<?php

namespace Brandonjjon\Printavo;

use Brandonjjon\Printavo\Cache\ResponseCache;
use Brandonjjon\Printavo\Exceptions\AuthenticationException;
use Brandonjjon\Printavo\Exceptions\PrintavoException;
use Brandonjjon\Printavo\Exceptions\RateLimitException;
use Brandonjjon\Printavo\RateLimiter\RateLimiter;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PrintavoClient
{
    /**
     * Create a new Printavo client instance.
     */
    public function __construct(
        protected readonly string $email,
        protected readonly string $token,
        protected readonly string $endpoint,
        protected ResponseCache $cache,
        protected readonly RateLimiter $rateLimiter,
    ) {}

    /**
     * Execute a GraphQL query.
     *
     * Query results are cached automatically unless caching is disabled
     * or the client is in bypass mode.
     *
     * @param  array<string, mixed>  $variables
     * @return array<string, mixed>
     *
     * @throws PrintavoException
     * @throws AuthenticationException
     * @throws RateLimitException
     */
    public function query(string $query, array $variables = []): array
    {
        return $this->cache->remember($query, $variables, function () use ($query, $variables) {
            // Apply rate limiting before making the request
            $this->rateLimiter->attempt();

            $response = $this->sendRequest($query, $variables);

            return $this->handleResponse($response, $query, $variables);
        });
    }

    /**
     * Execute a GraphQL mutation.
     *
     * Mutations are never cached as they modify data.
     *
     * @param  array<string, mixed>  $variables
     * @return array<string, mixed>
     *
     * @throws PrintavoException
     * @throws AuthenticationException
     * @throws RateLimitException
     */
    public function mutate(string $mutation, array $variables = []): array
    {
        // Apply rate limiting before making the request
        $this->rateLimiter->attempt();

        // Mutations bypass cache - execute directly
        $response = $this->sendRequest($mutation, $variables);

        return $this->handleResponse($response, $mutation, []);
    }

    /**
     * Return a new client instance with caching bypassed.
     *
     * Usage: Printavo::fresh()->customers()->get() for uncached queries.
     */
    public function fresh(): static
    {
        return new static(
            email: $this->email,
            token: $this->token,
            endpoint: $this->endpoint,
            cache: $this->cache->bypass(),
            rateLimiter: $this->rateLimiter,
        );
    }

    /**
     * Flush all cached Printavo responses.
     *
     * Note: Only works with cache stores that support tags (Redis, Memcached).
     */
    public function flushCache(): bool
    {
        return $this->cache->flush();
    }

    /**
     * Get the response cache instance.
     */
    public function getCache(): ResponseCache
    {
        return $this->cache;
    }

    /**
     * Get the rate limiter instance.
     */
    public function getRateLimiter(): RateLimiter
    {
        return $this->rateLimiter;
    }

    /**
     * Send a GraphQL request to the Printavo API.
     *
     * @param  array<string, mixed>  $variables
     */
    protected function sendRequest(string $query, array $variables): Response
    {
        $payload = ['query' => $query];

        // Only include variables if not empty - Printavo API returns 500 for empty variables array
        if (! empty($variables)) {
            $payload['variables'] = $variables;
        }

        return Http::withHeaders([
            'email' => $this->email,
            'token' => $this->token,
            'Content-Type' => 'application/json',
        ])->post($this->endpoint, $payload);
    }

    /**
     * Handle the API response and extract data or throw appropriate exceptions.
     *
     * If a 429 response is received despite our rate limiting (race condition,
     * other clients), the request will be automatically retried once.
     *
     * @param  array<string, mixed>  $variables
     * @return array<string, mixed>
     *
     * @throws PrintavoException
     * @throws AuthenticationException
     * @throws RateLimitException
     */
    protected function handleResponse(Response $response, string $query, array $variables, bool $isRetry = false): array
    {
        // Handle HTTP status codes
        if ($response->status() === 401 || $response->status() === 403) {
            throw new AuthenticationException;
        }

        if ($response->status() === 429) {
            $retryAfter = (int) $response->header('Retry-After', 5);

            // Auto-retry once if we hit a 429 despite our rate limiting
            // This handles race conditions and other clients using the same credentials
            if (! $isRetry) {
                usleep($retryAfter * 1_000_000);

                // Apply rate limiting again before retry
                $this->rateLimiter->attempt();

                $retryResponse = $this->sendRequest($query, $variables);

                return $this->handleResponse($retryResponse, $query, $variables, isRetry: true);
            }

            throw RateLimitException::fromHttpResponse(
                $retryAfter,
                $this->rateLimiter->getWindowSeconds()
            );
        }

        // Throw on other HTTP errors
        if ($response->failed()) {
            throw new PrintavoException(
                message: "HTTP request failed with status {$response->status()}",
                code: $response->status(),
            );
        }

        $data = $response->json();

        // Handle GraphQL errors in the response body
        if (isset($data['errors']) && is_array($data['errors']) && count($data['errors']) > 0) {
            // Check for authentication errors in GraphQL response
            foreach ($data['errors'] as $error) {
                $message = strtolower($error['message'] ?? '');
                if (str_contains($message, 'unauthorized') || str_contains($message, 'authentication')) {
                    throw new AuthenticationException($error['message']);
                }
            }

            throw PrintavoException::fromGraphQL($data['errors']);
        }

        return $data['data'] ?? [];
    }
}
