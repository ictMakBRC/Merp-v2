<div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body invoice-head">
                    <div class="row">
                        <div class="col-md-12 d-print-flex">
                            @include('livewire.partials.brc-header')
                            <h4 class="text-center"> Ledger Account for: <span>{{ $ledger_account->requestable->name }}</span> Unit</h4>
                            <h5>Account Name: {{ $ledger_account->name }}({{ $ledger_account->currency->code ?? 'UG' }})</h5>
                        </div>
                    </div><!--end row-->
                </div><!--end card-body-->
                <div class="card-body">
                   
                   
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive project-invoice">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>TRX No.</th>
                                            <th>Date</th>
                                            <th>Reference</th>
                                            <th>Memo</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->trx_no }}</td>
                                                <td>{{ $transaction->trx_date }}</td>
                                                <td>{{ $transaction->trx_ref }}</td>
                                                <td>
                                                    <p class="mb-0 text-muted">{{ $transaction->description ?? '' }}
                                                    </p>
                                                </td>
                                                <td class="text-end">
                                                    @if ($transaction->trx_type=='Expense')
                                                        @moneyFormat($transaction->account_amount ?? 0)                                                       
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if ($transaction->trx_type=='Income')
                                                        @moneyFormat($transaction->account_amount ?? 0)                                                       
                                                    @endif
                                                </td>
                                                <td class="text-end">@moneyFormat($transaction->account_balance ?? 0)</td>
                                            </tr><!--end tr-->
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b> Total</b>({{ $ledger_account->currency->code }})</td>
                                            <td class="border-0 font-14 text-dark text-end">@moneyFormat($transactions->where('trx_type','Expense')->sum('account_amount'))</td>
                                            <td class="border-0 font-14 text-dark text-end">@moneyFormat($transactions->where('trx_type','Income')->sum('account_amount'))</td>
                                            <td class="border-0 font-14 text-dark text-end">@moneyFormat($ledger_account->current_balance??0)</td>
                                        </tr><!--end tr-->
                                        
                                    </tbody>
                                </table><!--end table-->
                            </div> <!--end /div-->
                        </div> <!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mt-4">Notes :</h5>
                            <ul class="ps-3">
                                <li><small class="font-12">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Deleniti voluptatem nulla dolores ipsam incidunt distinctio cupiditate, doloribus debitis quaerat veritatis vel corporis hic, exercitationem, fuga accusantium reiciendis sed eaque velit! </small></li>
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
                            <div class="text-center"><small class="font-12">This Document was electronocally generated.</small></div>
                        </div><!--end col-->
                        <div class="col-lg-12 col-xl-4">
                            <div class="float-end d-print-none mt-2 mt-md-0">
                                <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                               
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
</div>
