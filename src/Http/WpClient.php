<?php

namespace Albertvds\WpSync\Http;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Albertvds\WpSync\QueryBuilders\WpQueryBuilder;

class WpClient
{
    public function __construct(
        protected readonly string $url,
        protected readonly string $user,
        protected readonly string $password,
    ) {}

    public function posts(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'posts');
    }

    public function pages(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'pages');
    }

    public function categories(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'categories');
    }

    public function tags(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'tags');
    }

    public function media(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'media');
    }

    public function users(): WpQueryBuilder
    {
        return new WpQueryBuilder($this, 'users');
    }

    public function connection(string $name): static
    {
        $config = config("wp-sync.connections.{$name}");

        return new static(
            url:      $config['url'],
            user:     $config['user'],
            password: $config['app_password'],
        );
    }

    public function http(): PendingRequest
    {
        return Http::withBasicAuth($this->user, $this->password)
                   ->baseUrl(rtrim($this->url, '/').'/wp-json/wp/v2/');
    }
}
