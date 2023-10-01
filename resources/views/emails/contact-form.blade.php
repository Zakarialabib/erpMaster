<x-mail::message>
# {{ __('Dear Admin') }}

## {{ __('New Contact Form Submission details') }} 

- **{{__('Name')}}:** {{ $contact->name }}
- **{{__('Email')}}:** {{ $contact->email }}
- **{{__('Phone number')}}:** {{ $contact->phone_number }}

**{{__('Message')}}:**
<p>
{{ $contact->message }}
</p>


<x-mail::button :url="route('front.myaccount')" color="success">
{{ __('Login to your account') }}
</x-mail::button>

</x-mail::message>