@component('mail::message')
# {{ __('Dear Admin') }}

## {{ __('New Request Submission details') }} 

- **{{__('Name')}}:** "{{ $orderForm->name }}"
- **{{__('Phone')}}:** "{{ $orderForm->phone }}"
- **{{__('Address')}}:** "{{ $orderForm->address }}"
- **{{__('Type')}}:** "{{ $orderForm->type }}"
- **{{__('Status')}}:** "{{ $orderForm->status }}"
- **{{__('Subject')}}:** "{{ $orderForm->subject }}"


**{{__('Message')}}:**
<p>
{{ $orderForm->message }}
</p>

@component('mail::button', ['url' => route('admin.dashboard')])
{{ __('Go to Dashboard') }}
@endcomponent

@endcomponent