<!-- CKEditor default -->
<div class="card">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Full featured CKEditor</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item" data-action="reload"></a>
                <a class="list-icons-item" data-action="remove"></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <p class="mb-3">CKEditor is a ready-for-use HTML text editor designed to simplify web content creation. It's a WYSIWYG editor that brings common word processor features directly to your web pages. It benefits from an active community that is constantly evolving the application with free add-ons and a transparent development process.</p>
        <form action="#">
            
            <div class="row">

                <div class="mb-3 col-md-4">
                    <label class="mb-3">Employee</label>
                    <div class="selectr-container selectr-desktop has-selected"
                        style="width: 100%;">
                        <div class="" style="width: 100%;">
                            <select class="form-select" wire:model="employee_id">
                                <option value="" disabled>Select ...</option>
                                @foreach ($employees as $employee)
                                <option value="{{$employee->id}}" selected="">
                                    {{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('employee_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 col-md-5">
                    <label for="file" class="form-label">Support File</label>
                    <input type="file" id="file" class="form-control"
                        wire:model.defer="file_uploads" multiple>
                    @error('file_uploads')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" id="subject" class="form-control" wire:model.defer="subject">
                    @error('subject')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-12">
                    <label for="letter" class="form-label required">Letter</label>
                    <textarea  wire:model.defer="letter" name="editor-full" id="editor-full" rows="4" cols="4"></textarea>                  

                    @error('letter')
                    <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn bg-teal-400">Submit form <i class="icon-paperplane ml-2"></i></button>
            </div>
        </form>
    </div>
</div>
<!-- /CKEditor default -->