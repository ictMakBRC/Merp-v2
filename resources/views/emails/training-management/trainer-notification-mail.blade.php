<x-mailing-template-layout>
    <p>Dear {{$details->trainer_name}},</p>
    <p>The <strong>Africa Centers for Disease Control and Prevention</strong> (Africa CDC), is organizing a
        specialized training workshop on <strong>{{ $details->training }}</strong></p>
    <p>On behalf of the Africa CDC, it is my privilege to nominate and invite you to attend this training workshop as one of the trainers.
    </p>
    <p>The workshop will be facilitated by <strong>{{ $details->facilitator }}</strong> and held at
        <strong>({{ $details->location }})</strong> from <strong>@formatDate($details->start_date)</strong> to
        <strong>@formatDate($details->end_date)</strong>.
    </p>

    <p>The <strong>Africa Centres for Disease Control and Prevention</strong> (Africa CDC) is technical agency of the
        African Union that supports the public health initiatives of the African Union Member States. It supports the
        Member States in strengthening the capacity and capability of Africa’s public health institutions to
        timely detect and effectively respond to disease threats and outbreaks, based on data-driven
        interventions and programme.</p>

    <p>We look forward to hearing from you. If you require any further information <strong><a href="{{ url('/') }}">Login from here</a>
    </strong> to PGI-NIMS System using your login credentials to see more information about the workshop.</p>
    <div>
        <h6 style="color: red">Once logged in,</h6>
        <ol>
            <li>Click Training Management and then trainer centre.</li>
            <li>Click the Training Events tab and on the workshops list that is displayed, 
                click to view details of the event with upcoming status</li>
            <li>On the event details interface, click materials tab, 
                go ahead and upload any relevant training materials in form of file or links if available.</li>
        </ol>
    </div>
    <p>Please feel free to contact {{ $details->training_coordinator }} ({{ $details->coordinator_email }}).</p>

    <p>Regards,</p>
    <p>{{ $details->training_coordinator }}</p>
</x-mailing-template-layout>
