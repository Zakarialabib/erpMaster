<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class InstallCommand extends Command
{
    public $signature = 'erpMaster:install';

    public $description = 'Install erpMaster';

    public $isFresh = false;

    public function handle(): int
    {
        $this->comment('Thanks for using ErpMaster. It is still in beta, so let us know what issues you find.');

        if ($this->confirm('Are you installing ErpMaster into a fresh Laravel app?', true)) {
            $this->isFresh = true;
        }

        $this->setupDatabase();

        $this->migrate();

        $this->addToGitIgnore();

        $this->comment('Running storage:link to make images visible...');

        if ($this->confirm(
            'Do you want to create a symbolic link for the storage directory? This may affect existing links.',
            true
        )) {
            $this->call('storage:link');
        }

        $this->info('<fg=white;bg=green>Success!</> ErpMaster is installed...make something great!');
        $this->info('Log in at '.config('app.url').'/erpMaster/login');
        $this->info('And don\'t forget to run `npm install && npm run dev` if you haven\'t already.');

        return self::SUCCESS;
    }

    protected function publishVendorFiles(): void
    {
        $this->comment('Publishing ErpMaster assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'erpMaster-assets']);

        $this->comment('Publishing ErpMaster migrations...');
        $this->callSilent('vendor:publish', ['--tag' => 'erpMaster-migrations']);

        $this->comment('Publishing ErpMaster config file...');
        $this->callSilent('vendor:publish', ['--tag' => 'erpMaster-config']);
    }

    protected function addToGitIgnore(): void
    {
        $this->info('Updating gitignore...');
        $ignore_file = base_path('.gitignore');
        file_put_contents(
            $ignore_file,
            PHP_EOL.'/erpMaster'.PHP_EOL.'/public/erpMaster'.PHP_EOL.'/storage/backups',
            FILE_APPEND
        );
    }

    protected function setupDatabase(): void
    {
        $this->comment('Making /erpMaster folder...');

        if ( ! File::isDirectory(base_path('/erpMaster'))) {
            File::makeDirectory(base_path('/erpMaster'));
        }

        if ($this->isFresh) {
            if ($this->confirm('Use mySql as your database?', true)) {
                $this->comment('Making database...');
                // Tell them to setup the .env file themselves.
                // $this->line('------------------');
                // $this->line('<fg=white;bg=blue>One more step!</> paste this into your .env file now:');
                // $this->line('DB_CONNECTION=sqlite');
                // $this->line('DB_DATABASE=' . $db_file);
                // $this->line('DB_FOREIGN_KEYS=true');
                // $this->line('------------------');
                // $this->ask('Once you\'ve added the three lines above to your .env, press enter.');

                // $this->line('Reloading .env file...');

                // reloads the .env file
                $this->call('config:cache');
                $this->call('config:clear');
            }
        }
    }

    // Initial migration ensures we have a users table.
    protected function migrate(): void
    {
        // Spatie creates the media table a bunch, so it needs to only be created once.
        if ( ! Schema::hasTable('media')) {
            $this->comment('Publishing Spatie\'s media config file...');
            $this->callSilent('vendor:publish', ['--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider', '--tag' => 'migrations']);
        } else {
            $this->comment('Spatie\'s media config file is already published. Skipping.');
        }

        $this->comment('Doing an initial migration...');
        //        $this->call('migrate');
        passthru('php artisan migrate');
    }
}
