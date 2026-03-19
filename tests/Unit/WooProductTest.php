<?php

use Albertvds\WpSync\DTOs\WooProduct;

it('maps api array to WooProduct properties', function () {
    $product = WooProduct::fromArray([
        'id'             => 10,
        'name'           => 'Test Product',
        'slug'           => 'test-product',
        'status'         => 'publish',
        'price'          => '19.99',
        'regular_price'  => '24.99',
        'stock_status'   => 'instock',
        'stock_quantity' => 50,
        'categories'     => [],
    ]);

    expect($product->id)->toBe(10)
        ->and($product->name)->toBe('Test Product')
        ->and($product->stockStatus)->toBe('instock');
});
