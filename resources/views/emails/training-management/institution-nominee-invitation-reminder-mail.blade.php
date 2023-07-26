<x-mailing-template-layout>
    <style>
        #nominee-list,
        #nominee-list th,
        #nominee-list td {
            border: 1px solid black;
        }

        #nominee-list {
            border-collapse: collapse;
            width: 100%;
        }

        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }
    </style>
    <p>Dear {{ $details->contact_person_name }},</p>
    <p>On behalf of the Africa CDC, it is my privilege to remind you that the following people that you had nominated
        for the workshop <strong>{{ $details->training }}</strong>
        which will be held at <strong>{{ $details->facilitator }}
            ({{ $details->location }})</strong> from <strong>@formatDate($details->start_date)</strong> to
        <strong>@formatDate($details->end_date)</strong> have not completed their registration nor confirmed their
        attendance/participation yet.
    </p>

    <div class="table-container">
        <table id="nominee-list">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($details->nominees as $key=>$nominee)
                    <tr>
                        <td>{{ $key + 1 }}
                        </td>

                        <td>
                            {{ $nominee['name'] }}
                        </td>
                        <td>
                            {{ $nominee['email'] }}
                        </td>
                        <td>
                            {{ $nominee['contact'] }}
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>

    <p>
        It is on that note therefore, that you should follow up with these nominees to complete there registration and
        confirm their participation, before <strong>@formatDate($details->confirmation_deadline)</strong>, a period within
        which you can also cancel their nomination and nominate new participants for the workshop.
    </p>

    <p>We look forward to hearing from you. If you require any further information <strong><a
                href="{{ url('/') }}">Login from here</a></strong> to the PGI-NIMS System
        using your login credentials for more information about the workshop,
        please feel free to contact {{ $details->training_coordinator }} ({{ $details->coordinator_email }}).</p>
    <p>Regards,</p>
    <p>{{ $details->training_coordinator }}</p>
</x-mailing-template-layout>
