<div x-cloak x-show="create_new">
    <form wire:submit.prevent='storeData'>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Create Employee resignation comment</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" data-action="reload"></a>
                        <a class="list-icons-item" data-action="remove"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="mb-3 col-md-4">
                        <label for="employee" class="form-label">Employee</label>
                        <select class="form-select" id="employee_id" data-toggle="select2" wire:model="employee_id"
                            name="employee_id" required>
                            <option selected value="">Select</option>
                            @foreach ($employees as $employee)
                                <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                            @endforeach
                        </select>
                        @error('employee_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                       <!-- Other Employee Information Fields -->

        <!-- Resignation Details -->
        <div class="col-md-2">
        <label class="form-label" for="from_date">From Date</label>
        <input class="form-control" wire:model.lazy='app_from_date' type="date"  id="from_date" name="from_date" required>
        @error('app_from_date')
            <div class="text-danger text-small">{{ $message }}</div>
        @enderror
        </div>
        <div class="col-md-2">
            <label class="form-label" for="from_date">To Date</label>
            <input class="form-control" wire:model.lazy='app_to_date' type="date"  id="app_to_date" name="app_to_date" required>
            @error('app_to_date')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
        </div>
                    <div class="col-md-4">
                        <label for="comment" class="form-label">Attachment</label>
                        <input name="file_upload" type="file" id="file_upload"
                            class="form-control" required accept=".pdf,.doc,.docx,.png, .jpg, .jpeg"     wire:model.lazy="file_upload">
                            <div class="text-success text-small" wire:loading wire:target="file_upload">
                                Uploading file...</div>
                        @error('file_upload')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                   
                <div class="mb-3">
                    <textarea class="form-control" name="comment" id="comment" wire:model.defer='comment' rows="4" cols="4"></textarea>
                </div>
                @error('comment')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                <label>
                    <input type="checkbox" name="confirmation" wire:model.defer='consent' required>
                        I confirm that the information provided is accurate, and I final.
                    </label>
                <div class="text-right">
                    <button type="submit" class="btn btn-success ms-auto float-end">Submit form <i
                            class="fa fa-paperplane ml-2"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
