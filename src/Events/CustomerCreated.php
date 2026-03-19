<?php

namespace Albertvds\WpSync\Events;

use Albertvds\WpSync\DTOs\WooCustomer;

class CustomerCreated extends WooWebhookReceived
{
    public readonly WooCustomer $customer;

    public function __construct(string $topic, array $payload)
    {
        parent::__construct($topic, $payload);

        $this->customer = WooCustomer::fromArray($payload);
    }
}
