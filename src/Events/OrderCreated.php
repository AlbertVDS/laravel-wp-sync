<?php

namespace Albertvds\WpSync\Events;

use Albertvds\WpSync\DTOs\WooOrder;

class OrderCreated extends WooWebhookReceived
{
    public readonly WooOrder $order;

    public function __construct(string $topic, array $payload)
    {
        parent::__construct($topic, $payload);

        $this->order = WooOrder::fromArray($payload);
    }
}
