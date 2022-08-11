@component('mail::message')
<div style="text-align:right"><img src="https://assoparentscfbl.org.uk/assets/logos/logo-apc-for-emails.png" fill='none' width="108" height="58" /></div>

# Invoice for order #{{ $order->orderNumber() }}


@component('mail::table')
| Seller         | Customer       |
| :------------- | :------------- |
| CFBL Parents<br>87 Holmes road<br>London NW53AX<br>United Kingdom | {{ $order->get('billing_name') }}<br>{{ $order->get('billing_address') }}<br>{{ $order->get('billing_city') }} {{ $order->get('billing_zip_code') }}<br>{{ $order->get('billing_country') }} |
| contactcfblp@gmail.com | {{ $order->customer()->email() }} |
| | |
@endcomponent

## Items
@component('mail::table')
| Name       | Quantity         | Total |
| :--------- | :------------- | :----- |
@foreach ($order->lineItems() as $lineItem)
| **{{ $lineItem->product()->get('title') }}**@if($lineItem->variant()) ({{ $lineItem->variant()['variant'] }})@endif | @if(!$lineItem->product()->get('open_price')){{ $lineItem->quantity() }}@endif | {{ \DoubleThreeDigital\SimpleCommerce\Currency::parse($lineItem->total(), $site) }} |
@if($lineItem->product()->get('instructions'))
| ⚠️ {!! nl2br($lineItem->product()->get('instructions')) !!}
@endif
| | | |
@endforeach
@if($order->coupon())
| | Coupon: | -{{ \DoubleThreeDigital\SimpleCommerce\Currency::parse($order->couponTotal(), $site) }}
@endif
| | **Total:** | **{{ \DoubleThreeDigital\SimpleCommerce\Currency::parse($order->grandTotal(), $site) }}**
| | |
@endcomponent

@if($order->get('note'))
## Note from customer
{{ $order->get('note') }}
@endif

@endcomponent
