<div>
    <form >
       
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="entry_type" class="form-label required">Entry Type</label>
                <select class="form-select select2" id="entry_type" wire:model.lazy='entry_type'>
                    <option value="Official">Official</option>
                    <option value="Project">Project</option>
                    <option value='Volunteer'>Volunteer</option>
                    <option value='Intern'>Intern</option>
                    <option value='Trainee'>Trainee</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="nin_number" class="form-label">NIN Number</label>
                <input type="text" id="nin_number" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='nin_number' size="14">
            </div>

            <div class="mb-3 col-md-4">
                <label for="prefix" class="form-label required">Prefix</label>
                <select class="form-select select2" id="prefix" wire:model.defer='prefix'>
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Miss.">Miss.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Eng.">Eng.</option>
                    <option value="Prof.">Prof.</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="surname" class="form-label required">Surname</label>
                <input type="text" id="surname" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='surname'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="first_name" class="form-label required">First Name</label>
                <input type="text" id="first_name" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='first_name'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="other_name" class="form-label">Other Name</label>
                <input type="text" id="other_name" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='other_name'>
            </div>
    
            <div class="mb-3 col-md-4">
                <label for="gender" class="form-label required">Gender</label>
                <select class="form-select select2" id="gender" wire:model.lazy='gender'>
                    <option selected value="">Select</option>
                    <option value='Male'>Male</option>
                    <option value='Female'>Female</option>
                    <option value='Other'>Other</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="nationality" class="form-label required">Nationality</label>
                <select class="form-select select2" id="nationality" wire:model.lazy='nationality'>
                    <option selected value="">Select</option>
                    @include('layouts.nationalities')
                </select>
            </div>
    
            <div class="mb-3 col-md-4">
                <label for="birthday" class="form-label required">Date of Birth</label>
                <input type="date" id="birthday" class="form-control" wire:model.defer='birthday'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="birth_place" class="form-label">Place of Birth</label>
                <input type="text" id="birth_place" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='birth_place'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="religious_affiliation" class="form-label">Religious Affiliation</label>
                <input type="text" id="religious_affiliation" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='religious_affiliation'>
            </div>
            <div class="mb-3 col-md-2">
                <label for="height" class="form-label">Height</label>
                <input type="text" id="height" class="form-control" wire:model.defer='height' placeholder="In cm">
            </div>
            <div class="mb-3 col-md-2">
                <label for="weight" class="form-label">Weight</label>
                <input type="text" id="weight" class="form-control" nwire:model.defer='weight' placeholder="In Kg">
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
            </div>
            <div class="mb-3 col-md-4">
                <label for="civil_status" class="form-label">Civil/Marital Status</label>
                <select class="form-select select2" id="civil_status" wire:model.defer='civil_status'>
                    <option selected value="">Select</option>
                    <option value='Single'>Single</option>
                    <option value='Married'>Married</option>
                    <option value='Widowed'>Widowed</option>
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="address" class="form-label">Address</label>
                <input type="text" id="address" class="form-control text-uppercase" wire:model.defer='address'
                    onkeyup="this.value = this.value.toUpperCase();" >
            </div>

            <div class="mb-3 col-md-4">
                <label for="email" class="form-label required">Email Address</label>
                <input type="email" id="email" class="form-control" wire:model.defer='email'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="alt_email" class="form-label">Alternative Email</label>
                <input type="email" id="alt_email" class="form-control" wire:model.defer='alt_email'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="contact" class="form-label required">Telephone Number</label>
                <input type="text" id="contact" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='contact'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="alt_contact" class="form-label">Alternative Contact</label>
                <input type="text" id="alt_contact" class="form-control text-uppercase" wire:model.defer='alt_contact'>
            </div>
    
            <div class="mb-3 col-md-4">
                <label for="designation_id" class="form-label required">Designation / Position</label>
                <select class="form-select select2" id="designation_id" wire:model.lazy='designation_id'>
                    <option selected value="">Select</option>
                    {{-- @foreach ($designations as $designation)
                        <option value='{{ $designation->id }}'>{{ $designation->name }}</option>
                    @endforeach --}}
                </select>
            </div>
    
            <div class="mb-3 col-md-4">
                <label for="station_id" class="form-label required">Official Duty Station</label>
                <select class="form-select select2" id="station_id" wire:model.lazy='station_id'>
                    <option selected value="">Select</option>
                    {{-- @foreach ($stations as $station)
                        <option value='{{ $station->id }}'>{{ $station->station_name }}</option>
                    @endforeach --}}
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="department_id" class="form-label required">Department</label>
                <select class="form-select select2" id="department_id" wire:model.lazy='department_id'>
                    <option selected value="">Select</option>
                    {{-- @foreach ($departments as $department)
                        <option value='{{ $department->id }}'>{{ $department->department_name }}</option>
                    @endforeach --}}
    
                </select>
            </div>
 
            <div class="mb-3 col-md-4">
                <label for="reporting_to" class="form-label">Reporting to</label>
                <select class="form-select select2" id="reporting_to" wire:model.defer='reporting_to'>
                    <option selected value="">Select</option>
                    {{-- @foreach ($employees as $employee)
                        <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                    @endforeach --}}
                </select>
            </div>
            
            <div class="mb-3 col-md-4">
                <label for="work_type" class="form-label required">Work Type</label>
                <select class="form-select select2" id="work_type" wire:model.defer='work_type'>
                    <option selected value="">Select</option>
                    @include('layouts.employment-types')
                </select>
            </div>

            <div class="mb-3 col-md-4">
                <label for="join_date" class="form-label required">Join Date</label>
                <input type="date" id="join_date" class="form-control" wire:model.defer='join_date'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="tin_number" class="form-label">TIN Number</label>
                <input type="number" id="tin_number" class="form-control" wire:model.defer='tin_number'>
            </div>

            <div class="mb-3 col-md-4">
                <label for="nssf_number" class="form-label">Social Security No</label>
                <input type="text" id="nssf_number" class="form-control text-uppercase"
                    onkeyup="this.value = this.value.toUpperCase();" wire:model.defer='nssf_number' >
            </div>

            <div class="mb-3 col-md-4">
                <label for="cv" class="form-label">CV/Resume</label>
                <input type="file" id="cv" class="form-control" wire:model.lazy='cv' accept=".pdf">
            </div>

            <div class="mb-3 col-md-4">
                <label for="photo" class="form-label">Photo (Passport Size)</label>
                <input type="file" id="photo" class="form-control" wire:model.lazy='photo' accept=".jpg,.jpeg,.png">
            </div>

            <div class="mb-3 col-md-4">
                <label for="signature" class="form-label">Signature</label>
                <input type="file" id="signature" class="form-control" wire:model.defer='signature' accept=".jpg,.jpeg,.png">
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{__('public.save')}}</x-button>
        </div>
        <hr>
    </form>
</div>
