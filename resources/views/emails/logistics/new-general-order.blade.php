
<x-mailing-template-layout>
Hello <b>Africa PGI Logistics Coordinator</b>, <br>

<b>{{ $order_item_list[0]['institution']['country']['name'] }}, {{ $order_item_list[0]['institution']['name'] }}</b> has submitted a/an <b>{{ $order_item_list[0]['request_type'] }} request</b> <br>
with Order Number: <b>{{ $order_item_list[0]['order_number'] }}</b> for the following items.


  <x-mail::button :url="'https://africapginims.licts.co.ug'">
  Click here to proceed to {{ config('app.name') }}
</x-mail::button>

</x-mailing-template-layout>
