<?php

namespace Albertvds\WpSync;

use Albertvds\WpSync\Events\OrderCreated;
use Albertvds\WpSync\Events\OrderUpdated;
use Albertvds\WpSync\Events\OrderDeleted;
use Albertvds\WpSync\Events\ProductUpdated;
use Albertvds\WpSync\Events\CustomerCreated;
use Albertvds\WpSync\Events\WooWebhookReceived;

class WebhookRouter
{
    protected static array $map = [
        'order.created'    => OrderCreated::class,
        'order.updated'    => OrderUpdated::class,
        'order.deleted'    => OrderDeleted::class,
        'product.updated'  => ProductUpdated::class,
        'customer.created' => CustomerCreated::class,
    ];

    public static function dispatch(string $topic, array $payload): void
    {
        $eventClass = static::$map[$topic] ?? WooWebhookReceived::class;

        event(new $eventClass($topic, $payload));
    }
}
