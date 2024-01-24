<div>
    @if ($loadEmployeeDetails)
        <x-report-layout>
            <h5 class="text-center">Employee Personal Datasheet</h5>

            <div class="bg-light">
                <table class="table">
                    <tr>
                        <td>
                            <div>
                                <strong class="text-inverse">{{ __('public.name') }}:
                                </strong>{{ $employeeInfo->fullName ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Employee No') }}:
                                </strong>{{ $employeeInfo->employee_number ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('NIN') }}:
                                </strong>{{ $employeeInfo->nin_number ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Gender') }}:
                                </strong>{{ $employeeInfo->gender ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Nationality') }}:
                                </strong>{{ $employeeInfo->nationality ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('DoB') }}: </strong>
                                @formatDate($employeeInfo->birth_date ?? now()) <strong>Age:</strong> {{ $employeeInfo->employeeAge }} yrs<br>
                                <strong class="text-inverse">{{ __('Place of Birth') }}:
                                </strong>{{ $employeeInfo->birth_place ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Religious Affiliation') }}:
                                </strong>{{ $employeeInfo->religious_affiliation ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Height') }}:
                                </strong>{{ $employeeInfo->height ?? 'N/A' }}
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong class="text-inverse">{{ __('Weight') }}:
                                </strong>{{ $employeeInfo->weight ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Blood Type') }}:
                                </strong>{{ $employeeInfo->blood_type ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('CIvil Status') }}:
                                </strong>{{ $employeeInfo->civil_status ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Address') }}:
                                </strong>{{ $employeeInfo->address ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Email') }}:
                                </strong>{{ $employeeInfo->email ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Alternative Email') }}: </strong>
                                {{ $employeeInfo->alt_email }}<br>
                                <strong class="text-inverse">{{ __('Contact') }}:
                                </strong>{{ $employeeInfo->contact ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Alternative Contact') }}:
                                </strong>{{ $employeeInfo->alt_contact ?? 'N/A' }}<br>
                            </div>
                        </td>
                        <td>
                            <div>
                                <strong class="text-inverse">{{ __('Position') }}:
                                </strong>{{ $employeeInfo->designation?->name ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Duty Station') }}:
                                </strong>{{ $employeeInfo->station?->name ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Department') }}:
                                </strong>{{ $employeeInfo->department?->name ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Supervisor') }}:
                                </strong>{{ $employeeInfo->supervisor?->fullName ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Work Type') }}:
                                </strong>{{ $employeeInfo->work_type ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('Join Date') }}:
                                </strong>@formatDate($employeeInfo->join_date ?? now())<br>
                                <strong class="text-inverse">{{ __('TIN') }}:
                                </strong>{{ $employeeInfo->tin_number ?? 'N/A' }}<br>
                                <strong class="text-inverse">{{ __('NSSF No') }}:
                                </strong>{{ $employeeInfo->nssf_number ?? 'N/A' }}<br>

                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <x-slot:action>
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0">
                        <button class="btn btn-outline-primary btn-sm" wire:click='editData({{$employeeInfo->id}})'>Edit</button>
                        {{-- <a href="#" class="btn btn-de-danger btn-sm">Clear</a> --}}
                    </div>
                </div>
            </x-slot>
        </x-report-layout>
    @else
    <form
    @if (!$toggleForm) wire:submit.prevent="storeEmployee"
@else
wire:submit.prevent="updateEmployee" @endif>
    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="entry_type" class="form-label required">Entry Type</label>
            <select class="form-select select2" id="entry_type" wire:model.lazy='entry_type'>
                <option selected value="">Select</option>
                <option value="Official">Official</option>
                <option value="Project">Project</option>
                <option value='Volunteer'>Volunteer</option>
                <option value='Intern'>Intern</option>
                <option value='Trainee'>Trainee</option>
            </select>
            @error('entry_type')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="nin_number" class="form-label">NIN Number</label>
            <input type="text" id="nin_number" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='nin_number' size="14">
            @error('nin_number')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="title" class="form-label required">Title</label>
            <select class="form-select select2" id="title" wire:model.defer='title'>
                <option selected value="">Select</option>
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Miss.">Miss.</option>
                <option value="Dr.">Dr.</option>
                <option value="Eng.">Eng.</option>
                <option value="Prof.">Prof.</option>
            </select>
            @error('title')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="surname" class="form-label required">Surname</label>
            <input type="text" id="surname" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='surname'>
            @error('surname')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="first_name" class="form-label required">First Name</label>
            <input type="text" id="first_name" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='first_name'>
            @error('first_name')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="other_name" class="form-label">Other Name</label>
            <input type="text" id="other_name" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='other_name'>
            @error('other_name')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="gender" class="form-label required">Gender</label>
            <select class="form-select select2" id="gender" wire:model.lazy='gender'>
                <option selected value="">Select</option>
                <option value='Male'>Male</option>
                <option value='Female'>Female</option>
                <option value='Other'>Other</option>
            </select>
            @error('gender')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="nationality" class="form-label required">Nationality</label>
            <select class="form-select select2" id="nationality" wire:model.lazy='nationality'>
                <option selected value="">Select</option>
                @include('layouts.nationalities')
            </select>
            @error('nationality')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="birthday" class="form-label required">Date of Birth</label>
            <input type="date" id="birthday" class="form-control" wire:model.defer='birth_date'>
            @error('birth_date')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="birth_place" class="form-label">Place of Birth</label>
            <input type="text" id="birth_place" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='birth_place'>
            @error('birth_place')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="religious_affiliation" class="form-label">Religious Affiliation</label>
            <input type="text" id="religious_affiliation" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='religious_affiliation'>
            @error('religious_affiliation')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-2">
            <label for="height" class="form-label">Height</label>
            <input type="number" id="height" class="form-control" wire:model.defer='height'
                placeholder="In cm" step="0.01">
            @error('height')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-2">
            <label for="weight" class="form-label">Weight</label>
            <input type="number" id="weight" class="form-control" wire:model.defer='weight'
                placeholder="In Kg" step="0.01">
            @error('weight')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="blood_type" class="form-label">Blood Type</label>
            <select class="form-select select2" id="blood_type" wire:model.defer='blood_type'>
                <option value="">Select</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            @error('blood_type')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="civil_status" class="form-label">Civil/Marital Status</label>
            <select class="form-select select2" id="civil_status" wire:model.defer='civil_status'>
                <option selected value="">Select</option>
                <option value='Single'>Single</option>
                <option value='Married'>Married</option>
                <option value='Widowed'>Widowed</option>
            </select>
            @error('civil_status')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" class="form-control text-uppercase"
                wire:model.defer='address' onkeyup="this.value = this.value.toUpperCase();">
            @error('address')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="email" class="form-label required">Email Address</label>
            <input type="email" id="email" class="form-control" wire:model.defer='email'>
            @error('email')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="alt_email" class="form-label">Alternative Email</label>
            <input type="email" id="alt_email" class="form-control" wire:model.defer='alt_email'>
            @error('alt_email')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="contact" class="form-label required">Telephone Number</label>
            <input type="text" id="contact" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='contact'>
            @error('contact')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="alt_contact" class="form-label">Alternative Contact</label>
            <input type="text" id="alt_contact" class="form-control text-uppercase"
                wire:model.defer='alt_contact'>
            @error('alt_contact')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="designation_id" class="form-label required">Designation / Position</label>
            <select class="form-select select2" id="designation_id" wire:model.lazy='designation_id'>
                <option selected value="">Select</option>
                @foreach ($designations as $designation)
                    <option value='{{ $designation->id }}'>{{ $designation->name }}</option>
                @endforeach
            </select>
            @error('designation_id')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="station_id" class="form-label required">Official Duty Station</label>
            <select class="form-select select2" id="station_id" wire:model.lazy='station_id'>
                <option selected value="">Select</option>
                @foreach ($stations as $station)
                    <option value='{{ $station->id }}'>{{ $station->name }}</option>
                @endforeach
            </select>
            @error('station_id')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="department_id" class="form-label required">Department</label>
            <select class="form-select select2" id="department_id" wire:model.lazy='department_id'>
                <option selected value="">Select</option>
                @foreach ($departments as $department)
                    <option value='{{ $department->id }}'>
                        {{ $department->name . ' (' . $department->type . ')' }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="reporting_to" class="form-label">Reporting to</label>
            <select class="form-select select2" id="reporting_to" wire:model.defer='reporting_to'>
                <option selected value="">Select</option>
                @foreach ($supervisors as $employee)
                    <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                @endforeach
            </select>
            @error('reporting_to')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="work_type" class="form-label required">Work Type</label>
            <select class="form-select select2" id="work_type" wire:model.defer='work_type'>
                <option selected value="">Select</option>
                @include('layouts.employment-types')
            </select>
            @error('work_type')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="join_date" class="form-label required">Join Date</label>
            <input type="date" id="join_date" class="form-control" wire:model.defer='join_date'>
            @error('join_date')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="tin_number" class="form-label">TIN Number</label>
            <input type="number" id="tin_number" class="form-control" wire:model.defer='tin_number'>
            @error('tin_number')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="nssf_number" class="form-label">Social Security Number</label>
            <input type="text" id="nssf_number" class="form-control text-uppercase"
                onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='nssf_number'>
            @error('nssf_number')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="cv{{ $employee_id }}" class="form-label">CV/Resume</label>
            <input type="file" id="cv{{ $employee_id }}" class="form-control" wire:model.lazy='cv'
                accept=".pdf">
            <div class="text-success text-small" wire:loading wire:target="cv">Uploading cv/resume
            </div>
            @error('cv')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="photo{{ $employee_id }}" class="form-label">Photo (Passport Size)</label>
            <input type="file" id="photo{{ $employee_id }}" class="form-control"
                wire:model.lazy='photo' accept=".jpg,.jpeg,.png">
            <div class="text-success text-small" wire:loading wire:target="photo">Uploading photo
            </div>
            @error('photo')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="signature{{ $employee_id }}" class="form-label">Signature</label>
            <input type="file" id="signature{{ $employee_id }}" class="form-control"
                wire:model.lazy='signature' accept=".jpg,.jpeg,.png">
            <div class="text-success text-small" wire:loading wire:target="signature">Uploading signature
            </div>
            @error('signature')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="modal-footer">
        <x-button class="btn btn-success">
            @if (!$toggleForm)
                {{ __('public.save') }}
            @else
                {{ __('public.update') }}
            @endif
        </x-button>
    </div>
    <hr>
</form>
    @endif

</div>
