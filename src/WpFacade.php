<?php

namespace Albertvds\WpSync;

use Illuminate\Support\Facades\Facade;
use Albertvds\WpSync\Http\WpClient;
use Albertvds\WpSync\QueryBuilders\WpQueryBuilder;

/**
 * @method static WpQueryBuilder posts()
 * @method static WpQueryBuilder pages()
 * @method static WpQueryBuilder categories()
 * @method static WpQueryBuilder tags()
 * @method static WpQueryBuilder media()
 * @method static WpQueryBuilder users()
 * @method static WpClient connection(string $name)
 *
 * @see WpClient
 */
class WpFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return WpClient::class;
    }
}
