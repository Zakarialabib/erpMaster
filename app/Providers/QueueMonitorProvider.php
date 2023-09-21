<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\QueueMonitor;
use Illuminate\Contracts\Queue\Job as JobContract;
use Illuminate\Queue\Events\JobExceptionOccurred;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Throwable;

class QueueMonitorProvider extends ServiceProvider
{
    /** Bootstrap services. */
    public function boot(): void
    {
        Queue::before(static function (JobProcessing $event): void {
            self::jobStarted($event->job);
        });

        Queue::after(static function (JobProcessed $event): void {
            self::jobFinished($event->job);
        });

        Queue::failing(static function (JobFailed $event): void {
            self::jobFinished($event->job, true, $event->exception);
        });

        Queue::exceptionOccurred(static function (JobExceptionOccurred $event): void {
            self::jobFinished($event->job, true, $event->exception);
        });
    }

    /** Get Job ID. */
    public static function getJobId(JobContract $job): string|int
    {
        return QueueMonitor::getJobId($job);
    }

    /** Start Queue Monitoring for Job. */
    protected static function jobStarted(JobContract $job): void
    {
        $now = now();
        $jobId = self::getJobId($job);

        $monitor = QueueMonitor::query()->create([
            'job_id'     => $jobId,
            'name'       => $job->resolveName(),
            'queue'      => $job->getQueue(),
            'started_at' => $now,
            'attempt'    => $job->attempts(),
            'progress'   => 0,
        ]);

        QueueMonitor::query()
            ->where('id', '!=', $monitor->id)
            ->where('job_id', $jobId)
            ->where('failed', false)
            ->whereNull('finished_at')
            ->each(static function (QueueMonitor $monitor): void {
                $monitor->finished_at = now();
                $monitor->failed = true;
                $monitor->save();
            });
    }

    /** Finish Queue Monitoring for Job. */
    protected static function jobFinished(JobContract $job, bool $failed = false, ?Throwable $exception = null): void
    {
        $monitor = QueueMonitor::query()
            ->where('job_id', self::getJobId($job))
            ->where('attempt', $job->attempts())
            ->orderByDesc('started_at')
            ->first();

        if (null === $monitor) {
            return;
        }

        $attributes = [
            'progress'    => 100,
            'finished_at' => now(),
            'failed'      => $failed,
        ];

        if ($exception instanceof Throwable) {
            $attributes += [
                'exception_message' => mb_strcut($exception->getMessage(), 0, 65535),
            ];
        }

        $monitor->update($attributes);
    }
}
