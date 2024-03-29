<div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body invoice-head">
                    <div class="row">
                        <div class="col-md-12 d-print-flex">
                            @include('livewire.partials.brc-header')
                            {{-- <h4 class="text-center">Status {{ $invoice_data->status }}</h4> --}}
                        </div>
                    </div><!--end row-->
                </div><!--end card-body-->
                <div class="card-body">
                    @include('livewire.finance.invoice.inc.invoice-header')
                    @php
                        $link = URL::signedRoute('finance-invoice_view', $invoice_data->invoice_no);
                    @endphp
                    {{-- {!! QrCode::size(100)->margin(1)->generate($link) !!} --}}

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive project-invoice">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Item Breakdown</th>
                                            <th>Rate({{ $invoice_data->currency->code ?? 'UG' }})</th>
                                            <th>Qty</th>
                                            <th>Subtotal({{ $currency }})</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>
                                                    <h5 class="mt-0 mb-1 font-14">
                                                        {{ $item->uintService->service->name ?? 'N/A' }}
                                                    </h5>
                                                    <p class="mb-0 text-muted">
                                                        {{ $item->uintService->service->description ?? '' }}
                                                    </p>
                                                </td>
                                                <td>@moneyFormat($item->unit_price??0)</td>
                                                <td>{{ $item->quantity ?? 'N/A' }}</td>
                                                <td>@moneyFormat($item->line_total?? 0)</td>
                                            </tr><!--end tr-->
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b>Sub Total</b></td>
                                            <td class="border-0 font-14 text-dark">
                                                <b></b>{{ $currency }}@moneyFormat($invoice_data->total_amount)
                                            </td>
                                        </tr><!--end tr-->
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b>Discount Total</b></td>
                                            <td class="border-0 font-14 text-dark">
                                                <b></b>{{ $currency }}@moneyFormat($invoice_data->discount_total)
                                            </td>
                                        </tr><!--end tr-->
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b>Adjustment Total</b></td>
                                            <td class="border-0 font-14 text-dark">
                                                <b></b>{{ $currency }}@moneyFormat($invoice_data->adjustment)
                                            </td>
                                        </tr><!--end tr-->
                                        <tr>
                                            <th colspan="2" class="border-0"></th>
                                            <td class="border-0 font-14 text-dark"><b>Tax Rate
                                                    ({{ $currency }})</b></td>
                                            <td class="border-0 font-14 text-dark"><b>0.00%</b></td>
                                        </tr><!--end tr-->
                                        <tr class="bg-black text-white">
                                            <th colspan="2" class="border-0"></th>
                                            <td class="border-0 font-14"><b>Total ({{ $currency }})</b></td>
                                            <td class="border-0 font-14"><b>@moneyFormat($invoice_data->total_amount)</b></td>
                                        </tr><!--end tr-->
                                    </tbody>
                                </table><!--end table-->
                            </div> <!--end /div-->
                        </div> <!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mt-4">Terms And Condition :</h5>
                            <ul class="ps-3">
                                <li><small class="font-12">All accounts are to be paid within 30 days from receipt of
                                        invoice. </small></li>
                                <li><small class="font-12">To be paid by cheque or credit card or direct payment
                                        online.</small></li>
                                <li>
                                    <h5 class="mt-4">Bank Detail :</h5>
                                    {{-- <strong class="font-14">Bank Details :</strong><br> --}}
                                    <b> Bank Name:</b>{{ $invoice_data?->bank?->name ?? 'N/A' }},
                                    <b>Branch:</b>{{ $invoice_data?->bank?->branch ?? 'N/A' }},
                                    <b>Account No.</b>{{ $invoice_data?->bank?->account_no ?? 'N/A' }}
                                </li>
                            </ul>
                        </div> <!--end col-->
                        <div class="col-lg-6 align-self-center">
                            <div class="float-none float-md-end" style="width: 30%;">
                                <small>Account Manager</small>
                                <img src="assets/images/signature.png" alt="" class="mt-2 mb-1" height="20">
                                <p class="border-top">Signature</p>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    <hr>
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 col-xl-4 ms-auto align-self-center">
                            <div class="text-center"><small class="font-12">Thank you very much for doing business with
                                    us.</small></div>
                        </div><!--end col-->
                        <div class="col-lg-12 col-xl-4">
                            <div class="float-end d-print-none mt-2 mt-md-0">
                                <button class="btn btn-de-primary btn-sm" wire:click="downloadAttachment({{ $invoice_data->id }})">Download Attachment</button>
                                <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                                {{-- @if ($invoice_data->status == 'Submitted') --}}
                                @if ($invoice_data->status == 'Submitted' && $invoice_data->requestable->supervisor == auth()->user()->employee?->id && Auth::user()->hasPermission(['approve_unit_invoice']))
                                    <a href="javascript:voide(0)" wire:click="reviewInvoice({{ $invoice_data->id }})"
                                        class="btn btn-de-primary btn-sm">Mark Reviewed</a>
                                @endif
                                @if ($invoice_data->status == 'Reviewed' && Auth::user()->hasPermission(['approve_all_invoices']))
                                    <a href="javascript:voide(0)" wire:click="approveInvoice({{ $invoice_data->id }})"
                                        class="btn btn-de-primary btn-sm">Approve Invoice</a>
                                @endif
                                @if ($invoice_data->status == 'Approved' && $invoice_data?->billtable->supervisor == auth()->user()->employee?->id && Auth::user()->hasPermission(['update_all_invoices']))
                                    <a href="javascript:voide(0)"
                                        wire:click="acknowledgeInvoice({{ $invoice_data->id }})"
                                        class="btn btn-de-primary btn-sm">Acknowledge Invoice</a>
                                @endif
                                @if ($invoice_data->invoice_type == 'External' &&  $invoice_data->status == 'Approved' && Auth::user()->hasPermission(['update_all_invoices']))
                                        <a href="javascript:voide(0)" wire:click="acknowledgeInvoice({{ $invoice_data->id }})"
                                        class="btn btn-de-primary btn-sm">Acknowledge Invoice</a>
                                @endif
                                <a href="{{ route('finance-invoices') }}" class="btn btn-de-danger btn-sm">Cancel</a>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
        <div class="col-12">
            @if ($invoice_data->status == 'Acknowledged' || $invoice_data->status == 'Partially Paid')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            @if (Auth::user()->hasPermission(['update_all_invoices']))

                                <div class="card-header">
                                    <h4>Invoice Payments
                                        @if ($invoice_data->invoice_type == 'External')
                                            @if ($invoice_data->status == 'Acknowledged' || $invoice_data->status == 'Partially Paid')
                                                <a type="button" data-bs-toggle="modal"
                                                    data-bs-target="#NewPaymentModal"
                                                    class="btn btn-sm me-2 btn-primary float-end">
                                                    <i class="fa fa-plus"></i>Payment
                                                </a>
                                            @endif
                                        @elseif($invoice_data->invoice_type == 'Internal')
                                            @if ($invoice_data->status == 'Acknowledged' || $invoice_data->status == 'Partially Paid')
                                                <a type="button" data-bs-toggle="modal"
                                                    data-bs-target="#internalTransferModal"
                                                    class="btn btn-sm me-2 btn-primary float-end">
                                                    <i class="fa fa-plus"></i>Internal Transfer
                                                </a>
                                            @endif
                                            @elseif($invoice_data->invoice_type == 'Opening Balance')
                                            @if ($invoice_data->status == 'Acknowledged' || $invoice_data->status == 'Partially Paid')
                                                <a type="button" data-bs-toggle="modal"
                                                    data-bs-target="#NewOpenBalanceModal"
                                                    class="btn btn-sm me-2 btn-primary float-end">
                                                    <i class="fa fa-plus"></i>Payment
                                                </a>
                                            @endif
                                        @endif
                                    </h4>
                                </div>

                            @endif
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No.</th>
                                                <th>Ref No.</th>
                                                <th>Collected By</th>
                                                <th>Amount Paid</th>
                                                {{-- <th>Total Balance</th> --}}
                                                <th>Date</th>
                                                <th>Description</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoice_data->payments as $key => $payement)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $payement->payment_reference }}</td>
                                                    <td>{{ $payement->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $payement->payment_amount }}</td>
                                                    {{-- <td>{{ $payement->payment_balance- }}</td> --}}
                                                    <td>{{ $payement->as_of }}</td>
                                                    <td>{{ $payement->description }}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->
                            </div>
                        </div>
                    </div>
                    @include('livewire.finance.invoice.inc.new-invoice-payment')
                    @include('livewire.finance.invoice.inc.new-internal-payment')
                    @include('livewire.finance.invoice.inc.new-open-balance-payment')
                </div>
            @endif
        </div>
    </div><!--end row-->
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#NewPaymentModal').modal('hide');
                $('#internalTransferModal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
