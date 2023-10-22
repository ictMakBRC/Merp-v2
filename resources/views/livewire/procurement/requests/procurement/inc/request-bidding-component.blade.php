<div>
    <div class="card">
        <div class="card-header pt-0 d-print-none">
            <div class="row mb-2">
                <div class="col-sm-12 mt-3">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">
                            {{ __('Procurement Method Approval') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveProcurementMethodDecision">
                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="decision" class="form-label required">{{ __('Contracts Committee Decision') }}</label>
                        <select class="form-select" id="decision" wire:model.lazy="decision">
                            <option selected value="">Select</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        @error('decision')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
        
                    @if ($decision == 'Approved')
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
        
                    @endif
        
                    <div class="mb-3 col-md-4">
                        <label for="report" class="form-label required">{{ __('Committee Report') }}</label>
                        <input type="file" id="report" class="form-control" wire:model.defer="report">
                        <div class="text-success text-small" wire:loading wire:target="document">Uploading document...</div>
                        @error('report')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="document_category" class="form-label required">{{ __('Document Category') }}</label>
                        <select class="form-select" id="document_category" wire:model.lazy="document_category">
                            <option selected value="">Select</option>
                            @forelse ($document_categories as $document_category)
                                <option value="{{ $document_category->name }}">{{ $document_category->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_category')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-12">
                        <label for="comment" class="form-label">{{ __('Comment') }}</label>
                        <textarea id="comment" class="form-control" wire:model.defer="comment"></textarea>
                        @error('comment')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
        
                </div>

                @include('livewire.procurement.requests.procurement.inc.request-providers')
                @if (count($providerIds))
                <div class="modal-footer">
                    <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                </div>
                @endif
            </form>

           
        </div>
    </div>

    <div class="card">
        <div class="card-header pt-0 d-print-none">
            <div class="row mb-2">
                <div class="col-sm-12 mt-3">
                    <div class="d-sm-flex align-items-center">
                        <h5 class="mb-2 mb-sm-0">
                            {{ __('Evaluation Report Approval') }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="saveEvaluationDecision">
                {{-- <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="decision" class="form-label required">{{ __('Contracts Committee Decision') }}</label>
                        <select class="form-select" id="decision" wire:model.lazy="decision">
                            <option selected value="">Select</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        @error('decision')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
        
                    @if ($decision == 'Approved')
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
                        <label for="evaluation_report" class="form-label required">{{ __('Evaluation Report') }}</label>
                        <input type="file" id="evaluation_report" class="form-control" wire:model.defer="evaluation_report">
                        <div class="text-success text-small" wire:loading wire:target="document">Uploading document...</div>
                        @error('evaluation_report')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="document_category" class="form-label required">{{ __('Document Category') }}</label>
                        <select class="form-select" id="document_category" wire:model.lazy="document_category">
                            <option selected value="">Select</option>
                            @forelse ($document_categories as $document_category)
                                <option value="{{ $document_category->name }}">{{ $document_category->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_category')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
        
                </div> --}}
        
                <div class="modal-footer">
                    <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                </div>
            </form>
        </div>
    </div>

</div>

