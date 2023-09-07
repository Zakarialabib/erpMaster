<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Helpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class UnderMaintenanceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private $secret;
    private $refresh;

    public function __construct($secret = null, $refresh = false)
    {
        $this->secret = $secret;
        $this->refresh = $refresh;
    }

    public function handle(): void
    {
        if (settings('site_maintenance_status') === false) {
            Artisan::call('up');
        } else {
            Artisan::call('down', [
                '--secret'  => $this->secret,
                '--refresh' => $this->refresh,
            ]);
        }
    }
}
