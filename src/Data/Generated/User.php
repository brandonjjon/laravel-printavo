<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;

/**
 * User
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class User extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        public ?Account $account,
        public ?Avatar $avatar,
        public string $name,
        public string $timeZone,
        public ?ObjectTimestamps $timestamps = null,
        public ?string $email = null,
        /** @var array<Permission> */
        public array $permissions = [],
        public ?string $phone = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $account = isset($data['account']) && is_array($data['account'])
            ? Account::fromArray($data['account'])
            : null;

        $avatar = isset($data['avatar']) && is_array($data['avatar'])
            ? Avatar::fromArray($data['avatar'])
            : null;

        $permissions = array_map(
            fn (array $item) => Permission::fromArray($item),
            $data['permissions'] ?? []
        );

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            account: $account,
            avatar: $avatar,
            email: $data['email'] ?? null,
            id: $data['id'] ?? '',
            name: $data['name'] ?? '',
            permissions: $permissions,
            phone: $data['phone'] ?? null,
            timeZone: $data['timeZone'] ?? '',
            timestamps: $timestamps,
            attributes: $data,
        );
    }

    /**
     * Get the default fields to request from the API.
     *
     * @return array<string>
     */
    public static function defaultFields(): array
    {
        return [
            'account { id }',
            'email',
            'id',
            'name',
            'phone',
            'timeZone',
            'timestamps { createdAt updatedAt }',
        ];
    }
}
