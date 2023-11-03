<?php
use App\Enums\ProcurementRequestEnum;
?>
<div>
    @if (!checkProcurementMethodApproval($request->id) || checkProcurementMethodApproval($request->id))

        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Procurement Method Approval') }}</h4>
                </div><!--end col-->
                <div class="col-auto">
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-dots-horizontal text-muted"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Notify CC for Approval</a>
                            <a class="dropdown-item" href="#">Notify Requester & EC</a>
                        </div>
                    </div>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

        @if (!checkProcurementMethodApproval($request->id))
            <form wire:submit.prevent="saveProcurementMethodDecision">
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label for="decision"
                            class="form-label required">{{ __('Contracts Committee Decision') }}</label>
                        <select class="form-select" id="decision" wire:model.lazy="decision">
                            <option selected value="">Select</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        @error('decision')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="decision_date" class="form-label required">{{ __('Decision Date') }}</label>
                        <input type="date" id="decision_date" class="form-control" wire:model.defer="decision_date"
                            max="{{ now()->toDateString() }}">
                        @error('decision_date')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
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

                    <div class="mb-3 col-md-3">
                        <label for="bid_return_deadline"
                            class="form-label @if ($decision == 'Approved') required @endif">{{ __('Bid Return Deadline') }}</label>
                        <input type="date" id="bid_return_deadline" class="form-control"
                            wire:model.defer="bid_return_deadline" min="{{ now()->toDateString() }}"
                            @if ($decision != 'Approved') readonly @endif>
                        @error('bid_return_deadline')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="report" class="form-label required">{{ __('Committee Report') }}</label>
                        <input type="file" id="report" class="form-control" wire:model.defer="report">
                        <div class="text-success text-small" wire:loading wire:target="report">Uploading
                            document...
                        </div>
                        @error('report')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="document_category" class="form-label required">{{ __('Report Category') }}</label>
                        <select class="form-select" id="document_category" wire:model.lazy="document_category">
                            <option selected value="">Select</option>
                            @forelse ($document_categories as $document_category)
                                <option value="{{ $document_category->name }}">{{ $document_category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_category')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="comment" class="form-label required">{{ __('Comment') }}</label>
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
        @endif

        @if (checkProcurementMethodApproval($request->id))
            @include('livewire.procurement.requests.procurement.inc.procurement-method-approval')
        @endif
    @endif

    @if (procurementMethodApproved($request->id) && today() >= $request->bid_return_deadline)
        <hr>

        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Evaluation Report Approval') }}</h4>
                </div><!--end col-->
                <div class="col-auto">
                    <div class="dropdown">
                        <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <!-- <i class="las la-menu align-self-center text-muted icon-xs"></i>  -->
                            <i class="mdi mdi-dots-horizontal text-muted"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="#">Notify CC for Approval</a>
                            <a class="dropdown-item" href="#">Notify Best Bidder</a>
                        </div>
                    </div>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

        @if (!checkProcurementEvaluationApproval($request->id))
            <form wire:submit.prevent="saveEvaluationDecision">
                <div class="row mt-2">
                    <div class="mb-3 col-md-3">
                        <label for="decision"
                            class="form-label required">{{ __('Contracts Committee Decision') }}</label>
                        <select class="form-select" id="decision" wire:model.lazy="decision">
                            <option selected value="">Select</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        @error('decision')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-2">
                        <label for="decision_date" class="form-label required">{{ __('Decision Date') }}</label>
                        <input type="date" id="decision_date" class="form-control"
                            wire:model.defer="decision_date" max="{{ now()->toDateString() }}">
                        @error('decision_date')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="best_bidder_id" class="form-label required">{{ __('Best bidder') }}</label>
                        <select class="form-select" id="best_bidder_id" wire:model.lazy="best_bidder_id">
                            <option selected value="">Select</option>
                            @forelse ($request->providers as $provider)
                                <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                            @empty
                            @endforelse
                        </select>
                        @error('best_bidder_id')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3 col-md-3">
                        <label for="negotiated_with_bidder"
                            class="form-label required">{{ __('Negotiated With Bidder?') }}</label>
                        <select class="form-select" id="negotiated_with_bidder"
                            wire:model.lazy="negotiated_with_bidder">
                            <option selected value="">Select</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        @error('negotiated_with_bidder')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- <div class="mb-3 col-md-3">
                        <label for="bidder_contract_price" class="form-label required">{{ __('Bidder Price in') }}
                            {{ getCurrencyCode($request->currency_id) }}</label>
                        <input type="number" id="bidder_contract_price" class="form-control"
                            wire:model.lazy="bidder_contract_price" step="0.01">
                        @error('bidder_contract_price')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    {{-- @if ($negotiated_with_bidder)
                        <div class="mb-3 col-md-3">
                            <label for="bidder_revised_price"
                                class="form-label required">{{ __('Bidder Revised Price in') }}
                                {{ getCurrencyCode($request->currency_id) }}</label>
                            <input type="number" id="bidder_revised_price" class="form-control"
                                wire:model.lazy="bidder_revised_price" step="0.01">
                            @error('bidder_revised_price')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif --}}

                    @if ($decision == 'Approved')
                        <div class="mb-3 col-md-3">
                            <label for="delivery_deadline"
                                class="form-label required">{{ __('Delivery Deadline') }}</label>
                            <input type="date" id="delivery_deadline" class="form-control"
                                wire:model.defer="delivery_deadline" min="{{ now()->toDateString() }}">
                            @error('delivery_deadline')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <div class="mb-3 col-md-3">
                        <label for="report" class="form-label required">{{ __('Evaluation Report') }}</label>
                        <input type="file" id="report" class="form-control" wire:model.defer="report">
                        <div class="text-success text-small" wire:loading wire:target="report">Uploading
                            document...
                        </div>
                        @error('report')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="document_category"
                            class="form-label required">{{ __('Report Category') }}</label>
                        <select class="form-select" id="document_category" wire:model.lazy="document_category">
                            <option selected value="">Select</option>
                            @forelse ($document_categories as $document_category)
                                <option value="{{ $document_category->name }}">{{ $document_category->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @error('document_category')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="comment" class="form-label required">{{ __('Comment') }}</label>
                        <textarea id="comment" class="form-control" wire:model.defer="comment"></textarea>
                        @error('comment')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                </div>
            </form>
        @endif


        @if (checkProcurementEvaluationApproval($request->id))
            @include('livewire.procurement.requests.procurement.inc.evaluation-approval-information')

        @endif

        <livewire:procurement.requests.procurement.inc.bidder-prices-component :request_id="$request->id" />

    @endif
</div>
