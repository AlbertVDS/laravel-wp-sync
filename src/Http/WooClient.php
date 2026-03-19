<?php

namespace Albertvds\WpSync\Http;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Albertvds\WpSync\QueryBuilders\WooQueryBuilder;

class WooClient
{
    public function __construct(
        protected readonly string $url,
        protected readonly string $key,
        protected readonly string $secret,
    ) {}

    public function orders(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'orders');
    }

    public function products(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'products');
    }

    public function customers(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'customers');
    }

    public function refunds(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'refunds');
    }

    public function coupons(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'coupons');
    }

    public function categories(): WooQueryBuilder
    {
        return new WooQueryBuilder($this, 'products/categories');
    }

    public function connection(string $name): static
    {
        $config = config("wp-sync.connections.{$name}");

        return new static(
            url:    $config['url'],
            key:    $config['key'],
            secret: $config['secret'],
        );
    }

    public function http(): PendingRequest
    {
        return Http::withBasicAuth($this->key, $this->secret)
                   ->baseUrl(rtrim($this->url, '/').'/wp-json/wc/v3/');
    }
}
