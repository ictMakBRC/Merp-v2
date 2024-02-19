<div x-cloak x-show="create_new">
    <form wire:submit.prevent='storeData'>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Create Employee Warning Letter</h5>
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
                    <div class="mb-3 col-md-4">
                        <label for="reason" class="form-label">Reason</label>
                        <select class="form-select select2" data-toggle="select2" wire:model.defer='reason' id="reason" name="reason"
                            required>
                            <option selected value="">Select</option>
                            <option value='Misconduct'>Misconduct</option>
                            <option value='Corruption'>Corruption</option>
                            <option value='Absecondment'>Absecondment</option>
                            <option value='Sexual Harrasment'>Sexual Harrasment</option>
                        </select>
                        @error('reason')
                        <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="letter" class="form-label">Attachment</label>
                        <input wire:model='file_upload' name="file_upload" type="file" id="file_upload" class="form-control" required
                            accept=".pdf,.doc,.docx">
                            @error('file_upload')
                            <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="letter" class="form-label">Subject</label>
                        <input name="subject" type="text" wire:model.defer='subject' id="subject" class="form-control" required wire:model='subject'
                        accept=".pdf,.doc,.docx">
                    </div>
                    @error('subject')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3" wire:ignore>
                        <textarea class="form-control" name="letter" id="letter" wire:model='letter' rows="4" cols="4"></textarea>
                    </div>
                    @error('letter')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror

                    <div class="text-right">
                        <button type="submit" class="btn btn-success ms-auto float-end">Submit form <i class="fa fa-paperplane ml-2"></i></button>
                    </div>
            </div>
        </div>
    </form>
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            } )
            .then( editor => {
                window.editor = editor;
            } )
            .catch( err => {
                console.error( err.stack );
            } );
    </script>
</div>