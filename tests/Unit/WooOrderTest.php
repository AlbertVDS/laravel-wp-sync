<?php

use Albertvds\WpSync\DTOs\WooOrder;

it('maps api array to WooOrder properties', function () {
    $order = WooOrder::fromArray([
        'id'           => 42,
        'status'       => 'processing',
        'currency'     => 'EUR',
        'total'        => '99.00',
        'billing'      => ['email' => 'test@example.com', 'first_name' => 'John', 'last_name' => 'Doe'],
        'line_items'   => [],
        'date_created' => '2024-01-01T00:00:00',
    ]);

    expect($order->id)->toBe(42)
        ->and($order->status)->toBe('processing')
        ->and($order->billingEmail)->toBe('test@example.com');
});
