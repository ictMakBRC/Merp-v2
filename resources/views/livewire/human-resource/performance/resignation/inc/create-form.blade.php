<div x-cloak x-show="create_new">
    <form wire:submit.prevent='storeData'>
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Create Employee resignation Letter</h5>
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
                    <div class="mb-3 col-md-3">
                        <label for="reason" class="form-label">Reason</label>
                        <select class="form-select select2" data-toggle="select2" wire:model.defer='reason'
                            id="reason" name="reason" required>
                            <option selected value="">Select</option>
                            <option value="Voluntary">Voluntary</option>
                            <option value="Involuntary">Involuntary</option>
                            <option value="Retireme">Retirement</option>
                        </select>
                        @error('reason')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="employee" class="form-label">Colleague to Hand Over To</label>
                        <select class="form-select" id="handover_to" data-toggle="select2" wire:model="handover_to"
                            name="handover_to" required>
                            <option selected value="">Select</option>
                            @foreach ($employees->where('id','!=',$employee_id) as $employee)
                                <option value='{{ $employee->id }}'>{{ $employee->fullName }}</option>
                            @endforeach
                        </select>
                        @error('handover_to')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-2">
                        <label for="contact" class="form-label">Contact</label>
                        <input wire:model.defer='contact' name="file_upload" type="number" id="contact"
                            class="form-control" required >
                        @error('contact')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input wire:model.defer='email' name="email" type="email" id="email"
                            class="form-control" required >
                        @error('email')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                       <!-- Other Employee Information Fields -->

        <!-- Resignation Details -->
        <div class="col-md-4">
        <label class="form-label" for="last_working_day">Last Working Day: <small>Min 30days</small></label>
        <input class="form-control" wire:model.defer='last_working_day' type="date" min="{{ date('Y-m-d', strtotime($min_date)) }}" id="last_working_day" name="last_working_day" required>
        </div>
        <div class="col-md-4">
        <label class="form-label" for="notice_period">Notice Period:</label>
        <input class="form-control" wire:model.defer='notice_period' type="number" id="notice_period" name="notice_period">
        </div>
                    <div class="col-md-4">
                        <label for="letter" class="form-label">Attachment</label>
                        <input name="file_upload" type="file" id="file_upload"
                            class="form-control" required accept=".pdf,.doc,.docx,.png, .jpg, .jpeg"     wire:model.lazy="file_upload">
                            <div class="text-success text-small" wire:loading wire:target="file_upload">
                                Uploading file...</div>
                        @error('file_upload')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="letter" class="form-label">Subject</label>
                        <input name="subject" type="text" wire:model.defer='subject' id="subject"
                            class="form-control" required wire:model='subject' accept=".pdf,.doc,.docx">
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
                <label>
                    <input type="checkbox" name="confirmation" wire:model.defer='consent' required>
                    I confirm that the information provided is accurate, and I understand the consequences of resignation.
                </label>

                <div class="text-right">
                    <button type="submit" class="btn btn-success ms-auto float-end">Submit form <i
                            class="fa fa-paperplane ml-2"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
