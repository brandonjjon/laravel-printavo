<?php

namespace Brandonjjon\Printavo\RateLimiter;

use Brandonjjon\Printavo\Exceptions\RateLimitException;

/**
 * Sliding window rate limiter for Printavo API requests.
 *
 * Implements in-memory rate limiting to prevent hitting Printavo's
 * API limits (10 requests per 5 seconds per email/IP).
 *
 * Note: For distributed systems (multiple servers), this in-memory approach
 * won't coordinate across instances. Distributed rate limiting would require
 * a Redis-based solution (out of scope for v1).
 */
class RateLimiter
{
    /**
     * Timestamps of requests within the current window.
     *
     * @var array<int, float>
     */
    protected array $timestamps = [];

    /**
     * Create a new rate limiter instance.
     *
     * @param  int  $maxRequests  Maximum requests allowed in the window (default: 10)
     * @param  int  $windowSeconds  Window duration in seconds (default: 5)
     * @param  string  $behavior  Behavior when limit hit: 'wait' or 'throw' (default: 'wait')
     */
    public function __construct(
        protected int $maxRequests = 10,
        protected int $windowSeconds = 5,
        protected string $behavior = 'wait',
    ) {}

    /**
     * Attempt to make a request within the rate limit.
     *
     * If the limit is reached:
     * - behavior='wait': Sleep until a request slot is available
     * - behavior='throw': Throw RateLimitException with retry time
     *
     * @throws RateLimitException
     */
    public function attempt(): void
    {
        $this->pruneOldTimestamps();

        while ($this->remaining() === 0) {
            $waitSeconds = $this->availableIn();

            if ($this->behavior === 'throw') {
                throw RateLimitException::fromRateLimiter($this, $waitSeconds);
            }

            // Sleep until a slot becomes available
            // Use microsecond precision for accuracy
            usleep((int) ($waitSeconds * 1_000_000));

            $this->pruneOldTimestamps();
        }

        // Record this request timestamp
        $this->timestamps[] = microtime(true);
    }

    /**
     * Get the number of requests remaining in the current window.
     */
    public function remaining(): int
    {
        $this->pruneOldTimestamps();

        return max(0, $this->maxRequests - count($this->timestamps));
    }

    /**
     * Get seconds until the next request slot is available.
     *
     * Returns 0 if a request can be made immediately.
     */
    public function availableIn(): int
    {
        $this->pruneOldTimestamps();

        if ($this->remaining() > 0) {
            return 0;
        }

        if (empty($this->timestamps)) {
            return 0;
        }

        // Find the oldest timestamp and calculate when it will expire
        $oldest = min($this->timestamps);
        $expiresAt = $oldest + $this->windowSeconds;
        $waitTime = $expiresAt - microtime(true);

        return max(0, (int) ceil($waitTime));
    }

    /**
     * Reset all tracked timestamps.
     *
     * Useful for testing or clearing state.
     */
    public function reset(): void
    {
        $this->timestamps = [];
    }

    /**
     * Get the maximum requests allowed in the window.
     */
    public function getMaxRequests(): int
    {
        return $this->maxRequests;
    }

    /**
     * Get the window duration in seconds.
     */
    public function getWindowSeconds(): int
    {
        return $this->windowSeconds;
    }

    /**
     * Get the current behavior setting.
     */
    public function getBehavior(): string
    {
        return $this->behavior;
    }

    /**
     * Remove timestamps that are outside the current window.
     */
    protected function pruneOldTimestamps(): void
    {
        $windowStart = microtime(true) - $this->windowSeconds;

        $this->timestamps = array_values(
            array_filter(
                $this->timestamps,
                fn (float $timestamp): bool => $timestamp >= $windowStart
            )
        );
    }
}
