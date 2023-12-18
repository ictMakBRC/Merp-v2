<div class="row mb-0" x-show="filter_data">
    <h6>{{ __('Filter Employees') }}</h6>
    <div class="row mx-auto">
        <div class="mb-3 col-md-2">
            <label for="entry_type" class="form-label">Entry Type</label>
            <select class="form-select" id="entry_type" wire:model.lazy='entry_type'>
                <option selected value="0">All</option>
                <option value="Official">Official</option>
                <option value="Project">Project</option>
                <option value='Volunteer'>Volunteer</option>
                <option value='Intern'>Intern</option>
                <option value='Trainee'>Trainee</option>
            </select>
            <div class="text-info" wire:loading wire:target='entry_type'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-3 ">
            <label for="department_id" class="form-label">Department</label>
            <select class="form-select" wire:model='department_id'>
                <option value="0" selected>All</option>
                @forelse ($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}
                    </option>
                @empty
                @endforelse
            </select>
            <div class="text-info" wire:loading wire:target='department_id'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-3 ">
            <label for="project_id" class="form-label">Project/Study</label>
            <select class="form-select" wire:model='project_id'>
                <option value="0" selected>All</option>
                @forelse ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->project_code }}
                    </option>
                @empty
                @endforelse
            </select>
            <div class="text-info" wire:loading wire:target='project_id'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" wire:model='gender'>
                <option value="0" selected>All</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            <div class="text-info" wire:loading wire:target='gender'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="work_type" class="form-label">Work Type</label>
            <select class="form-select" wire:model='work_type'>
                <option selected value="0">All</option>
                @include('layouts.employment-types')
            </select>
            <div class="text-info" wire:loading wire:target='work_type'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="duty_station" class="form-label">Duty Station</label>
            <select class="form-select" wire:model='station_id'>
                <option selected value="0">All</option>
                @foreach ($stations as $station)
                    <option value='{{ $station->id }}'>{{ $station->name }}</option>
                @endforeach
            </select>
            <div class="text-info" wire:loading wire:target='station_id'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-3">
            <label for="position" class="form-label">Designation / Position</label>
            <select class="form-select" wire:model='designation_id'>
                <option selected value="0">All</option>
                @foreach ($designations as $designation)
                    <option value='{{ $designation->id }}'>{{ $designation->name }}</option>
                @endforeach
            </select>
            <div class="text-info" wire:loading wire:target='designation_id'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="join_date1" class="form-label">From Join Date</label>
            <input type="date" class="form-control" wire:model.lazy='from_join_date'>
            <div class="text-info" wire:loading wire:target='from_join_date'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="join_date2" class="form-label">To Join Date</label>
            <input type="date" id="join_date2" class="form-control" wire:model.lazy='to_join_date'>
            <div class="text-info" wire:loading wire:target='to_join_date'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-3">
            <label for="nationality" class="form-label">Nationality</label>
            <select class="form-select" id="nationality" wire:model.lazy='nationality'>
                <option value="0" selected>All</option>
                @include('layouts.nationalities')
            </select>
            <div class="text-info" wire:loading wire:target='nationality'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="religious_affiliation" class="form-label">Religion</label>
            <input type="text" id="religious_affiliation" wire:model.lazy="religious_affiliation"
                class="form-control">
            <div class="text-info" wire:loading wire:target='religious_affiliation'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="civil_status" class="form-label">Civil Status</label>
            <select class="form-select" id="civil_status" wire:model.lazy="civil_status">
                <option value="0" selected>All</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Windowed">Windowed</option>
            </select>
            <div class="text-info" wire:loading wire:target='civil_status'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="birthday1" class="form-label">From DoB</label>
            <input type="date" id="birthday1" class="form-control" wire:model.lazy="from_dob">
            <div class="text-info" wire:loading wire:target='from_dob'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="birthday2" class="form-label">To DoB</label>
            <input type="date" id="birthday2" class="form-control" wire:model.lazy="to_dob">
            <div class="text-info" wire:loading wire:target='to_dob'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="birth_place" class="form-label">Place of Birth</label>
            <input type="text" id="birth_place" class="form-control text-uppercase" wire:model.lazy="birth_place"
                onkeyup="this.value = this.value.toUpperCase();">
            <div class="text-info" wire:loading wire:target='birth_place'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-2">
            <label for="blood_type" class="form-label">Blood Type</label>
            <select class="form-select" id="blood_type" wire:model.lazy="blood_type">
                <option value="0">All</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
            </select>
            <div class="text-info" wire:loading wire:target='blood_type'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-1">
            <label for="title" class="form-label">Title</label>
            <select class="form-select" id="title" wire:model.lazy="title">
                <option value="0">All</option>
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Miss.">Miss.</option>
                <option value="Dr.">Dr.</option>
                <option value="Eng.">Eng.</option>
                <option value="Prof.">Prof.</option>
            </select>
            <div class="text-info" wire:loading wire:target='title'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>

        <div class="mb-3 col-md-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" id="address" class="form-control text-uppercase" wire:model.lazy="address"
                onkeyup="this.value = this.value.toUpperCase();">
            <div class="text-info" wire:loading wire:target='address'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>


        <div class="mb-3 col-md-2">
            <label for="status1" class="form-label">Status</label>
            <select class="form-select" id="status1" wire:model='is_active'>
                <option value="" selected>All</option>
                <option value='0'>Suspended</option>
                <option value='1'>Active</option>
            </select>
            <div class="text-info" wire:loading wire:target='is_active'>
                <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                    <span class='sr-only'></span>
                </div>
            </div>
        </div>
        <hr>
    </div>

    

</div>
