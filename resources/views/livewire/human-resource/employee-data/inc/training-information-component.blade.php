<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeTrainingHistory"
    @else
    wire:submit.prevent="updateTrainingHistory" @endif>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="date3" class="form-label required">From</label>
                <input type="date" id="date3" class="form-control" wire:model.defer="start_date" required>
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
                <label for="date4" class="form-label required">To</label>
                <input type="date" id="date4" class="form-control" wire:model.defer="end_date" required>
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="organised_by" class="form-label required">Training Organised By</label>
                <input type="text" id="organised_by" class="form-control" wire:model.defer="organised_by" required>
                @error('organised_by')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="training_title" class="form-label required">Title/Training Name</label>
                <input type="text" id="training_title" class="form-control" wire:model.defer="training_title"
                    placeholder="Title of Seminar/Conference/ Workshop/Short Courses">
                @error('training_title')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="training_description" class="form-label">Description Of Training</label>
                <textarea type="text" id="training_description" class="form-control" rows="2" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-6">
                <label for="certificate" class="form-label">End of Tranining Document</label>
                <input type="file" id="certificate" class="form-control" wire:model="certificate" accept=".pdf">
                <div class="text-success text-small" wire:loading wire:target="certificate">Uploading certificate
                </div>
                @error('certificate')
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

     <!--TRAINING PROGRAMS-->
 @if (!$trainingInformation->isEmpty())
 <div class="row">
     <div class="col-lg-12">
         <hr>
         <div class="table-responsive">
             <table
                 class="table w-100 mb-0 table-striped text-center">
                 <thead>
                     <tr>
                         <th>Training</th>
                         <th>Organisation</th>
                         <th>From</th>
                         <th>To</th>
                         <th>Description</th>
                         <th>Certificate</th>
                         <th>Action</th>
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
                         <td class="table-action text-center">
                             @if ($training->certificate != null)
                                 <a href="#"
                                     class="btn-outline-success no-print"><i
                                         class="ti ti-download"></i></a>
                             @else
                                 N/A
                             @endif
                         </td>
                         <td>
                            <button class="btn btn btn-sm btn-outline-success"
                                wire:click="editData({{ $training->id }})"
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
<!-- end TRAINING PROGRAMS-->
</div>
