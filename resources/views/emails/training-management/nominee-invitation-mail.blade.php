<x-mailing-template-layout>
    <p>Dear <strong>{{ $details->name }}</strong>,</p>
    <p>We are pleased to invite you to attend the workshop (<strong>{{ $details->training }}</strong>), which will be
        held at <strong>{{ $details->location }}</strong> facilitated by {{ $details->facilitator }} from
        <strong>@formatDate($details->start_date)</strong> to
        <strong>@formatDate($details->end_date)</strong>.
    </p>
    <p>The <strong>Africa Centres for Disease Control and Prevention</strong> (Africa CDC) is a technical agency of the
        African Union that supports the public health initiatives of the African Union Member States. It supports the
        Member States in strengthening the capacity and capability of Africa’s public health institutions to
        timely detect and effectively respond to disease threats and outbreaks, based on data-driven
        interventions and programme.</p>
    <p>On behalf of the Africa CDC, it is my privilege to invite you to attend and participate in this training
        workshop.</p>
    <p>Your confirmation should be made before <strong>@formatDate($details->confirmation_deadline)</strong>. Please note that
        a note verbale will be shared shortly with your Ministry of Health.</p>
    <p>We look forward to hearing from you. If you require any further information <strong><a href="{{ url('/') }}">Login from here</a>
    </strong> to the Africa PGI-NIMS System in order to complete your registration and confirm your participation.</p>
    <div>
        <h6 style="color: red">Once logged in,</h6>
        <ol>
            <li>Click Training Management and then nominee centre.</li>
            <li>Click the personal information tab and the click edit personal information at the bottom.</li>
            <li>Update the required information and save (ignore if the information is upto date)</li>
            <li>Click the Training Events tab and on the workshops list displayed, click to view details of the event with upcoming status</li>
            <li>On the event details interface, select the Confirmation & travel tab and complete the relevant information required 
                and confirm.</li>
          </ol>
    </div>
    <p>Please feel free to contact {{ $details->training_coordinator }} ({{ $details->coordinator_email }}).</p>

    <p>Regards,</p>
    <p>{{ $details->training_coordinator }}</p>
</x-mailing-template-layout>
