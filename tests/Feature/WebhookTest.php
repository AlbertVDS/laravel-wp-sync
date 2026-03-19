<?php

use Albertvds\WpSync\Events\OrderCreated;
use Illuminate\Support\Facades\Event;

it('returns 401 for an invalid webhook signature', function () {
    $this->postJson(route('wp-sync.webhook'), ['id' => 1])
         ->assertStatus(401);
});

it('dispatches OrderCreated for order.created topic', function () {
    Event::fake();

    $payload = ['id' => 42, 'status' => 'processing', 'billing' => ['email' => 'test@example.com'], 'currency' => 'EUR', 'total' => '99.00', 'line_items' => [], 'date_created' => now()->toIso8601String(), 'billing' => ['email' => '', 'first_name' => '', 'last_name' => '', 'address_1' => '', 'city' => '', 'country' => '']];
    $secret  = config('wp-sync.woo.secret');
    $sig     = base64_encode(hash_hmac('sha256', json_encode($payload), $secret, true));

    $this->postJson(route('wp-sync.webhook'), $payload, [
        'X-WC-Webhook-Signature' => $sig,
        'X-WC-Webhook-Topic'     => 'order.created',
    ])->assertNoContent();

    Event::assertDispatched(OrderCreated::class);
});
