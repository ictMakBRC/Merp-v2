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
        <x-slot:action>
            <div class="col-lg-12 col-xl-12">
                <div class="float-end d-print-none mt-2 mt-md-0">
                    <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                    <a href="#" class="btn btn-de-primary btn-sm">Submit</a>
                    <a href="#" class="btn btn-de-danger btn-sm">Cancel</a>
                </div>
            </div>
        </x-slot>
    </x-report-layout>

</div>
