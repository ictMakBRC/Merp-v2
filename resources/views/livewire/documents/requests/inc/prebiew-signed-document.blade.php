
        <div class="modal fade" wire:ignore.self id="approve_document" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="exampleModalCenterTitle">Preview Document</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        @if ($documentPath)
                            {{-- <iframe src="{{ route('document.preview', ['id' => $documentPath]) }}" style="width: 100%; height: 600px; border: none;"></iframe> --}}
                            <embed src="{{ route('document.preview', ['id' => $documentPath]) }}" width="100%" height="500">
                        @else
                            no file found
                            @error('document')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        @endif
                    </div><!--end modal-body-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-de-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" wire:click='approveSignedDoc' class="btn btn-de-primary btn-sm">Approve</button>
                    </div><!--end modal-footer-->
                </div><!--end modal-content-->
            </div><!--end modal-dialog-->
        </div><!--end modal-->