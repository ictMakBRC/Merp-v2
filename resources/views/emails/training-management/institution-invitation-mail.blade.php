<x-mailing-template-layout>
    <p>Dear {{$details->contact_person_name}},</p>
    <p>The <strong>Africa Centers for Disease Control and Prevention</strong> (Africa CDC), is organizing a
        specialized training workshop on <strong>{{ $details->training }}</strong>.</p>
    <p>On behalf of the Africa CDC, it is my privilege to invite you to nominate
        <strong>{{ $details->slots }}</strong>
        trainee(s) from your institution to attend this training workshop.
    </p>
    <p>The workshop will be facilitated by <strong>{{ $details->facilitator }}</strong> and held at
        <strong>({{ $details->location }})</strong> from <strong>@formatDate($details->start_date)</strong> to
        <strong>@formatDate($details->end_date)</strong>.
    </p>
    
    <p>After nomination, the nominee will be sent login details to his/her email to login to the Africa PGI-NIMS
        System in order to complete the registration and confirm his/her participation.</p>
    <p>This information should be furnished before <strong>@formatDate($details->nomination_deadline)</strong>. Please
        note that a note verbale will
        be shared shortly with your Ministry of Health. Please work closely with this ministry to ensure the
        right candidate(s) is appointed.</p>
    <p>We look forward to hearing from you. If you require any further information <strong><a href="{{ url('/') }}">Login from here</a>
    </strong> to PGI-NIMS System using your login credentials to see more information about the workshop and do the nomination too,</p>
    <strong>Note:</strong><h6 style="color: red">Only do the nomination after thorough guidance from the respective ministry of health of your country</h6>
    <div>
        <h6 style="color: red">Once logged in,</h6>
        <ol>
            <li>Click Training Management and then institution centre.</li>
            <li>Click the Training Events tab and on the workshops list that is displayed, 
                click to view details of the event with upcoming status.</li>
            <li>On the event details interface, click nominate in the upper right corner, 
                enter details of the nominees and submit, or select from already existing nominees list on the left and submit.</li>
            <li>Done!</li>
            </ol>
    </div>
    <p>Please feel free to contact {{ $details->training_coordinator }} ({{ $details->coordinator_email }}).</p>

    <p>Regards,</p>
    <p>{{ $details->training_coordinator }}</p>
</x-mailing-template-layout>
