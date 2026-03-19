<?php

namespace Albertvds\WpSync;

use Illuminate\Support\Facades\Facade;
use Albertvds\WpSync\Http\WooClient;
use Albertvds\WpSync\QueryBuilders\WooQueryBuilder;

/**
 * @method static WooQueryBuilder orders()
 * @method static WooQueryBuilder products()
 * @method static WooQueryBuilder customers()
 * @method static WooQueryBuilder refunds()
 * @method static WooQueryBuilder coupons()
 * @method static WooQueryBuilder categories()
 * @method static WooClient connection(string $name)
 *
 * @see WooClient
 */
class WooFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WooClient::class;
    }
}
