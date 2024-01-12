<div x-cloak x-show="create_new">
    <form wire:submit.prevent='storeData'>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Create Employee Termination Letter</h5>
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
                            <option value='Gross Misconduct'>Gross Misconduct</option>
                            <option value='Contract Expiry'>Contract Expiry</option>
                            <option value='Redundancy'>Redundancy</option>
                            <option value='Resignation'>Resignation</option>
                            <option value='Retirement'>Retirement</option>
                            <option value='Medical Grounds'>Medical Grounds</option>
                            <option value='Death'>Death</option>
                            <option value='Poor Performance during probation period'>Poor Performance during
                                probation period</option>
                            <option value='Failure to perform after confirmation'>Failure to perform after
                                confirmation</option>
                            <option value='Organisation/Company Restructuring'>Organisation/Company
                                Restructuring</option>
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
</div>