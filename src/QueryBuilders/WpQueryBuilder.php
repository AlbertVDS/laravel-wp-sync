<?php

namespace Albertvds\WpSync\QueryBuilders;

use Illuminate\Support\Collection;
use Albertvds\WpSync\Http\WpClient;

class WpQueryBuilder
{
    protected array $params = [];

    public function __construct(
        protected readonly WpClient $client,
        protected readonly string $endpoint,
    ) {}

    public function where(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function category(string $slug): static
    {
        $this->params['categories'] = $slug;

        return $this;
    }

    public function slug(string $slug): static
    {
        $this->params['slug'] = $slug;

        return $this;
    }

    public function search(string $term): static
    {
        $this->params['search'] = $term;

        return $this;
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
