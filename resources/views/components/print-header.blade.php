@props(['entity', 'sale', 'purchase', 'template', 'logo', 'style' => 'left' , 'logo'])
@php
    $headerStyle = config("invoice.templates.$template.header.style");
    $columns = config("invoice.templates.$template.header.columns");
    $logoStyle = config("invoice.templates.$template.header.logo.style");
    $containerStyle = config("invoice.templates.$template.container.style");
    $tableStyle = config("invoice.templates.$template.table.style");
@endphp

<table style="width:100%; margin:20px 0">
    <tr>
        @if ($columns === 2)
            <td style="{{ $containerStyle }}">
                <img src="{{ $logo }}" style="{{ $logoStyle['style'] }}" />
                <div style="{{ $headerStyle }}">
                    {{ settings('company_name') }}<br />
                    {{ settings('company_address') }}<br />
                    {{ settings('company_phone') }}<br />
                </div>
            </td>
        @elseif ($columns === 3)
            <td style="{{ $containerStyle }}">
                <div style="{{ $headerStyle }}">
                    {{ settings('company_name') }}<br />
                    {{ settings('company_address') }}<br />
                    {{ settings('company_phone') }}<br />
                </div>
            </td>
            <td style="{{ $headerStyle['text-align'] }}">
                <img src="{{ $logo }}" style="{{ $logoStyle['style'] }}" />
            </td>
        @elseif($style === 'left')
            <td style="{{ $containerStyle }}">
                <div style="{{ $headerStyle }}">
                    {{ settings('company_name') }}<br />
                    {{ settings('company_address') }}<br />
                    {{ settings('company_phone') }}<br />
                </div>
            </td>
            <td style="width:50%; text-align:right;">
                <img src="{{ $logo }}" style="{{ $logoStyle['style'] }}" />
            </td>
        @endif
    </tr>
</table>

<table style="width:100%; border-collapse:collapse">
    <thead>
        <tr>
            <th style="{{ $tableStyle }}">
                @if ($entity instanceof \App\Models\Customer)
                    {{ $entity->name }} - {{ __('Sale Details') }}
                @elseif($entity instanceof \App\Models\Supplier)
                    {{ $entity->name }} - {{ __('Purchase Details') }}
                @endif
            </th>

            <th style="{{ $tableStyle }}">
                @if ($entity instanceof \App\Models\Customer)
                    {{ __('Customer Information') }}
                @elseif($entity instanceof \App\Models\Supplier)
                    {{ __('Supplier Information') }}
                @endif
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="{{ $tableStyle }}">
                @if ($entity)
                    {{ __('Name') }}: {{ $entity->name }}<br>
                    {{ __('Address') }}: {{ $entity->address }}<br>
                    {{ __('Phone') }}: {{ $entity->phone }}<br>
                    {{ __('Email') }}: {{ $entity->email }}
                @endif
            </td>
            @if (isset($sale))
                <td style="{{ $tableStyle }}">
                    {{ __('Reference') }}: {{ $sale->reference }}<br>
                    {{ __('Date') }}: {{ format_date($sale->date) }}<br>
                    {{ __('Status') }}:
                    @php
                        $badgeType = $sale->status->getBadgeType();
                    @endphp

                    <x-badge :type="$badgeType">{{ $sale->status->label() }}</x-badge>
                    <br>
                    {{ __('Payment Status') }}:
                    @php
                        $type = $sale->payment_status->getBadgeType();
                    @endphp
                    <x-badge :type="$type">{{ $sale->payment_status->label() }}</x-badge>
                </td>
            @elseif(isset($purchase))
                <td style="{{ $tableStyle }}">
                    {{ __('Reference') }}: {{ $purchase->reference }}<br>
                    {{ __('Date') }}:{{ format_date($purchase->date) }}<br>
                    <strong>{{ __('Status') }}:</strong>
                    @php
                        $badgeType = $purchase->status->getBadgeType();
                    @endphp

                    <x-badge :type="$badgeType">{{ $purchase->status->label() }}</x-badge>
                    <br>
                    <strong>{{ __('Payment Status') }}:</strong><br>
                    @php
                        $type = $purchase->payment_status->getBadgeType();
                    @endphp
                    <x-badge :type="$type">{{ $purchase->payment_status->label() }}</x-badge>
                </td>
            @endif
        </tr>
    </tbody>
</table>
