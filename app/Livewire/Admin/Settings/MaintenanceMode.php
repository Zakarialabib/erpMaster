<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Settings;

use App\Jobs\UnderMaintenanceJob;
use App\Models\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MaintenanceMode extends Component
{
    use LivewireAlert;

    public $site_maintenance_message;

    public $status;

    public $secret;

    public $refresh;

    public function mount(): void
    {
        $this->site_maintenance_message = settings('site_maintenance_message');
        $this->status = settings('site_maintenance_status');
        $this->refresh = settings('site_refresh');
        $this->secret = Str::uuid()->toString();
    }

    public function saveSettings(): void
    {
        $this->validate([
            'site_maintenance_message' => 'required',
            // 'site_maintenance_status' => 'required',
        ]);

        Settings::set('site_maintenance_message', $this->site_maintenance_message);
        Settings::set('site_refresh', $this->refresh);

        $this->alert('success', __('Settings saved successfully.'));
    }

    public function turnOff(): RedirectResponse
    {
        Settings::set('site_maintenance_status', false);

        Settings::set('site_maintenance_secret', $this->secret);

        UnderMaintenanceJob::dispatch($this->secret, $this->refresh);

        $this->alert('success', implode(' ', ['status' => $this->status ? __('System turned on') : __('System turned off')]));

        return redirect()->route('front.index', ['secret' => $this->secret]);
        // Send email notification
        // Mail::to($user)->send(new MaintenanceModeNotification(false));
    }

    public function turnOn(): void
    {
        Artisan::call('up');

        Settings::set('site_maintenance_status', true);

        $this->alert('success', __('System turned on.'));

        // $user = auth()->user()->email;
        // Send email notification
        // Mail::to($user)->send(new MaintenanceModeNotification(true));
    }

    public function render()
    {
        return view('livewire.admin.settings.maintenance-mode');
    }
}
