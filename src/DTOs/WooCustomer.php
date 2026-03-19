<?php

namespace Albertvds\WpSync\DTOs;

class WooCustomer
{
    public function __construct(
        public readonly int    $id,
        public readonly string $email,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $username,
        public readonly string $billingAddress,
        public readonly string $billingCity,
        public readonly string $billingCountry,
        public readonly string $dateCreated,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id:             $data['id'],
            email:          $data['email'],
            firstName:      $data['first_name'],
            lastName:       $data['last_name'],
            username:       $data['username'],
            billingAddress: $data['billing']['address_1'] ?? '',
            billingCity:    $data['billing']['city'] ?? '',
            billingCountry: $data['billing']['country'] ?? '',
            dateCreated:    $data['date_created'],
        );
    }
}
