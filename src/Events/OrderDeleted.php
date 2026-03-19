<?php

namespace Albertvds\WpSync\Events;

class OrderDeleted extends WooWebhookReceived
{
    public readonly int $orderId;

    public function __construct(string $topic, array $payload)
    {
        parent::__construct($topic, $payload);

        $this->orderId = $payload['id'];
    }
}
