<x-mailing-template-layout>

    <p>Dear Sir/Madam, <br />
        You have been assigned a ticket from the Africa PGI Helpdesk system
        which requires your attention. <br />
        Please endeavour to respond at your earliest convenience.</p>

    <a href="{{ url('/') }}" class="btn">
        {{ __('helpdesk.track_ticket') }}.
    </a>

    <p>{{ __('helpdesk.regards') }}</p>
    <p>{{ __('helpdesk.africa_pgi_team') }}</p>

</x-mailing-template-layout>
