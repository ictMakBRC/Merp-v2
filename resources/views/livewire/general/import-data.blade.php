 <div wire:ignore.self class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Choose a file</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form wire:submit.prevent="importData">
                 <div class="modal-body">                    
                     @include('layouts.messages')
                     <input type="file" wire:model.lazy="import_file" class="form-control" required
                         name="import_file" id="import_file_{{$iteration}}">
                     <div class="text-success text-small" wire:loading wire:target="import_file">Uploading file...</div>
                     @error('import_file')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                 </div>
                 <div class="d-flex m-2 align-items-center text-success">
                     <a href="javascript:void()" class="text-success text-small pl-3 mt-1"
                         wire:click="downloadTemplate">
                         <i class='bx bx-file bx-burst bx-rotate-90 align-middle font-18 me-1'></i>{{__('Download Template')}}</a>
                 </div>

                 <div class="modal-footer">
                     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{__('public.close')}}</button>
                     <button type="submit" class="btn btn-success">{{__('public.upload')}}</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
 @push('scripts')
   <script>
       window.addEventListener('close-modal', event => {
           $('#importModal').modal('hide');
       });
      
   </script>
@endpush
