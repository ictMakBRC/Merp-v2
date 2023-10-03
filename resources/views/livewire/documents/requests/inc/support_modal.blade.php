
<div wire:ignore.self class="modal fade" id="addNewSuportDoc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New support document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div> <!-- end modal header -->
            <div class="modal-body">
                <form wire:submit.prevent='addSupportDocument'>
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <label for="title" class="form-label">Document Title</label>
                            <input type="text" id="support_document_title" class="form-control"
                                wire:model.defer="support_document_title">
                            @error('support_document_title')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 mb-1">
                            <label for="file" class="form-label">Upload File</label>
                            <input type="file" id="support_file{{$iteration}}" class="form-control"
                                wire:model.lazy="support_file">                                
                                <div class="text-success text-small" wire:loading
                                wire:target="support_file">Uploading document...</div> 
                            @error('support_file')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                            <div class="text-success text-small" wire:loading
                            wire:target="file">Uploading file...</div>
                        </div> 
                        <div class="col-md-12 mt-3">
                            <button wire:click="$set('active_document_id',{{$document->id}})" type="submit" class="btn text-white btn-info btn-sm float-end">Add</button>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
