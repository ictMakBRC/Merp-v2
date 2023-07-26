<x-mailing-template-layout>
    Hello <b>Africa PGI Logistics Coordinator</b>, <br>

    <b>{{ $order->institution->name }}, {{ $order->institution->country->name }}</b> has submitted a request</b> <br>
    with Order Number: <b>{{ $order->order_number }}</b>
    <x-mail::button :url="'https://africapginims.licts.co.ug'">
        Click here to proceed to {{ config('app.name') }}
    </x-mail::button>
</x-mailing-template-layout>
