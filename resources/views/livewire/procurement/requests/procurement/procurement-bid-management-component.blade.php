<?php
use App\Enums\ProcurementRequestEnum;
?>
<div class="row" x-data="{ active_tab: @entangle('activeTab') }">
    <div class="col-12">
        <div class="card">
            @include('livewire.procurement.requests.inc.request-card-header')
            <div class="card-body">
                <div>
                    <div class="card-bod p-0">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs d-print-none" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" :class="{ 'active': active_tab === 'summary-information' }"
                                    data-bs-toggle="tab" href="#summary-information" role="tab" aria-selected="true"
                                    @click="active_tab = 'summary-information'">Summary Information</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" :class="{ 'active': active_tab === 'bid-mgt' }"
                                    data-bs-toggle="tab" href="#bid-mgt" role="tab" aria-selected="false"
                                    @click="active_tab = 'bid-mgt'">Bid Management</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" :class="{ 'active': active_tab === 'documents' }"
                                    data-bs-toggle="tab" href="#documents" role="tab" aria-selected="false"
                                    @click="active_tab = 'documents'">Supporting Documents</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane p-3 @if ($activeTab == 'summary-information') active @endif"
                                id="summary-information" role="tabpanel">
                                <x-report-layout>
                                    <h5 class="text-center">{{ $request->subject ?? 'N/A' }}</h5>

                                    @include('livewire.procurement.requests.inc.request-details')

                                    <x-slot:action>
                                        <div class="row d-flex justify-content-center d-print-none">
                                            @if ($request->step_order == 6 && procurementEvaluationApproved($request->id))
                                                <div class="col-lg-12 col-xl-12 mb-2 ms-auto float-start">
                                                    <div class="text-center">
                                                        <textarea type="text" id="comment" class="form-control" wire:model.defer="comment" placeholder="Enter comment"></textarea>
                                                        @error('comment')
                                                            <div class="text-danger text-small">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div><!--end col-->
                                            @endif
                                            <div class="col-lg-12 col-xl-12">
                                                <div class="float-end d-print-none mt-2 mt-md-0 mb-2">
                                                    @if ($request->step_order == 6 && procurementEvaluationApproved($request->id))
                                                        @if ($request->procurement_sector == 'Supplies')
                                                            <button class="btn btn-de-success btn-sm"
                                                                wire:click="updateRequest({{ $request->id }},'{{ ProcurementRequestEnum::PROCESSED }}')"
                                                                onclick="return confirm('Are you sure you want to proceed?');">
                                                                Forward to
                                                                {{ getProcurementRequestStep($request->step_order + 1) }}
                                                            </button>
                                                        @else
                                                            <button class="btn btn-de-success btn-sm"
                                                                wire:click="updateRequest({{ $request->id }},'{{ ProcurementRequestEnum::PROCESSED }}')"
                                                                onclick="return confirm('Are you sure you want to proceed?');">
                                                                Forward to Contracts Manager
                                                            </button>
                                                        @endif
                                                    @endif
                                                    <a href="javascript:window.print()"
                                                        class="btn btn-de-info btn-sm">Print</a>
                                                    <a href="{{ route('procurement-office-panel') }}"
                                                        class="btn btn-de-primary btn-sm">Back to list</a>

                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->

                                    </x-slot>
                                </x-report-layout>
                            </div>

                            <div class="tab-pane p-3 @if ($activeTab == 'bid-mgt') active @endif" id="bid-mgt"
                                role="tabpanel">
                                <livewire:procurement.requests.procurement.inc.request-bidding-component
                                    :request_id="$request->id" />
                            </div>

                            <div class="tab-pane p-3 @if ($activeTab == 'documents') active @endif" id="documents"
                                role="tabpanel">
                                @include('livewire.procurement.requests.procurement.inc.procurement-request-documents')
                            </div>

                        </div>
                    </div>
                </div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
