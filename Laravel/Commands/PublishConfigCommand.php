<?php

namespace Laravel\Commands;

use Illuminate\Console\Command;

class PublishConfigCommand extends Command
{
    protected $signature = 'permissioning:publish-config';
    protected $description = 'Publish the permissioning module configuration file';

    public function handle(): int
    {
        $this->call('vendor:publish', [
            '--tag' => 'abac',
        ]);

        $this->info('Permissioning configuration published.');

        return parent::SUCCESS;
    }
}