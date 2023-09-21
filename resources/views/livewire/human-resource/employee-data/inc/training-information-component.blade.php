<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form wire:submit.prevent="storeTrainingHistory">
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
            <x-button class="btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
