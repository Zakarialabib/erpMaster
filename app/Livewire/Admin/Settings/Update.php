<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Helpers\GitHandler;
use Livewire\Component;

class Update extends Component
{
    public $message;
    public $updateAvailable;

    public function checkForUpdates()
    {
        $gitHandler = new GitHandler();
        $updatesAvailable = $gitHandler->checkForUpdates();

        if ($updatesAvailable) {
            $this->updateAvailable = true;
            $this->message = 'Updates available on origin/'.env('GIT_BRANCH', 'master').'.';
        } else {
            $this->message = 'No updates available.';
        }
    }

    public function updateSystem()
    {
        $gitHandler = new GitHandler();
        $this->message = $gitHandler->fetchAndPull();
    }

    public function render()
    {
        return view('livewire.admin.settings.update');
    }
}
