<x-mail::message>
# {{ __('Welcome to') }} {{ settings('site_title') }}!

{{ __('Thank you for creating an account with us. We are excited to have you as a customer') }}.

{{ __('Here is your account information') }}:

- {{ __('Name') }}: {{ $customer->name }}
- {{ __('Email') }}: {{ $customer->email }}
- {{ __('Password') }}: {{ $customer->password }}

{{ __('Please keep this information safe for future reference') }}.

<x-mail::button :url="route('front.myaccount')" color="success">
{{ __('Login to your account') }}
</x-mail::button>

{{ __('We hope you enjoy shopping with us') }}!
</x-mail::message>