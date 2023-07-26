<x-mailing-template-layout>

    <p>
        Thank you for contacting Africa PGI NIMS Helpdesk.
        <br/>
        This is an automated response confirming the receipt of your ticket or a notice for a response to your previously submitted ticket.
        <br/>
        When tracking your ticket, please use the ticket number on the system to find the responses and provide feedback.
    </p>

    <p>
        <strong>{{ __('helpdesk.ticket_no') }}: </strong> {!! $ticket->reference_number !!}<br>
        <strong>{{ __('helpdesk.subject') }}: </strong>{!! $ticket->subject !!}<br>

        <strong>{{ __('helpdesk.status') }}: </strong> {{ __('helpdesk.awaiting_staff_response') }}
    </p>
    <hr>
    <p>
        <strong>{{ __('helpdesk.ticket_summary') }}:</strong> {!! $ticket->description !!}
    </p>

    <a href="{{ route('track-ticket') }}" class="btn">
        {{ __('helpdesk.track_ticket') }}
    </a>

    <p>{{ __('helpdesk.regards') }},</p>
    <p>{{ __('helpdesk.africa_pgi_team') }}</p>

</x-mailing-template-layout>
