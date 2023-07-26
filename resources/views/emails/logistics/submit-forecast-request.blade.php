<x-mailing-template-layout>

    Dear <b>{{ $config->institution->name }}</b>,<br>
    Africa PGI requests that you submit reagents and/or equipment requests/orders
    and forecasts required for PGI related laboratory tests before <b>{{ $config->end_date }}</b>.
    <br>
    You will not be able to submit requests or forecasts after <b>{{ $config->end_date }}</b>.
    <br>
    <br>
    <b>Remarks from Africa PGI</b><br>
    {{ $config->comment }}

    <x-mail::button :url="'https://africapginims.licts.co.ug'">
        Click here to proceed to {{ config('app.name') }}
    </x-mail::button>

    <br>
    {{ config('app.name') }}
</x-mailing-template-layout>
