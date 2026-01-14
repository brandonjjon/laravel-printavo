<?php

namespace Brandonjjon\Printavo\Mutations;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Exceptions\PrintavoException;

readonly class MutationResponse
{
    /**
     * Create a new mutation response instance.
     *
     * @param  array<int, array{field?: string, message: string}>|null  $errors
     */
    public function __construct(
        public bool $success,
        public ?BaseData $data = null,
        public ?array $errors = null,
    ) {}

    /**
     * Create a mutation response from an API response array.
     *
     * @param  array<string, mixed>  $response  The mutation response data
     * @param  string  $resourceKey  The key containing the resource (e.g., 'contact')
     * @param  class-string<BaseData>  $dataClass  The DTO class to hydrate
     */
    public static function fromArray(array $response, string $resourceKey, string $dataClass): static
    {
        $errors = $response['errors'] ?? null;
        $resourceData = $response[$resourceKey] ?? null;

        $hasErrors = ! empty($errors);
        $success = ! $hasErrors && $resourceData !== null;

        $data = null;
        if ($resourceData !== null) {
            $data = $dataClass::fromArray($resourceData);
        }

        return new static(
            success: $success,
            data: $data,
            errors: $errors,
        );
    }

    /**
     * Create a successful delete response (no data returned).
     *
     * @param  array<string, mixed>  $response  The mutation response data
     */
    public static function forDelete(array $response): static
    {
        $errors = $response['errors'] ?? null;
        $hasErrors = ! empty($errors);

        return new static(
            success: ! $hasErrors,
            data: null,
            errors: $errors,
        );
    }

    /**
     * Throw a PrintavoException if the mutation failed.
     *
     * @throws PrintavoException
     */
    public function throw(): static
    {
        if (! $this->success && ! empty($this->errors)) {
            $messages = array_map(
                fn (array $error): string => $error['message'] ?? 'Unknown mutation error',
                $this->errors
            );

            throw new PrintavoException(
                message: implode('; ', $messages),
            );
        }

        return $this;
    }

    /**
     * Check if the mutation was successful.
     */
    public function successful(): bool
    {
        return $this->success;
    }

    /**
     * Check if the mutation failed.
     */
    public function failed(): bool
    {
        return ! $this->success;
    }
}
