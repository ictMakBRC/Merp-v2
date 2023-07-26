<x-mailing-template-layout>

  Dear <b>{{ $donation->institution->name }}</b>,<br>
  Africa PGI will be dispatching a shipment of {{ $donation->quantity }} {{ $donation->item_type }}(s) with Invoice #:
  <b>{{ $donation->invoice_number }} destined to your facility.
    <br>
    The expected shipment date is: <b>{{ $donation->shipment_date_to_lab }}</b>
    <br>
    <x-mail::button :url="'https://africapginims.licts.co.ug'">
    Click here to proceed to {{ config('app.name') }}
  </x-mail::button>

</x-mailing-template-layout>
