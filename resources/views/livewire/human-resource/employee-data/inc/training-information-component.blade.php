<form>
    <div class="row">
        <div class="mb-3 col-md-3">
            <label for="date3" class="form-label required">From</label>
            <input type="date" id="date3" class="form-control" wire:model.defer="start_date"required>
        </div>

        <div class="mb-3 col-md-3">
            <label for="date4" class="form-label required">To</label>
            <input type="date" id="date4" class="form-control" wire:model.defer="end_date" required>
        </div>

        <div class="mb-3 col-md-6">
            <label for="organised_by" class="form-label required">Training Organised By</label>
            <input type="text" id="organised_by" class="form-control" wire:model.defer="organised_by" required>
        </div>
        
        <div class="mb-3 col-md-6">
            <label for="training_name" class="form-label required">Title/Training Name</label>
            <input type="text" id="training_name" class="form-control" wire:model.defer="training_title"
                placeholder="Title of Seminar/Conference/ Workshop/Short Courses">
        </div>

        <div class="mb-3 col-md-6">
            <label for="training_description" class="form-label">Description Of Training</label>
            <textarea type="text" id="training_description" class="form-control" rows="2" wire:model.defer="training_description"></textarea>
        </div>

        <div class="mb-3 col-md-6">
            <label for="certificate" class="form-label">End of Tranining Document</label>
            <input type="file" id="certificate" class="form-control" wire:model="certificate" accept=".pdf">
        </div>
    </div>
    <div class="modal-footer">
        <x-button class="btn-success">{{__('public.save')}}</x-button>
    </div>
</form>
