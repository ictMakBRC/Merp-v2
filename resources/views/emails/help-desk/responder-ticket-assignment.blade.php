<x-mailing-template-layout>
    <p>Dear Sir/Madam, <br />
        This is an automated notification informing you about a ticket under '{{ $query_type->name }}' for which you're a responder. <br />
        Please login to the NIMS system to provide feedback to the ticket at your earliest time possible.</p>
    <p>

    <p>
        {{ __('helpdesk.subject') }}: {!! $ticket->subject !!}
    </p>

    <p>
        {{ __('helpdesk.query') }}: {!! $ticket->description !!}
    </p>

    <p>
        {{ __('helpdesk.ticket_no') }}: {!! $ticket->reference_number !!}
    </p>

    <a href="{{ url('/') }}" class="btn">
        {{ __('helpdesk.track_ticket') }}.
    </a>

    <p>{{ __('helpdesk.regards') }},</p>
    <p>{{ __('helpdesk.africa_pgi_team') }}</p>

</x-mailing-template-layout>
