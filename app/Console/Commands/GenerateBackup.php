<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate backup';

    public function handle(): void
    {
        $artisan_command = '';

        if (settings('backup_content') == 'db') {
            $artisan_command = 'backup:run & --only-db';
        } elseif (settings('backup_content') == 'all') {
            config(['backup.source.files.include' => base_path()]);
            $artisan_command = 'backup:run';
        }

        $command = explode('&', $artisan_command);

        try {
            ini_set('max_execution_time', 600);

            if (count($command) > 1) {
                Artisan::call(trim($command[0]), [trim($command[1]) => true]);
                $output = Artisan::output();

                if (strpos($output, 'Backup failed because')) {
                    preg_match('/Backup failed because(.*?)$/ms', $output, $match);
                    // $message .= "Backup Manager -- backup process failed because ";
                    // $message .= isset($match[1]) ? $match[1] : '';
                    Log::error('Backup Manager -- backup process failed because'.PHP_EOL.$output);
                } else {
                    Log::info('Backup Manager -- backup process has started');
                }
            }
        } catch (Exception $exception) {
            Log::info('backup update failed - '.$exception->getMessage());
        }
    }
}
