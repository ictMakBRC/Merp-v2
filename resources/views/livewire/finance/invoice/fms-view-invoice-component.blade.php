<div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body invoice-head">
                    <div class="row">
                        <div class="col-md-12 d-print-flex">
                            @include('livewire.partials.brc-header')
                        </div>
                    </div><!--end row-->
                </div><!--end card-body-->
                <div class="card-body">
                    <div class="row row-cols-3 d-flex justify-content-md-between">
                        <div class="col-md-3 d-print-flex">
                            <div class="">
                                <a class="btn btn-outline-primary">INVOICE</a>
                                <h6 class="mb-0"><b>Due Date :</b> {{ $invoice_data->invoice_date }}</h6>
                                <h6><b>Invoice ID :</b> # {{ $invoice_data->invoice_no }}</h6>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-3 d-print-flex">
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Status :</strong>{{ $invoice_data->status }}<br>
                                    <strong class="font-14">Billed Trom :</strong><br>
                                    @if ($invoice_data->department_id )                                        
                                        {{ $invoice_data->department->name ?? 'N/A' }}<br>
                                        {{ $invoice_data->department->prefix ?? 'N/A' }},
                                        {{ $invoice_data->department->description ?? 'N/A' }}<br>
                                    @endif
                                    @if ($invoice_data->project_id )                                        
                                        {{ $invoice_data->project->name ?? 'N/A' }}<br>
                                        {{ $invoice_data->project->prefix ?? 'N/A' }},
                                        {{ $invoice_data->project->description ?? 'N/A' }}<br>
                                    @endif
                                </address>
                            </div>
                        </div><!--end col-->
                        <div class="col-md-3 d-print-flex">
                            @if ($invoice_data->customer_id != null)
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14">Billed To:</strong><br>
                                        {{ $invoice_data->customer->name ?? 'N/A' }}<br>
                                        {{ $invoice_data->customer->address ?? 'N/A' }},
                                        {{ $invoice_data->customer->nationality ?? 'N/A' }}<br>
                                        <abbr title="Phone">P:</abbr> {{ $invoice_data->customer->contact ?? 'N/A' }}<br>
                                        <abbr title="Phone">Proj:</abbr> {{ $invoice_data->project->name ?? 'N/A' }}
                                    </address>
                                </div>
                            @else
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14">Billed To:</strong><br>
                                        {{ $invoice_data->department->name ?? 'N/A' }}<br>
                                        {{ $invoice_data->department->prefix ?? 'N/A' }},
                                        {{ $invoice_data->department->description ?? 'N/A' }}<br>
                                    </address>
                                </div>
                            @endif
                        </div> <!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive project-invoice">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Project Breakdown</th>
                                            <th>Rate({{ $invoice_data->currency->code ?? 'UG' }})</th>
                                            <th>Qty</th>
                                            <th>Subtotal({{ $currency }})</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr>
                                                <td>
                                                    <h5 class="mt-0 mb-1 font-14">{{ $item->service->name ?? 'N/A' }}
                                                    </h5>
                                                    <p class="mb-0 text-muted">{{ $item->service->description ?? '' }}
                                                    </p>
                                                </td>
                                                <td>@moneyFormat($item->unit_price ?? 0)</td>
                                                <td>{{ $item->quantity ?? 'N/A' }}</td>
                                                <td>@moneyFormat($item->line_total ?? 0)</td>
                                            </tr><!--end tr-->
                                        @endforeach
                                        <tr>
                                            <td colspan="2" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b>Sub Total</b></td>
                                            <td class="border-0 font-14 text-dark">
                                                <b></b>{{ $currency }}@moneyFormat($invoice_data->total_amount)</td>
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
                                <li><small class="font-12">All accounts are to be paid within 7 days from receipt of
                                        invoice. </small></li>
                                <li><small class="font-12">To be paid by cheque or credit card or direct payment
                                        online.</small></li>
                                <li><small class="font-12"> If account is not paid within 7 days the credits details
                                        supplied as confirmation of work undertaken will be charged the agreed quoted
                                        fee noted above.</small></li>
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
                                <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                                @if ($invoice_data->status == 'Submitted')
                                    <a href="javascript:voide(0)" wire:click="approveInvoice({{ $invoice_data->id }})"
                                        class="btn btn-de-primary btn-sm">Approve</a>
                                @endif
                                <a href="{{ route('finance-invoices') }}" class="btn btn-de-danger btn-sm">Cancel</a>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
    @if ($invoice_data->status == 'Approved' || $invoice_data->status == 'Partially Paid' || $invoice_data->status == 'Paid')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoice Payments
                        @if ($invoice_data->status == 'Approved' || $invoice_data->status == 'Partially Paid')                                
                            <a type="button" data-bs-toggle="modal" data-bs-target="#NewPaymentModal" class="btn btn-sm me-2 btn-primary float-end">
                                <i class="fa fa-plus"></i>Payment
                            </a>
                        </h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Ref No.</th>
                                        <th>Created By</th>
                                        <th>Amount Paid</th>
                                        <th>Total Balance</th>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoice_data->payments as $key => $payement)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $payement->payment_reference }}</td>
                                            <td>{{ $payement->biller->name??'N/A' }}</td>
                                            <td>{{ $payement->payment_amount }}</td>
                                            <td>{{ $payement->payment_balance }}</td>
                                            <td>{{ $payement->as_of }}</td>
                                            <td>{{ $payement->description }}</td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div>
                </div>
            </div>
            @include('livewire.finance.invoice.inc.new-invoice-payment')
        </div>
    @endif
</div>
