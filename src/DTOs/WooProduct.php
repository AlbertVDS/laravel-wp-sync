<?php

namespace Albertvds\WpSync\DTOs;

class WooProduct
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly string $slug,
        public readonly string $status,
        public readonly string $price,
        public readonly string $regularPrice,
        public readonly string $stockStatus,
        public readonly int    $stockQuantity,
        public readonly array  $categories,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            id:            $data['id'],
            name:          $data['name'],
            slug:          $data['slug'],
            status:        $data['status'],
            price:         $data['price'] ?? '',
            regularPrice:  $data['regular_price'] ?? '',
            stockStatus:   $data['stock_status'] ?? 'instock',
            stockQuantity: $data['stock_quantity'] ?? 0,
            categories:    $data['categories'] ?? [],
        );
    }
}
