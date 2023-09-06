<div>
    @section('title', __('Dashboard'))
    
    @livewire('admin.stats.transactions')

    <div class="flex flex-row px-6 my-4">
        <div class="lg:w-1/2 md:w-full6">
            <x-card>
                <h5 class="font-bold py-2 text-xl">{{ __('Recent Order(s)') }}</h5>
                <div class="card-body">
                    <div class="">
                        <x-table>
                            <x-slot name="thead">
                                <x-table.tr>
                                    <x-table.th>{{ __('Order Number') }}</x-table.th>
                                    <x-table.th>{{ __('Order Date') }}</x-table.th>
                                </x-table.tr>
                                @foreach ($recentOrders as $data)
                                    <x-table.tr>
                                        <x-table.td>{{ $data->order_number }}</x-table.td>
                                        <x-table.td>{{ date('Y-m-d', strtotime($data->created_at)) }}</x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-slot>
                        </x-table>
                    </div>

                </div>
            </x-card>
        </div>

        <div class="lg:w-1/2 md:w-full6">
            <x-card>
                <h5 class="font-bold py-2 text-xl">{{ __('Recent Customer(s)') }}</h5>
                <div class="card-body">

                    <div class="table-responsive  dashboard-home-table">
                        <x-table>
                            <x-slot name="thead">
                                <x-table.tr>
                                    <x-table.th>{{ __('Customer Email') }}</x-table.th>
                                    <x-table.th>{{ __('Joined') }}</x-table.th>
                                </x-table.tr>
                            </x-slot>
                            <x-table.tbody>
                                @foreach ($recentUsers as $data)
                                    <x-table.tr>
                                        <x-table.td>{{ $data->email }}</x-table.td>
                                        <x-table.td>{{ $data->created_at }}</x-table.td>
                                    </x-table.tr>
                                @endforeach
                            </x-table.tbody>
                        </x-table>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

</div>
