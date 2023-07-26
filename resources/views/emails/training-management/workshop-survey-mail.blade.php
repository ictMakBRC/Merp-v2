<x-mailing-template-layout>
    <p>Dear <strong>{{ $details->name }}</strong>,</p>
    <p>On behalf of the Africa CDC, it is my privilege to invite you to participate in the <strong>
        <a href="{{ $details->survey_link }}" target="_blank">{{ $details->survey_type }} survey</a></strong> pertaining to the
        <strong>{{ $details->training }}</strong> workshop/training to which you are/were a nominee/participant, conducted/due from
        <strong>@formatDate($details->start_date)</strong> to
        <strong>@formatDate($details->end_date)</strong> in <strong>{{ $details->location }}</strong> facilitated by 
        <strong>{{ $details->facilitator }}</strong>.
    </p>

    <p>The <strong>Africa Centres for Disease Control and Prevention</strong> (Africa CDC) is technical agency of the
        African Union that supports the public health initiatives of the African Union Member States. It supports the
        Member States in strengthening the capacity and capability of Africa’s public health institutions to
        timely detect and effectively respond to disease threats and outbreaks, based on data-driven
        interventions and programme.</p>

    <p>Your participation in the survey will help us improve our workforce development programmes.
        You can access the survey using this link <strong><a href="{{ $details->survey_link }}" target="_blank">
        take the survey.</a></strong></p>

    <p>If you require any further information <strong><a href="{{ url('/') }}">Login from here</a></strong> to the
        Africa PGI-NIMS System in order see the workshop/training event details. Please feel free to
        contact {{ $details->training_coordinator }} ({{ $details->coordinator_email }}).</p>

    <p>Regards,</p>
    <p>{{ $details->training_coordinator }}</p>
</x-mailing-template-layout>
