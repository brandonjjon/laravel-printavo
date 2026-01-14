<?php

namespace Brandonjjon\Printavo\Exceptions;

class AuthenticationException extends PrintavoException
{
    /**
     * Create a new authentication exception instance.
     */
    public function __construct(
        string $message = 'Authentication failed. Please check your Printavo email and token.',
        int $code = 401,
    ) {
        parent::__construct($message, $code);
    }
}
