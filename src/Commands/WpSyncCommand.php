<?php

namespace Albertvds\WpSync\Commands;

use Illuminate\Console\Command;
use Albertvds\WpSync\WpFacade as Wp;

class WpSyncCommand extends Command
{
    protected $signature   = 'wp:sync {resource=posts : posts or pages}';
    protected $description = 'Pull WordPress posts or pages into the local database';

    public function handle(): int
    {
        $resource = $this->argument('resource');

        $this->info("Syncing WordPress {$resource}...");

        $items = Wp::{$resource}()->paginate(100);

        // TODO: upsert into local sync table
        $this->info("Synced {$items->count()} {$resource}.");

        return self::SUCCESS;
    }
}
