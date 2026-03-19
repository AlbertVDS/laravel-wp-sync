<?php

namespace Albertvds\WpSync\DTOs;

class WooOrder
{
    public function __construct(
        public readonly int    $id,
        public readonly string $status,
        public readonly string $currency,
        public readonly string $total,
        public readonly string $billingEmail,
        public readonly string $billingFirstName,
        public readonly string $billingLastName,
        public readonly array  $lineItems,
        public readonly string $dateCreated,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id:               $data['id'],
            status:           $data['status'],
            currency:         $data['currency'],
            total:            $data['total'],
            billingEmail:     $data['billing']['email'] ?? '',
            billingFirstName: $data['billing']['first_name'] ?? '',
            billingLastName:  $data['billing']['last_name'] ?? '',
            lineItems:        $data['line_items'] ?? [],
            dateCreated:      $data['date_created'],
        );
    }
}
