@section('title', $entity == 'Customer' ? __('Sale Invoice') : __('Purchase Invoice'))

<body class="photography-template">

    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <div class="invoice-container-wrap">
        <div class="invoice-container">
            <main>

                <div class="th-invoice invoice_style2">
                    <div class="download-inner" id="download_section">

                        <header class="th-header header-layout2">
                            <div class="row align-items-center justify-content-end">
                                <div class="col-auto">
                                    <div class="header-logo">
                                        <a href=""><img src="{{ asset('images/logo.png') }}"
                                                alt="{{ settings('company_name') }}"></a>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <div class="row justify-content-between mb-30 mt-5 pt-4">
                            <div class="col-auto">
                                <div class="invoice-left">
                                    <b>{{ __('Invoiced To') }}:</b>
                                    <address>
                                        @if ($entity == 'Customer')
                                            <i class="fas fa-user"></i> {{ $data->customer->name }}<br>
                                            <i class="fas fa-map-marker-alt"></i> {{ $data->customer->address }} <br>
                                            <i class="fas fa-envelope"></i> {{ $data->customer->email }} <br>
                                            <i class="fas fa-phone"></i> {{ $data->customer->phone }}
                                        @elseif($entity == 'Supplier')
                                            <i class="fas fa-user"></i> {{ $data->supplier->name }}<br>
                                            <i class="fas fa-map-marker-alt"></i> {{ $data->supplier->address }} <br>
                                            <i class="fas fa-envelope"></i> {{ $data->supplier->email }} <br>
                                            <i class="fas fa-phone"></i> {{ $data->supplier->phone }}
                                        @endif
                                    </address>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="invoice-left">
                                    <b>{{ settings('company_name') }}:</b>
                                    <address>
                                        {{ settings('company_address') }} <br>
                                        {{ settings('company_phone') }}
                                    </address>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="invoice-right">
                                    <h1 class="big-title">
                                        @if ($entity == 'Customer')
                                            {{ __('Sale Details') }}
                                        @elseif($entity == 'Supplier')
                                            {{ __('Purchase Details') }}
                                        @endif
                                    </h1>
                                    <p class="invoice-number"><b>{{ __('Reference No') }}: </b>
                                        {{ $data->reference }}
                                    </p>
                                    <p class="invoice-date"><b>Date: </b>
                                        {{ format_date($data->date) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <table class="invoice-table style2">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Product') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Unit Price') }}</th>
                                    <th>{{ __('Subtotal') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($entity == 'Customer')
                                    @foreach ($data->saleDetails as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }} <br>
                                                {{ $item->code }}
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                {{ format_currency($item->unit_price) }}
                                            </td>
                                            <td>
                                                {{ format_currency($item->sub_total) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif($entity == 'Supplier')
                                    @foreach ($data->purchaseDetails as $index => $item)
                                        <tr>
                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                {{ $item->name }} <br>
                                                {{ $item->code }}
                                            </td>
                                            <td>
                                                {{ $item->quantity }}
                                            </td>
                                            <td>
                                                {{ format_currency($item->unit_price) }}
                                            </td>
                                            <td>
                                                {{ format_currency($item->sub_total) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <div class="invoice-left mb-4">
                                    <b>Payment Info:</b>
                                    <p class="mb-0">Account : 1234 5678 9012<br>
                                        A/C Name : Alex Farnandes<br>
                                </div>
                                <div class="invoice-left mb-4">
                                    <b>{{ __('Payment Status') }}:</b>
                                    <p>
                                        @php
                                            $type = $data->payment_status->getBadgeType();
                                        @endphp
                                        <span
                                            class="btn btn-{{ $type }} text-black">{{ $data->payment_status->label() }}</span>
                                    </p>
                                    @if ($data->due_amount > 0)
                                        <b>{{ __('Due Amount') }}:</b>
                                        <p>
                                            <strong>{{ format_currency($data->due_amount) }}</strong>
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-auto">
                                <table class="total-table">
                                    @if (settings('show_order_tax') == true)
                                        <tr>
                                            <td class="left"><strong>{{ __('Discount') }}
                                                    ({{ $data->discount_percentage }}%)</strong></td>
                                            <td class="right">
                                                {{ format_currency($data->discount_amount) }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if (settings('show_discount') == true)
                                        <tr>
                                            <td class="left"><strong>{{ __('Tax') }}
                                                    ({{ $data->tax_percentage }}%)</strong></td>
                                            <td class="right">
                                                {{ format_currency($data->tax_amount) }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if (settings('show_shipping') == true)
                                        <tr>
                                            <td class="left"><strong>{{ __('Shipping') }}</strong>
                                            </td>
                                            <td class="right">
                                                {{ format_currency($data->shipping_amount) }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="left"><strong>{{ __('Grand Total') }}</strong>
                                        </td>
                                        <td class="right">
                                            <strong>{{ format_currency($data->total_amount) }}</strong>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                        <div class="footer-info">
                            <p class="mb-0">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="4" fill="#FDA40D" />
                                    <path
                                        d="M15.25 12C15.5312 12.125 15.7344 12.3203 15.8594 12.5859C15.9844 12.8359 16.0156 13.1094 15.9531 13.4062L15.4609 15.5391C15.3984 15.8359 15.2578 16.0703 15.0391 16.2422C14.8203 16.4141 14.5703 16.5 14.2891 16.5C12.3672 16.4844 10.6328 16.0156 9.08594 15.0938C7.55469 14.1719 6.32812 12.9453 5.40625 11.4141C4.48438 9.86719 4.01562 8.13281 4 6.21094C4 5.92969 4.08594 5.67969 4.25781 5.46094C4.42969 5.24219 4.66406 5.09375 4.96094 5.01562L7.09375 4.52344C7.39062 4.46094 7.66406 4.5 7.91406 4.64062C8.17969 4.76562 8.375 4.96875 8.5 5.25L9.48438 7.57031C9.59375 7.82031 9.61719 8.07812 9.55469 8.34375C9.49219 8.60938 9.35156 8.82812 9.13281 9L8.33594 9.65625C8.96094 10.7031 9.80469 11.5391 10.8672 12.1641L11.5234 11.3672C11.6953 11.1484 11.9141 11.0078 12.1797 10.9453C12.4453 10.8828 12.7031 10.9062 12.9531 11.0156L15.25 12ZM14.875 13.1484C14.875 13.1016 14.8516 13.0547 14.8047 13.0078L12.5078 12.0234C12.4609 12.0078 12.4219 12.0234 12.3906 12.0703L11.4531 13.1953C11.25 13.4141 11.0234 13.4688 10.7734 13.3594C9.97656 12.9688 9.26562 12.4609 8.64062 11.8359C8.03125 11.2109 7.52344 10.5 7.11719 9.70312C7.00781 9.4375 7.0625 9.21094 7.28125 9.02344L8.42969 8.10938C8.46094 8.07812 8.46875 8.03906 8.45312 7.99219L7.46875 5.69531C7.4375 5.64844 7.40625 5.625 7.375 5.625C7.35938 5.625 7.35156 5.625 7.35156 5.625L5.19531 6.11719C5.14844 6.13281 5.125 6.16406 5.125 6.21094C5.14062 7.91406 5.55469 9.45312 6.36719 10.8281C7.19531 12.2031 8.29688 13.3047 9.67188 14.1328C11.0469 14.9453 12.5859 15.3594 14.2891 15.375C14.3359 15.3594 14.3672 15.3359 14.3828 15.3047L14.875 13.1484Z"
                                        fill="url(#paint0_linear_384_4)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_384_4" x1="9.99996" y1="14.9999"
                                            x2="9.99996" y2="4.99955" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#21171F" />
                                            <stop offset="1" stop-color="#3E4049" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                {{ settings('company_phone') }}
                            </p>
                            <p class="mb-0">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="20" height="20" rx="4" fill="#FDA40D" />
                                    <path
                                        d="M4 7.5C4.01562 7.07812 4.16406 6.72656 4.44531 6.44531C4.72656 6.16406 5.07812 6.01562 5.5 6H14.5C14.9219 6.01562 15.2734 6.16406 15.5547 6.44531C15.8359 6.72656 15.9844 7.07812 16 7.5V13.5C15.9844 13.9219 15.8359 14.2734 15.5547 14.5547C15.2734 14.8359 14.9219 14.9844 14.5 15H5.5C5.07812 14.9844 4.72656 14.8359 4.44531 14.5547C4.16406 14.2734 4.01562 13.9219 4 13.5V7.5ZM5.125 7.5V8.01562L9.17969 11.3438C9.42969 11.5312 9.70312 11.625 10 11.625C10.2969 11.625 10.5781 11.5312 10.8438 11.3438L14.875 8.01562V7.47656C14.8594 7.25781 14.7344 7.13281 14.5 7.10156H5.5C5.26562 7.13281 5.14062 7.25781 5.125 7.47656V7.5ZM5.125 9.46875V13.5C5.14062 13.7344 5.26562 13.8594 5.5 13.875H14.5C14.7344 13.8594 14.8594 13.7344 14.875 13.5V9.46875L11.5469 12.2109C11.0781 12.5703 10.5625 12.75 10 12.75C9.4375 12.75 8.91406 12.5703 8.42969 12.2109L5.125 9.46875Z"
                                        fill="url(#paint0_linear_384_5)" />
                                    <defs>
                                        <linearGradient id="paint0_linear_384_5" x1="9.99996" y1="14.9999"
                                            x2="9.99996" y2="4.99955" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#21171F" />
                                            <stop offset="1" stop-color="#3E4049" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                {{ settings('company_adress') }}
                            </p>
                        </div>
                    </div>
                    <div class="body-shape1">
                        <img src="{{ asset('assets/img/template/photography_shape.svg') }}" alt="shape">
                    </div>
                    <div class="body-shape2">
                        <img src="{{ asset('assets/img/template/photography_footer.svg') }}" alt="shape">
                    </div>
                    <div class="invoice-buttons">
                        <button class="print_btn">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.25 13C16.6146 13 16.9141 13.1172 17.1484 13.3516C17.3828 13.5859 17.5 13.8854 17.5 14.25V19.25C17.5 19.6146 17.3828 19.9141 17.1484 20.1484C16.9141 20.3828 16.6146 20.5 16.25 20.5H3.75C3.38542 20.5 3.08594 20.3828 2.85156 20.1484C2.61719 19.9141 2.5 19.6146 2.5 19.25V14.25C2.5 13.8854 2.61719 13.5859 2.85156 13.3516C3.08594 13.1172 3.38542 13 3.75 13H16.25ZM16.25 19.25V14.25H3.75V19.25H16.25ZM17.5 8C18.2031 8.02604 18.7891 8.27344 19.2578 8.74219C19.7266 9.21094 19.974 9.79688 20 10.5V14.875C19.974 15.2656 19.7656 15.474 19.375 15.5C18.9844 15.474 18.776 15.2656 18.75 14.875V10.5C18.75 10.1354 18.6328 9.83594 18.3984 9.60156C18.1641 9.36719 17.8646 9.25 17.5 9.25H2.5C2.13542 9.25 1.83594 9.36719 1.60156 9.60156C1.36719 9.83594 1.25 10.1354 1.25 10.5V14.875C1.22396 15.2656 1.01562 15.474 0.625 15.5C0.234375 15.474 0.0260417 15.2656 0 14.875V10.5C0.0260417 9.79688 0.273438 9.21094 0.742188 8.74219C1.21094 8.27344 1.79688 8.02604 2.5 8V3C2.52604 2.29688 2.77344 1.71094 3.24219 1.24219C3.71094 0.773438 4.29688 0.526042 5 0.5H14.7266C15.0651 0.5 15.3646 0.617188 15.625 0.851562L17.1484 2.375C17.3828 2.60938 17.5 2.90885 17.5 3.27344V8ZM16.25 8V3.27344L14.7266 1.75H5C4.63542 1.75 4.33594 1.86719 4.10156 2.10156C3.86719 2.33594 3.75 2.63542 3.75 3V8H16.25ZM16.875 10.1875C17.4479 10.2396 17.7604 10.5521 17.8125 11.125C17.7604 11.6979 17.4479 12.0104 16.875 12.0625C16.3021 12.0104 15.9896 11.6979 15.9375 11.125C15.9896 10.5521 16.3021 10.2396 16.875 10.1875Z"
                                    fill="#111111" />
                            </svg>
                        </button>
                        <button id="download_btn" class="download_btn">
                            <svg width="25" height="19" viewBox="0 0 25 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8.94531 11.1797C8.6849 10.8932 8.6849 10.6068 8.94531 10.3203C9.23177 10.0599 9.51823 10.0599 9.80469 10.3203L11.875 12.3516V6.375C11.901 5.98438 12.1094 5.77604 12.5 5.75C12.8906 5.77604 13.099 5.98438 13.125 6.375V12.3516L15.1953 10.3203C15.4818 10.0599 15.7682 10.0599 16.0547 10.3203C16.3151 10.6068 16.3151 10.8932 16.0547 11.1797L12.9297 14.3047C12.6432 14.5651 12.3568 14.5651 12.0703 14.3047L8.94531 11.1797ZM10.625 0.75C11.7969 0.75 12.8646 1.01042 13.8281 1.53125C14.8177 2.05208 15.625 2.76823 16.25 3.67969C16.8229 3.39323 17.4479 3.25 18.125 3.25C19.375 3.27604 20.4036 3.70573 21.2109 4.53906C22.0443 5.34635 22.474 6.375 22.5 7.625C22.5 8.01562 22.4479 8.41927 22.3438 8.83594C23.151 9.2526 23.7891 9.85156 24.2578 10.6328C24.7526 11.4141 25 12.2865 25 13.25C24.974 14.6562 24.4922 15.8411 23.5547 16.8047C22.5911 17.7422 21.4062 18.224 20 18.25H5.625C4.03646 18.1979 2.70833 17.651 1.64062 16.6094C0.598958 15.5417 0.0520833 14.2135 0 12.625C0.0260417 11.375 0.377604 10.2812 1.05469 9.34375C1.73177 8.40625 2.63021 7.72917 3.75 7.3125C3.88021 5.4375 4.58333 3.88802 5.85938 2.66406C7.13542 1.4401 8.72396 0.802083 10.625 0.75ZM10.625 2C9.08854 2.02604 7.78646 2.54688 6.71875 3.5625C5.67708 4.57812 5.10417 5.85417 5 7.39062C4.94792 7.91146 4.67448 8.27604 4.17969 8.48438C3.29427 8.79688 2.59115 9.33073 2.07031 10.0859C1.54948 10.8151 1.27604 11.6615 1.25 12.625C1.27604 13.875 1.70573 14.9036 2.53906 15.7109C3.34635 16.5443 4.375 16.974 5.625 17H20C21.0677 16.974 21.9531 16.6094 22.6562 15.9062C23.3594 15.2031 23.724 14.3177 23.75 13.25C23.75 12.5208 23.5677 11.8698 23.2031 11.2969C22.8385 10.724 22.3568 10.2682 21.7578 9.92969C21.2109 9.59115 21.0026 9.09635 21.1328 8.44531C21.2109 8.21094 21.25 7.9375 21.25 7.625C21.224 6.73958 20.9245 5.9974 20.3516 5.39844C19.7526 4.82552 19.0104 4.52604 18.125 4.5C17.6302 4.5 17.1875 4.60417 16.7969 4.8125C16.1719 5.04688 15.651 4.90365 15.2344 4.38281C14.7135 3.65365 14.0495 3.08073 13.2422 2.66406C12.4609 2.22135 11.5885 2 10.625 2Z"
                                    fill="white" />
                            </svg>
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Jquery -->
    <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- PDF Generator -->
    <script src="{{ asset('assets/js/jspdf.min.js') }}"></script>
    <script src="{{ asset('assets/js/html2canvas.min.js') }}"></script>
    <!-- Main Js File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>