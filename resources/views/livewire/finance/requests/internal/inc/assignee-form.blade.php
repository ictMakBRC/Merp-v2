<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog" aria-labelledby="updateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModalTitle">
                    Update
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->     
            
            <form wire:submit.prevent="updateFmsPosition" >             
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                           <h4> {{ $name }}</h4>
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="assigned_to" class="form-label required">Person</label>
                            <select class="form-select select2" id="assigned_to" wire:model="assigned_to">
                                <option selected value="">Select</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->employee->fullName??$user->name }}</option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                    <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
    @push('scripts')
        
    <script>
        window.addEventListener('livewire:load', () => {
            initializeSelect2();
        });

        $('#assigned_to').on('select2:select', function(e) {
            var data = e.params.data;
            @this.set('assigned_to', data.id);
        });


        window.addEventListener('livewire:update', () => {
            $('.select2').select2('destroy'); //destroy the previous instances of select2
            initializeSelect2();
        });

        function initializeSelect2() {

            $('.select2').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ?
                        '100%' : 'style',
                    placeholder: $(this).data('placeholder') ? $(this).data('placeholder') : 'Select',
                    allowClear: Boolean($(this).data('allow-clear')),
                });
            });
        }
    </script>
@endpush
</div><!--end modal-->