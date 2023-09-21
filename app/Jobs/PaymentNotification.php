<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Sale;
use App\Models\User;
use App\Notifications\PaymentDue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentNotification implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** Create a new job instance. */
    public function __construct(protected Sale $sale)
    {
    }

    /** Execute the job. */
    public function handle(): void
    {
        if ( ! $this->sale->due_amount || ! $this->sale->payment_date) {
            // $payment_date = Carbon::parse($this->sale->date)->addDays(15);

            // if (now()->gt($payment_date)) {
            $user = User::where('name', 'Admin')->first();

            $user->notify(new PaymentDue($this->sale));
            // }
        }
    }
}
