<x-mailing-template-layout>

    Dear <b>{{ $order->user->first_name . ' ' . $order->user->surname . ' ' . $order->user->other_name }} </b>, <br>

    Your Order with Ref: <b>{{ $order->order_number }}</b> for
    <b style="color:#9F2242">{{ $order->item_type == 'Reagent' ? $order->commodity->name : $order->asset->name }}</b>
    made on behalf of
    <b>{{ $order->institution->name }}, {{ $order->institution->country->name }}
    </b> has been <b>allocated, pending shipment.</b> <br>
    <x-mail::button :url="'https://africapginims.licts.co.ug'">
        Click here to proceed to {{ config('app.name') }}
    </x-mail::button>

</x-mailing-template-layout>
