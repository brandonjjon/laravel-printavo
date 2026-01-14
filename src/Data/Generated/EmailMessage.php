<?php

namespace Brandonjjon\Printavo\Data\Generated;

use Brandonjjon\Printavo\Data\BaseData;
use Brandonjjon\Printavo\Data\Generated\Enums\MessageDeliveryStatus;

/**
 * Email Message
 *
 * @generated from GraphQL schema - do not edit manually
 */
readonly class EmailMessage extends BaseData
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(
        public string $id,
        /** @var array<mixed> */
        public array $attachments,
        public string $from,
        public bool $incoming,
        public ?MessageDeliveryStatus $status,
        public string $subject,
        public string $text,
        public ?ObjectTimestamps $timestamps,
        public string $to,
        public ?string $bcc = null,
        public ?string $cc = null,
        public ?MessageParticipantUnion $recipient = null,
        public ?MessageParticipantUnion $sender = null,
        protected array $attributes = [],
    ) {}

    /**
     * Create an instance from API response data.
     *
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $recipient = isset($data['recipient']) && is_array($data['recipient'])
            ? MessageParticipantUnion::fromArray($data['recipient'])
            : null;

        $sender = isset($data['sender']) && is_array($data['sender'])
            ? MessageParticipantUnion::fromArray($data['sender'])
            : null;

        $status = isset($data['status']) ? MessageDeliveryStatus::tryFrom($data['status']) : null;

        $timestamps = isset($data['timestamps']) && is_array($data['timestamps'])
            ? ObjectTimestamps::fromArray($data['timestamps'])
            : null;

        return new static(
            attachments: $data['attachments'] ?? [],
            bcc: $data['bcc'] ?? null,
            cc: $data['cc'] ?? null,
            from: $data['from'] ?? '',
            id: $data['id'] ?? '',
            incoming: $data['incoming'] ?? false,
            recipient: $recipient,
            sender: $sender,
            status: $status,
            subject: $data['subject'] ?? '',
            text: $data['text'] ?? '',
            timestamps: $timestamps,
            to: $data['to'] ?? '',
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
            'bcc',
            'cc',
            'from',
            'id',
            'incoming',
            'status',
            'subject',
            'text',
            'timestamps { createdAt updatedAt }',
            'to',
        ];
    }
}
