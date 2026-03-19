<?php

namespace Albertvds\WpSync\QueryBuilders;

use Illuminate\Support\Collection;
use Albertvds\WpSync\Http\WooClient;

class WooQueryBuilder
{
    protected array $params = [];

    public function __construct(
        protected readonly WooClient $client,
        protected readonly string $endpoint,
    ) {}

    public function where(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function after(string $date): static
    {
        $this->params['after'] = $date;

        return $this;
    }

    public function before(string $date): static
    {
        $this->params['before'] = $date;

        return $this;
    }

    public function inStock(): static
    {
        $this->params['stock_status'] = 'instock';

        return $this;
    }

    public function search(string $term): static
    {
        $this->params['search'] = $term;

        return $this;
    }

    public function find(int $id): mixed
    {
        $response = $this->client->http()
                                 ->get($this->endpoint.'/'.$id);

        return $response->json();
    }

    public function paginate(int $perPage = 15, int $page = 1): Collection
    {
        $this->params['per_page'] = $perPage;
        $this->params['page']     = $page;

        return $this->get();
    }

    public function first(): mixed
    {
        $this->params['per_page'] = 1;

        return $this->get()->first();
    }

    public function get(): Collection
    {
        $response = $this->client->http()
                                 ->get($this->endpoint, $this->params);

        return collect($response->json());
    }
}
