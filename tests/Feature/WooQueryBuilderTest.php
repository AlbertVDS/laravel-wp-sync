<?php

use Illuminate\Support\Facades\Http;
use Albertvds\WpSync\WooFacade as Woo;

it('fetches orders with status filter', function () {
    Http::fake([
        '*/wc/v3/orders*' => Http::response([
            ['id' => 1, 'status' => 'processing', 'currency' => 'EUR', 'total' => '10.00', 'billing' => ['email' => '', 'first_name' => '', 'last_name' => ''], 'line_items' => [], 'date_created' => '2024-01-01'],
        ]),
    ]);

    $orders = Woo::orders()->where('status', 'processing')->get();

    expect($orders)->toHaveCount(1);
});
