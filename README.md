# albertvds/laravel-wp-sync

**Laravel integration for WordPress and WooCommerce**

Connects your Laravel application to the WordPress and WooCommerce REST APIs.
Handles authentication, request building, response mapping, webhook verification,
and local data sync.

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-10%20%C2%B7%2011%20%C2%B7%2012-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green?style=flat-square)
![Packagist](https://img.shields.io/packagist/v/albertvds/laravel-wp-sync?style=flat-square)

---

## Installation

```bash
composer require albertvds/laravel-wp-sync
```

The service provider and Facades register automatically via Laravel's package auto-discovery.

Publish the config file:

```bash
php artisan vendor:publish --tag=wp-sync-config
```

Add your credentials to `.env`:

```env
WP_URL=https://your-site.com
WP_USER=your_username
WP_APP_PASSWORD=xxxx xxxx xxxx xxxx

WOO_URL=https://your-store.com
WOO_KEY=ck_xxxxxxxxxxxx
WOO_SECRET=cs_xxxxxxxxxxxx
```

---

## What it does

This package provides a service provider, Facade, fluent query builder, typed DTOs,
and Artisan commands for working with the WordPress and WooCommerce REST APIs from
within a Laravel application.

Incoming WooCommerce webhooks are received on an automatically registered route,
verified against the HMAC-SHA256 signature, and dispatched as typed Laravel events.
API responses are mapped to typed data objects rather than raw arrays. Frequently
accessed resources can be cached using Laravel's existing cache configuration.

---

## Features

- **Fluent query builder** — filter, paginate, and retrieve WordPress posts, pages, and WooCommerce products, orders, and customers using a chainable API.
- **Typed DTOs** — API responses are returned as typed objects (`WpPost`, `WooOrder`, `WooProduct`, `WooCustomer`) with documented properties.
- **Webhook bridge** — registers a single route, verifies the request signature, maps the topic to a Laravel event class, and dispatches it. Supports all standard WooCommerce webhook topics.
- **Artisan commands** — `wp:sync` and `woo:sync` pull remote data into local database tables for offline querying.
- **Cache layer** — per-resource TTL configuration, backed by whichever Laravel cache driver the application already uses.
- **Multi-site support** — define multiple WordPress or WooCommerce connections in the config file and switch between them at runtime.
- **Auto-discovery** — the service provider and Facade register automatically via Composer's `extra.laravel` config. No manual setup required.

---

## Usage

### WordPress

Retrieve WordPress resources using the `Wp` Facade:

```php
use Albertvds\WpSync\WpFacade as Wp;

// Fetch published posts
Wp::posts()->where('status', 'publish')->get();

// Fetch posts in a category, paginated
Wp::posts()->where('status', 'publish')->category('news')->paginate(10);

// Fetch a single post by slug
Wp::posts()->slug('my-post-slug')->first();

// Search posts
Wp::posts()->search('laravel')->get();

// Fetch pages
Wp::pages()->where('status', 'publish')->get();

// Fetch categories
Wp::categories()->get();

// Fetch media
Wp::media()->get();
```

### WooCommerce

Retrieve WooCommerce resources using the `Woo` Facade:

```php
use Albertvds\WpSync\WooFacade as Woo;

// Fetch all processing orders
Woo::orders()->where('status', 'processing')->get();

// Fetch orders placed after a date, paginated
Woo::orders()->where('status', 'processing')->after('2024-01-01')->paginate(20);

// Fetch a single order by ID
Woo::orders()->find(42);

// Fetch in-stock products
Woo::products()->inStock()->get();

// Search products
Woo::products()->search('t-shirt')->paginate(15);

// Fetch customers
Woo::customers()->get();

// Fetch coupons
Woo::coupons()->get();

// Fetch product categories
Woo::categories()->get();
```

### Webhooks

Point your WooCommerce webhook delivery URL at:

```
https://your-app.com/woo/webhook
```

The route is registered automatically — no changes to `routes/web.php` are needed.
The package verifies the `X-WC-Webhook-Signature` header before processing any payload.

Listen to dispatched events anywhere in your Laravel application:

```php
use Albertvds\WpSync\Events\OrderCreated;
use Albertvds\WpSync\Events\OrderUpdated;
use Albertvds\WpSync\Events\ProductUpdated;
use Albertvds\WpSync\Events\CustomerCreated;

// In EventServiceProvider or using #[AsEventListener]
Event::listen(OrderCreated::class, function (OrderCreated $event) {
    // $event->order is a typed WooOrder DTO
    Mail::to($event->order->billingEmail)
         ->send(new OrderConfirmationMail($event->order));
});

Event::listen(ProductUpdated::class, function (ProductUpdated $event) {
    // $event->product is a typed WooProduct DTO
    Cache::forget('product-'.$event->product->id);
});
```

To listen to all webhook events for logging or auditing purposes:

```php
use Albertvds\WpSync\Events\WooWebhookReceived;

Event::listen(WooWebhookReceived::class, function (WooWebhookReceived $event) {
    Log::info('Webhook received', [
        'topic'   => $event->topic,
        'payload' => $event->payload,
    ]);
});
```

Supported webhook topics:

| WooCommerce topic  | Laravel event           |
|--------------------|-------------------------|
| `order.created`    | `OrderCreated`          |
| `order.updated`    | `OrderUpdated`          |
| `order.deleted`    | `OrderDeleted`          |
| `product.updated`  | `ProductUpdated`        |
| `customer.created` | `CustomerCreated`       |
| *(any other)*      | `WooWebhookReceived`    |

### Artisan commands

Pull remote data into local database tables for offline querying:

```bash
# Publish and run the sync migrations first
php artisan vendor:publish --tag=wp-sync-migrations
php artisan migrate

# Sync WordPress posts to the local wp_posts table
php artisan wp:sync posts

# Sync WordPress pages to the local wp_pages table
php artisan wp:sync pages

# Sync WooCommerce products to the local woo_products table
php artisan woo:sync products

# Sync WooCommerce orders to the local woo_orders table
php artisan woo:sync orders

# Sync WooCommerce customers
php artisan woo:sync customers
```

Schedule syncs in `routes/console.php`:

```php
Schedule::command('woo:sync products')->hourly();
Schedule::command('wp:sync posts')->daily();
```

### Multi-site connections

Define multiple connections in `config/wp-sync.php`:

```php
'connections' => [
    'store-nl' => [
        'url'    => env('WOO_NL_URL'),
        'key'    => env('WOO_NL_KEY'),
        'secret' => env('WOO_NL_SECRET'),
    ],
    'store-de' => [
        'url'    => env('WOO_DE_URL'),
        'key'    => env('WOO_DE_KEY'),
        'secret' => env('WOO_DE_SECRET'),
    ],
],
```

Switch between connections at runtime:

```php
Woo::connection('store-de')->orders()->where('status', 'processing')->get();

Wp::connection('blog-nl')->posts()->where('status', 'publish')->paginate(10);
```

### Cache

Configure TTL per environment in `.env`:

```env
WP_SYNC_CACHE_TTL=300
```

Or per resource type in `config/wp-sync.php`:

```php
'cache_ttl' => [
    'posts'    => 300,
    'products' => 60,
    'orders'   => 0,   // 0 disables caching for this resource
],
```

---

## Configuration reference

After publishing, `config/wp-sync.php` contains:

```php
return [
    'wp' => [
        'url'          => env('WP_URL'),
        'user'         => env('WP_USER'),
        'app_password' => env('WP_APP_PASSWORD'),
    ],

    'woo' => [
        'url'    => env('WOO_URL'),
        'key'    => env('WOO_KEY'),
        'secret' => env('WOO_SECRET'),
    ],

    'webhook_path' => env('WOO_WEBHOOK_PATH', 'woo/webhook'),

    'cache_ttl' => env('WP_SYNC_CACHE_TTL', 300),

    'connections' => [],
];
```

---

## Requirements

| Dependency          | Version      |
|---------------------|--------------|
| PHP                 | 8.2 · 8.3    |
| Laravel             | 10 · 11 · 12 |
| WordPress REST API  | 6.x          |
| WooCommerce REST API| 8.x          |

---

## Testing

```bash
composer test
```

The test suite uses [Pest](https://pestphp.com) and [Orchestra Testbench](https://github.com/orchestral/testbench).
HTTP calls to the WordPress and WooCommerce APIs are intercepted with `Http::fake()` —
no live credentials are required to run the tests.

---

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for recent changes.

---

## License

The MIT License (MIT). See [LICENSE](LICENSE) for details.
