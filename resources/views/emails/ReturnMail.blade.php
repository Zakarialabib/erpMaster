@component('mail::message')

<h2 class="text-center">{{__('Return order')}}</h2>

<h3>{{__('Hello')}}</h3>
<h3>{{__('Return Number')}}: {{ $data['reference'] }}</h3>
<h3>{{__('Review receipt in the attachment')}} </h3>

<span>{{__('Regards')}},<span><br>
    {{ settings('company_name') }}
@endcomponent
