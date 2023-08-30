<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreatePage extends Command
{
    /** The name and signature of the console command. */
    protected $signature = 'page:create {title} {--components=}';

    /** The console command description. */
    protected $description = 'Create a new page with specified components';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $name = Str::snake($this->argument('title'));

        $components = json_decode($this->argument('components'), true);
    }
}
