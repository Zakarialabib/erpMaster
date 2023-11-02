<div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-gray-600 font-bold text-xl mb-2">{{ __('Total Jobs Executed') }}</div>
            <div class="text-gray-900 font-bold text-3xl">{{ $totalJobsExecuted }}</div>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-gray-600 font-bold text-xl mb-2">{{ __('Total Execution Time') }}</div>
            <div class="text-gray-900 font-bold text-3xl">{{ $totalExecutionTime }}</div>
        </div>
        <div class="bg-white shadow-lg rounded-lg p-6">
            <div class="text-gray-600 font-bold text-xl mb-2">{{ __('Average Execution Time') }}</div>
            <div class="text-gray-900 font-bold text-3xl">{{ $averageExecutionTime }}</div>
        </div>
    </div>

    <div class="mt-8">
        <div class="flex items-center">
            <label for="search" class="mr-2">Search:</label>
            <x-input type="text" name="search" id="search" class="border rounded px-2 py-1" wire:model.lazy="search" />
        </div>

        <table class="min-w-full table-auto">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left">{{ __('Status') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('Name') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('Queue') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('Progress') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('Started At') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jobs as $job)
                    <tr>
                        <td class="border px-4 py-2">{{ $job->status }}</td>
                        <td class="border px-4 py-2">{{ $job->name }}</td>
                        <td class="border px-4 py-2">
                            <div x-data="{ progress: {{ $job->progress }} }">
                                <div class="relative w-full h-2 bg-gray-200 rounded-full">
                                    <div class="absolute top-0 left-0 h-2 bg-blue-500 rounded-full" :style="'width: ' + progress + '%'"></div>
                                </div>
                                <div class="text-sm text-gray-600">{{ $job->progress }}%</div>
                            </div>
                        </td>
                        <td class="border px-4 py-2">{{ $job->progress }}</td>
                        <td class="border px-4 py-2">{{ $job->started_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
