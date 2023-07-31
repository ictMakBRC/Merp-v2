<div>
    <form wire:submit.prevent="storeEmployee">

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
                <input type="text" id="height" class="form-control" wire:model.defer='height'
                    placeholder="In cm">
                @error('height')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="weight" class="form-label">Weight</label>
                <input type="text" id="weight" class="form-control" nwire:model.defer='weight'
                    placeholder="In Kg">
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
                <input type="text" id="address" class="form-control text-uppercase" wire:model.defer='address'
                    onkeyup="this.value = this.value.toUpperCase();">
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
                        <option value='{{ $department->id }}'>{{ $department->name . ' (' . $department->type . ')' }}
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
                <label for="nssf_number" class="form-label">Social Security No</label>
                <input type="text" id="nssf_number" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='nssf_number'>
                @error('nssf_number')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="cv" class="form-label">CV/Resume</label>
                <input type="file" id="cv" class="form-control" wire:model.lazy='cv' accept=".pdf">
                <div class="text-success text-small" wire:loading wire:target="cv">Uploading cv/resume
                </div>
                @error('cv')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="photo" class="form-label">Photo (Passport Size)</label>
                <input type="file" id="photo" class="form-control" wire:model.lazy='photo'
                    accept=".jpg,.jpeg,.png">
                    <div class="text-success text-small" wire:loading wire:target="photo">Uploading photo
                    </div>
                @error('photo')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="signature" class="form-label">Signature</label>
                <input type="file" id="signature" class="form-control" wire:model.lazy='signature'
                    accept=".jpg,.jpeg,.png">
                    <div class="text-success text-small" wire:loading wire:target="signature">Uploading signature
                    </div>
                @error('signature')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
        <hr>
    </form>
</div>
