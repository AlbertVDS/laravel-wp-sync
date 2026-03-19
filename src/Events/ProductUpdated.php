<?php

namespace Albertvds\WpSync\Events;

use Albertvds\WpSync\DTOs\WooProduct;

class ProductUpdated extends WooWebhookReceived
{
    public readonly WooProduct $product;

    public function __construct(string $topic, array $payload)
    {
        parent::__construct($topic, $payload);

        $this->product = WooProduct::fromArray($payload);
    }
}
