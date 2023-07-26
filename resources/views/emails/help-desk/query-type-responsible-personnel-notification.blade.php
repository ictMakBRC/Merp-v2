<x-mailing-template-layout>
    <p>Dear Sir/Madam, <br />
        This is an automated notification informing you that you have been added as a ticket responder
        under '{{ $query_type->name }}' query type.</p>

    <a href="{{ url('/') }}" class="btn">
        {{ __('login to NIMS here') }}.
    </a>

    <p>{{ __('helpdesk.regards') }},</p>
    <p>{{ __('helpdesk.africa_pgi_team') }}</p>

</x-mailing-template-layout>
