<?php

namespace Brandonjjon\Printavo\Exceptions;

use Brandonjjon\Printavo\RateLimiter\RateLimiter;

class RateLimitException extends PrintavoException
{
    /**
     * Create a new rate limit exception instance.
     *
     * @param  int  $retryAfter  Seconds to wait before retrying
     * @param  int  $remaining  Requests remaining in the window
     * @param  int  $windowSeconds  The rate limit window duration
     */
    public function __construct(
        public readonly int $retryAfter = 5,
        public readonly int $remaining = 0,
        public readonly int $windowSeconds = 5,
        string $message = 'Rate limit exceeded. Please wait before making more requests.',
        int $code = 429,
    ) {
        parent::__construct($message, $code);
    }

    /**
     * Create an exception from a rate limiter instance.
     */
    public static function fromRateLimiter(RateLimiter $limiter, int $retryAfter): self
    {
        return new self(
            retryAfter: $retryAfter,
            remaining: $limiter->remaining(),
            windowSeconds: $limiter->getWindowSeconds(),
            message: "Rate limit exceeded. Retry in {$retryAfter} seconds.",
        );
    }

    /**
     * Create an exception from an HTTP 429 response.
     *
     * @param  int  $retryAfter  Value from Retry-After header
     */
    public static function fromHttpResponse(int $retryAfter, int $windowSeconds = 5): self
    {
        return new self(
            retryAfter: $retryAfter,
            remaining: 0,
            windowSeconds: $windowSeconds,
            message: "Rate limit exceeded by Printavo API. Retry in {$retryAfter} seconds.",
        );
    }

    /**
     * Get the Retry-After value formatted for HTTP header.
     */
    public function getRetryAfterHeader(): string
    {
        return (string) $this->retryAfter;
    }
}
