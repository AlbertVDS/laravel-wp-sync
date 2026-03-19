<?php

namespace Albertvds\WpSync\Events;

class WooWebhookReceived
{
    public function __construct(
        public readonly string $topic,
        public readonly array  $payload,
    ) {}
}
