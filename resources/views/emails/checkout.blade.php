<x-mail::message>
    
#{{__('Hello ')}} {{ $customer->name }} {{__('Thank you for ordering from ')}} {{ settings('site_title') }}. 
    
## {{__('Order Confirmation ')}} 

{{__('Your order has been received and is now being processed.')}}

{{__('Here are the details of your order')}}:

<x-mail::table>
| {{__('Order Number')}} | {{__('Order Date')}} | {{__('Shipping Method')}} | {{__('Shipping Address')}} | {{__('Subtotal')}} | {{__('Tax')}} | {{__('Shipping')}} | {{__('Total')}} |
| :------------- | :------------- | :------------- | :------------- | :------------- | :------------- | :------------- | :------------- |
| {{ $order->reference }} | {{ $order->created_at }} | {{ $order->shipping->name }} | {{ $order->shipping_address }} | {{ $order->subtotal }} | {{ $order->tax }} | {{ $order->shipping->name }} | {{ $order->total }} |
</x-mail::table>

{{__('Your order details')}}:

<x-mail::table>
| {{__('Product Name')}} | {{__('Quantity')}} | {{__('Price')}} |
| :------------- | :------------- | :------------- |
@foreach ($order->orderdetails as $order_product)
| {{ $order_product->product->name }} | {{ $order_product->quantity }} | {{ $order_product->price }} |
@endforeach
</x-mail::table>

{{__('Your order has been shipped and you will receive an email with tracking information shortly.')}}

{{__('Thank you for shopping with us!')}}

<x-mail::button :url="route('front.myaccount')" color="success">
{{ __('Login to your account') }}
</x-mail::button>

</x-mail::message>