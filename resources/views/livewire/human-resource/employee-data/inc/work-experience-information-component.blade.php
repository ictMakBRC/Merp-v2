<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeWorkingExperienceInformation"
    @else
    wire:submit.prevent="updateWorkingExperienceInformation" @endif>
        <div class="row">

            <div class="mb-3 col-md-3">
                <label for="date1" class="form-label required">From</label>
                <input type="date" id="date1" class="form-control" wire:model.defer="start_date" required>
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="date2" class="form-label required">To</label>
                <input type="date" id="date2" class="form-control" wire:model.defer="end_date" required>
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="company" class="form-label required">Company/Organisation/Office</label>
                <input type="text" id="company" class="form-control" wire:model.defer="company" required>
                @error('company')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-5">
                <label for="position_held" class="form-label required">Position Held</label>
                <input type="text" id="position_held" class="form-control" wire:model.defer="position_held" required>
                @error('position_held')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="employment_type" class="form-label required">Employment Type</label>
                <select class="form-select select2" id="employment_type" wire:model.lazy="employment_type" required>
                    <option selected value="">Select</option>
                    @include('layouts.employment-types')
                </select>
                @error('employment_type')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="monthly_salary" class="form-label">Monthly Salary/Wage</label>
                <input type="number" id="monthly_salary" class="form-control" wire:model.defer="monthly_salary">
                @error('monthly_salary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label">Currency</label>
                <select class="form-select select2" id="currency_id" wire:model.defer="currency_id">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-12">
                <label for="key_responsibilities" class="form-label">Key Responsibilities</label>
                <textarea type="text" id="key_responsibilities" rows="4" class="form-control"
                    wire:model.defer="key_responsibilities" placeholder="List Key Responsibilities"></textarea>
                @error('key_responsibilities')
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
    </form>

     <!--EXPERIENCE BACKGROUND-->
 @if (!$workExperienceInformation->isEmpty())
     <div class="row">
         <div class="col-lg-12">
             <hr>
             <div class="table-responsive">
                 <table
                     class="table w-100 mb-0 table-striped text-center">
                     <thead>
                         <tr>
                             <th>Organisation</th>
                             <th>From</th>
                             <th>To</th>
                             <th>Position</th>
                             <th>Emp-Type</th>
                             <th>Responsibility</th>
                             <th>Action</th>
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
                             <td>
                                <button class="btn btn btn-sm btn-outline-success"
                                    wire:click="editData({{ $experience->id }})"
                                    title="{{ __('public.edit') }}">
                                    <i class="ti ti-edit fs-18"></i></button>
                            </td>
                         </tr>
                     @endforeach

                 </table>
             </div> <!-- end preview-->
         </div>
     </div>
 @endif
 <!-- end WORK EXPERIENCE-->

</div>
