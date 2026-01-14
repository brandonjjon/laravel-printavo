<?php

namespace Brandonjjon\Printavo\Exceptions;

use Exception;

class PrintavoException extends Exception
{
    /**
     * Create a new Printavo exception instance.
     *
     * @param  array<int, array{message: string, locations?: array, path?: array, extensions?: array}>|null  $graphqlErrors
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        public readonly ?array $graphqlErrors = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Create an exception from GraphQL errors.
     *
     * @param  array<int, array{message: string, locations?: array, path?: array, extensions?: array}>  $errors
     */
    public static function fromGraphQL(array $errors): static
    {
        $messages = array_map(
            fn (array $error): string => $error['message'] ?? 'Unknown GraphQL error',
            $errors
        );

        return new static(
            message: implode('; ', $messages),
            graphqlErrors: $errors,
        );
    }
}
