<div>
    <x-report-layout>
        <h5 class="text-center">Employee Personal Datasheet</h5>

        <div class="bg-light">
            <table class="table">
                <tr>
                    <td>
                        <div>
                            <strong class="text-inverse">{{ __('public.name') }}:
                            </strong>{{ $employee->fullName ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Employee No') }}:
                            </strong>{{ $employee->employee_number ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('NIN') }}:
                            </strong>{{ $employee->nin_number ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Gender') }}:
                            </strong>{{ $employee->gender ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Nationality') }}:
                            </strong>{{ $employee->nationality ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('DoB') }}: </strong>
                            @formatDate($employee->birth_date ?? now()) <strong>Age:</strong> {{ $employee->employeeAge }} yrs<br>
                            <strong class="text-inverse">{{ __('Place of Birth') }}:
                            </strong>{{ $employee->birth_place ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Religious Affiliation') }}:
                            </strong>{{ $employee->religious_affiliation ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Height') }}:
                            </strong>{{ $employee->height ?? 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong class="text-inverse">{{ __('Weight') }}:
                            </strong>{{ $employee->weight ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Blood Type') }}:
                            </strong>{{ $employee->blood_type ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('CIvil Status') }}:
                            </strong>{{ $employee->civil_status ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Address') }}:
                            </strong>{{ $employee->address ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Email') }}:
                            </strong>{{ $employee->email ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Alternative Email') }}: </strong>
                            {{ $employee->alt_email }}<br>
                            <strong class="text-inverse">{{ __('Contact') }}:
                            </strong>{{ $employee->contact ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Alternative Contact') }}:
                            </strong>{{ $employee->alt_contact ?? 'N/A' }}<br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <strong class="text-inverse">{{ __('Position') }}:
                            </strong>{{ $employee->designation?->name ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Duty Station') }}:
                            </strong>{{ $employee->station?->name ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Department') }}:
                            </strong>{{ $employee->department?->name ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Supervisor') }}:
                            </strong>{{ $employee->supervisor?->fullName ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Work Type') }}:
                            </strong>{{ $employee->work_type ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('Join Date') }}:
                            </strong>@formatDate($employee->join_date ?? now())<br>
                            <strong class="text-inverse">{{ __('TIN') }}:
                            </strong>{{ $employee->tin_number ?? 'N/A' }}<br>
                            <strong class="text-inverse">{{ __('NSSF No') }}:
                            </strong>{{ $employee->nssf_number ?? 'N/A' }}<br>

                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!--OFFICIAL CONTRACTS-->
        @if (!$officialContracts->isEmpty())
            <div class="row mt-0">
                <div class="col-lg-12">
                    <hr>
                    <div class="card-header">
                        <h4 class="header-title">Official Contract Information</h4>
                    </div>
                    <div class="table-responsiv">
                        <table class="table w-100 mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th>Contract Summary</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>G-Pay</th>
                                    <th>Contract</th>
                                </tr>
                            </thead>
                            @foreach ($officialContracts as $officialContract)
                                <tr>
                                    <td>
                                        {{ $officialContract->contract_summary }}
                                    </td>
                                    <td>
                                        @formatDate($officialContract->start_date)
                                    </td>
                                    <td>
                                        @formatDate($officialContract->end_date)
                                    </td>
                                    <td>
                                        {{ $officialContract->currency->code }} @moneyFormat($officialContract->gross_salary)

                                    </td>
                                    <td class="table-action ">
                                        <a href="#" class="btn-outline-success no-print"><i
                                                class="ti ti-download"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end OFFICIAL CONTRACTS-->

         <!--PROJECT CONTRACTS-->
         @if (!$employee->projects->isEmpty())
         <div class="row">
             <div class="col-lg-12">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Project/Study Contract Information</h4>
                </div>
                 <div class="table-responsiv">
                     <table
                         class="table  w-100 mb-0 table-striped text-center">
                         <thead>
                             <tr>
                                 <th>Project</th>
                                 <th>Contract Summary</th>
                                 <th>Designation</th>
                                 <th>From</th>
                                 <th>To</th>
                                 <th>FTE</th>
                                 <th>G-Pay(UGX)</th>
                                 <th>Contract</th>
                             </tr>
                         </thead>
                         @foreach ($employee->projects as $project)
                             <tr>
                                 <td>
                                     {{ $project->project_code }}

                                 </td>
                                 <td>
                                     {{ $project->pivot->contract_summary }}
                                 </td>
                                 <td>
                                     {{ $project->pivot->designation->name }}

                                 </td>
                                 <td>
                                     @formatDate($project->pivot->start_date)
                                 </td>
                                 <td>
                                     @formatDate($project->pivot->end_date)
                                 </td>
                                 <td>
                                     {{ $project->pivot->fte ? $project->pivot->fte : 'N/A' }}
                                 </td>
                                 <td>
                                    {{ $project->currency->code }} @moneyFormat($project->pivot->gross_salary)

                                 </td>
                                 <td class="table-action">

                                    @if ($project->pivot->contract_file != null)
                                        <a href="#"
                                            class="btn-outline-success"><i
                                                class="ti ti-download"></i></a>
                                    @else
                                        N/A
                                    @endif
                                 </td>
                             </tr>
                         @endforeach
                     </table>
                 </div> <!-- end preview-->
             </div>
         </div>
     @else
         <div></div>
     @endif
     <!-- end PROJECT CONTRACTS-->

        <!--BANKING INFORMATION-->
        @if (!$bankingInformation->isEmpty())
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <div class="card-header">
                        <h4 class="header-title">Banking Information</h4>
                    </div>
                    <div class="table-responsiv">
                        <table class="table table-striped w-100 mb-0  ">
                            <thead>
                                <tr>
                                    <th>Bank Name</th>
                                    <th>Branch</th>
                                    <th>Account Name</th>
                                    <th>Currency</th>
                                    <th>Acct Number</th>
                                    <th>State</th>
                                </tr>
                            </thead>
                            @foreach ($bankingInformation as $bankingInfo)
                                <tr>
                                    <td>
                                        {{ $bankingInfo->bank_name }}

                                    </td>
                                    <td>
                                        {{ $bankingInfo->branch ?? 'N/A' }}

                                    </td>
                                    <td>
                                        {{ $bankingInfo->account_name }}
                                    </td>
                                    <td>
                                        {{ $bankingInfo->currency->code }}
                                    </td>
                                    <td>
                                        {{ $bankingInfo->account_number }}
                                    </td>
                                    @if ($bankingInfo->is_default)
                                        <td><span class="badge bg-success">Primary</span></td>
                                    @else
                                        <td><span class="badge bg-info">Secondary</span></td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end BANKING INFORMATION-->

        <!--FAMILY BACKGROUND INFORMATION-->
        @if (!$familyInformation->isEmpty())
            <div class="row">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Family Background Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsiv">
                        <table class="table table-striped w-100 mb-0">
                            <thead>
                                <tr>

                                    <th>Member</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Contact</th>
                                    <th>Occupation</th>
                                    <th>Employer</th>
                                    <th>Employer-Address</th>
                                    <th>Employer-Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            @foreach ($familyInformation as $familybackground)
                                <tr>
                                    <td>
                                        {{ $familybackground->member_type }}

                                    </td>
                                    <td>
                                        {{ $familybackground->fullName }}
                                    </td>
                                    <td>
                                        {{ $familybackground->address ?? 'N/A' }}

                                    </td>
                                    <td>
                                        {{ $familybackground->contact ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $familybackground->occupation ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $familybackground->employer ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $familybackground->employer_address ?? 'N/A' }}
                                    </td>
                                    <td>
                                        {{ $familybackground->employer_contact ?? 'N/A' }}
                                    </td>
                                    @if ($familybackground->member_status == 'Alive')
                                        <td><span class="badge bg-success">Alive</span></td>
                                    @else
                                        <td><span class="badge bg-danger">Deceased</span></td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end FAMILY BACKGROUND-->

        <!--EMERGENCY CONTACT INFORMATION-->
        @if (!$emergencyInformation->isEmpty())
            <div class="row">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Emergency Contact Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsiv">
                        <table class="table table-striped w-100 ">
                            <thead>
                                <tr>

                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Address</th>
                                    <th>Contract</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            @foreach ($emergencyInformation as $emergencycontact)
                                <tr>
                                    <td>
                                        {{ $emergencycontact->contact_name }}

                                    </td>
                                    <td>
                                        {{ $emergencycontact->contact_relationship }}
                                    </td>
                                    <td>
                                        {{ $emergencycontact->contact_address }}

                                    </td>
                                    <td>
                                        {{ $emergencycontact->contact_phone }}
                                    </td>
                                    <td>
                                        {{ $emergencycontact->contact_email }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
            <!-- end EMERGENCY CONTACT INFORMATION-->
        @endif

        <!--EXPERIENCE BACKGROUND-->
        @if (!$workExperienceInformation->isEmpty())
            <div class="row">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Working Experience Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsiv">
                        <table class="table w-100 mb-0 table-striped ">
                            <thead>
                                <tr>
                                    <th>Organisation</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Position</th>
                                    <th>Emp-Type</th>
                                    <th>Responsibility</th>
                                </tr>
                            </thead>
                            @foreach ($workExperienceInformation as $experience)
                                <tr>
                                    <td>
                                        {{ $experience->company }}
                                    </td>
                                    <td>
                                        @formatDate($experience->start_date)
                                    </td>
                                    <td>
                                        @formatDate($experience->end_date)
                                    </td>
                                    <td>
                                        {{ $experience->position_held }}

                                    </td>

                                    <td>
                                        {{ $experience->employment_type }}
                                    </td>
                                    <td>
                                        {{ $experience->key_responsibilities }}
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end WORK EXPERIENCE-->

        <!--TRAINING PROGRAMS-->
        @if (!$trainingInformation->isEmpty())
            <div class="row">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Trainings Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsiv">
                        <table class="table w-100 mb-0 table-striped ">
                            <thead>
                                <tr>
                                    <th>Training</th>
                                    <th>Organisation</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Description</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            @foreach ($trainingInformation as $training)
                                <tr>
                                    <td>
                                        {{ $training->training_title }}

                                    </td>
                                    <td>
                                        {{ $training->organised_by }}
                                    </td>
                                    <td>
                                        @formatDate($training->start_date)
                                    </td>
                                    <td>
                                        @formatDate($training->end_date)
                                    </td>

                                    <td>
                                        {{ $training->description }}
                                    </td>
                                    <td class="table-action ">
                                        @if ($training->certificate != null)
                                            <a href="#" class="btn-outline-success no-print"><i
                                                    class="ti ti-download"></i></a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end TRAINING PROGRAMS-->

        <!--EDUCATION BACKGROUND-->
        @if (!$educationInformation->isEmpty())
            <div class="row">
                <hr>
                <div class="card-header">
                    <h4 class="header-title">Education Background Information</h4>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsiv">
                        <table class="table w-100 mb-0 table-striped ">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Institution</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Award</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            @foreach ($educationInformation as $award)
                                <tr>
                                    <td>
                                        {{ $award->level }}
                                    </td>
                                    <td>
                                        {{ $award->school }}

                                    </td>
                                    <td>
                                        @formatDate($award->start_date)
                                    </td>
                                    <td>
                                        @formatDate($award->end_date)
                                    </td>
                                    <td>
                                        {{ $award->award }}
                                    </td>
                                    <td class="table-action ">
                                        @if ($award->award_document != null)
                                            <a href="#" class="btn-outline-success"><i
                                                    class="ti ti-download"></i></a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div> <!-- end preview-->
                </div>
            </div>
        @endif
        <!-- end EDUCATION BACKGROUND-->

        

        <x-slot:action>
            <div class="col-lg-12 col-xl-12">
                <div class="float-end d-print-none mt-2 mt-md-0">
                    <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                </div>
            </div>
        </x-slot>
    </x-report-layout>

</div>
