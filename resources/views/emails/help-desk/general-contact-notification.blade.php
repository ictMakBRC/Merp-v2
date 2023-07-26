<x-mailing-template-layout>
    <p>
        Dear Sir/Madam,<br />
        There is a helpdesk ticket notification that needs PGI team's attention. <br />
        You should liaise with the responsible tickets responders to ensure that it's resolved in time. <br />
        Thank you!
    </p>
{{--    <p>{{ __('helpdesk.dear_sir_madam') }}.</p>--}}

    <a href="{{ url('/') }}" class="btn">
        {{ __('helpdesk.track_ticket') }}.
    </a>

    <p>{{ __('helpdesk.regards') }}</p>
    <p>{{ __('helpdesk.africa_pgi_team') }}</p>

</x-mailing-template-layout>
