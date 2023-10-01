<div>
    <section>
        <div class="px-4 mx-auto">
            <x-card>
                <h3 class="text-center">{{ __('Warehouse Report') }}</h3>
                <div class="grid grid-cols-4 mb-3">
                    <div>
                        <label class="d-tc mt-2"><strong>{{ __('Choose Your Date') }}</strong> &nbsp;</label>
                        <div class="d-tc">
                            <div class="input-group">
                                <input type="text" class="daterangepicker-field form-control"
                                    value="{{ $start_date }} To {{ $end_date }}" required />
                                <input type="hidden" name="start_date" value="{{ $start_date }}" />
                                <input type="hidden" name="end_date" value="{{ $end_date }}" />
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="d-tc mt-2"><strong>{{ __('Choose Warehouse') }}</strong>
                            &nbsp;</label>
                        <div class="d-tc">
                            <input type="hidden" name="warehouse_id_hidden" value="{{ $warehouse_id }}" />
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control"
                                data-live-search="true" data-live-search-style="begins">
                                @foreach ($lims_warehouse_list as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mt-3">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">{{ __('submit') }}</button>
                    </div>
                </div>
            </x-card>


            <div class="px-4 py-2">
                <div x-data="{ activeTab: 'quotation' }">
                    <ul class="flex border-b">
                        <li class="-mb-px mr-1">
                            <a :class="activeTab === 'quotation' ? 'bg-white rounded-t-md text-gray-700' :
                                'bg-gray-200 hover:bg-gray-300 rounded-t-md text-gray-600 hover:text-gray-700'"
                                @click.prevent="activeTab = 'quotation'" href="#">
                                {{ __('Quotation') }}
                            </a>
                        </li>
                        <li class="mr-1">
                            <a :class="activeTab === 'return' ? 'bg-white rounded-t-md text-gray-700' :
                                'bg-gray-200 hover:bg-gray-300 rounded-t-md text-gray-600 hover:text-gray-700'"
                                @click.prevent="activeTab = 'return'" href="#">
                                {{ __('Return') }}
                            </a>
                        </li>
                        <li class="mr-1">
                            <a :class="activeTab === 'expense' ? 'bg-white rounded-t-md text-gray-700' :
                                'bg-gray-200 hover:bg-gray-300 rounded-t-md text-gray-600 hover:text-gray-700'"
                                @click.prevent="activeTab = 'expense'" href="#">
                                {{ __('Expense') }}
                            </a>
                        </li>
                    </ul>

                    <div x-show="activeTab === 'quotation'">
                        <div class="table-responsive mb-4">
                            <table id="quotation-table" class="table table-hover w-full">
                                <thead>
                                    <tr>
                                        <th class="not-exported-quotation"></th>
                                        <th class="px-4 py-2">{{ __('Date') }}</th>
                                        <th class="px-4 py-2">{{ __('Reference') }}</th>
                                        <th class="px-4 py-2">{{ __('Customer') }}</th>
                                        <th class="px-4 py-2">{{ __('Supplier') }}</th>
                                        <th class="px-4 py-2">{{ __('Product') }}
                                            ({{ __('Qty') }})</th>
                                        <th class="px-4 py-2">{{ __('Grand Total') }}</th>
                                        <th class="px-4 py-2">{{ __('Status') }}</th>
                                    </tr>
                                </thead>

                                <tfoot class="tfoot active">
                                    <tr>
                                        <th></th>
                                        <th class="px-4 py-2">{{ __('Total') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="px-4 py-2">
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'return'">
                        <div class="table-responsive mb-4">
                            <table id="return-table" class="table table-hover w-full">
                                <thead>
                                    <tr>
                                        <th class="not-exported-return"></th>
                                        <th class="px-4 py-2">{{ __('Date') }}</th>
                                        <th class="px-4 py-2">{{ __('Reference') }}</th>
                                        <th class="px-4 py-2">{{ __('Customer') }}</th>
                                        <th class="px-4 py-2">{{ __('Biller') }}</th>
                                        <th class="px-4 py-2">{{ __('Product') }}
                                            ({{ __('Qty') }})</th>
                                        <th class="px-4 py-2">{{ __('Grand Total') }}</th>
                                    </tr>
                                </thead>

                                <tfoot class="tfoot active">
                                    <tr>
                                        <th></th>
                                        <th class="px-4 py-2">{{ __('Total') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="px-4 py-2">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div x-show="activeTab === 'expense'">
                        <div class="table-responsive mb-4">
                            <table id="expense-table" class="table table-hover w-full">
                                <thead>
                                    <tr>
                                        <th class="not-exported-expense"></th>
                                        <th class="px-4 py-2">{{ __('Date') }}</th>
                                        <th class="px-4 py-2">{{ __('Reference') }}</th>
                                        <th class="px-4 py-2">{{ __('Category') }}</th>
                                        <th class="px-4 py-2">{{ __('Amount') }}</th>
                                        <th class="px-4 py-2">{{ __('Note') }}</th>
                                    </tr>
                                </thead>

                                <tfoot class="tfoot active">
                                    <tr>
                                        <th></th>
                                        <th class="px-4 py-2">{{ __('Total') }}</th>
                                        <th></th>
                                        <th></th>
                                        <th class="px-4 py-2">
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>
