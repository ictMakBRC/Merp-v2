<x-mailing-template-layout>

    Dear <b>{{ $facility_order->user->first_name . ' ' . $facility_order->user->surname . ' ' . $facility_order->user->other_name }}
    </b>, <br>

    Your order with Ref: <b>{{ $facility_order->order_number }}</b> for
    <b style="color:#9F2242">{{ $facility_order->item_type == 'Reagent' ? $facility_order->commodity->name : $facility_order->asset->name }}
    </b> made on behalf of <b>{{ $facility_order->institution->name }},
        {{ $facility_order->institution->country->name }}
    </b> has been <b style="color:red"> REJECTED</b> by the Africa PGI. <br>
    <b>Reason For Rejection</b><br>
    {{ $facility_order->rejectionReason->name }}
    <x-mail::button :url="'https://africapginims.licts.co.ug'">
        Click here to proceed to {{ config('app.name') }}
    </x-mail::button>
  
</x-mailing-template-layout>
