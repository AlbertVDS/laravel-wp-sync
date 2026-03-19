<?php

namespace Albertvds\WpSync\Commands;

use Illuminate\Console\Command;
use Albertvds\WpSync\WooFacade as Woo;

class WooSyncCommand extends Command
{
    protected $signature   = 'woo:sync {resource=products : products, orders, or customers}';
    protected $description = 'Pull WooCommerce resources into the local database';

    public function handle(): int
    {
        $resource = $this->argument('resource');

        $this->info("Syncing WooCommerce {$resource}...");

        $items = Woo::{$resource}()->paginate(100);

        // TODO: upsert into local sync table
        $this->info("Synced {$items->count()} {$resource}.");

        return self::SUCCESS;
    }
}
