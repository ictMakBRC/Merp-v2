<div wire:ignore.self class="modal fade" id="updateCreateModal" tabindex="-1" role="dialog"
    aria-labelledby="updateCreateModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="updateCreateModal">
                        New Inventory Request
                </h6>
                <button type="button" class="btn-close text-danger" wire:click="close()" aria-label="Close"></button>
            </div><!--end modal-header-->

          <form   wire:submit.prevent="storeRequest" >
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">

                            <label for="request_code" class="form-label">Request Code</label>
                            <input type="text" id="code" class="form-control" wire:model.defer="request_code"
                                readonly>
                            @error('request_code')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="approver" class="form-label required" required>Approver</label>
                            <select class="form-select" wire:model="approver_id" required>

                                <option value="">Select...</option>
                                @foreach ($signatories as $key => $value)
                                    <option value="{{ $value->id }}">{{ $value->employee->fullName??$value->name }} {{ $value->first_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('approver_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3 col-md-12">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea wire:model.defer="comment"  class="form-control"></textarea>
                        </div>
                    </div>
                </div>


            </div><!--end modal-body-->
            <!-- </form> -->

            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm"
                    wire:click="close()">{{ __('public.close') }}</button>
                @if ($toggleForm)
                    <x-button type="submit" class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                @else
                    <x-button type="submit" class="btn-success btn-sm">{{ __('Submit') }}</x-button>
                @endif
            </div><!--end modal-footer-->
          </form>
        </div><!--end modal-content-->

    </div><!--end modal-dialog-->
</div><!--end modal-->
