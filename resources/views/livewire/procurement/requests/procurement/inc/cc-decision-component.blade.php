<div>
    <form wire:submit.prevent="saveContractsCommitteeDecision">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="cc_decision" class="form-label required">{{ __('Contracts Committee Decision') }}</label>
                <select class="form-select" id="cc_decision" wire:model.lazy="cc_decision">
                    <option selected value="">Select</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
                @error('cc_decision')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            @if ($cc_decision == 'Approved')
                <div class="mb-3 col-md-4">
                    <label for="procurement_method_id"
                        class="form-label required">{{ __('Procurement Method') }}</label>
                    <select class="form-select" id="procurement_method_id" wire:model.lazy="procurement_method_id">
                        <option selected value="">Select</option>
                        @forelse ($procurementMethods as $procMethod)
                            <option value="{{ $procMethod->id }}">{{ $procMethod->method }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('procurement_method_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 col-md-4">
                    <label for="provider_id" class="form-label required">{{ __('Provider') }}</label>
                    <select class="form-select" id="provider_id" wire:model.lazy="provider_id">
                        <option selected value="">Select</option>
                        @forelse ($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('provider_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="mb-3 col-md-4">
                <label for="committee_report" class="form-label required">{{ __('Committee Report') }}</label>
                <input type="file" id="committee_report" class="form-control" wire:model.defer="committee_report">
                <div class="text-success text-small" wire:loading wire:target="document">Uploading document...</div>
                @error('committee_report')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="modal-footer">
            <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
    </form>
</div>
<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
</div>
