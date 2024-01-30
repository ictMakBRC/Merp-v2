@include('livewire.finance.invoice.inc.invoice-counts')
<div class="table-responsive">
    <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Invice No.</th>
                <th>Billed From</th>
                <th>Billed To</th>
                <th>Total Amount</th>
                <th>Due Date</th>
                <th>Due Days</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $key => $invoice)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $invoice->invoice_no }}</td>
                    <td>{{ $invoice->requestable->name??'N/A' }}</td>
                    <td>{{ $invoice->customer->name??$invoice->department->name??'N/A' }}</td>
                    <td>@moneyFormat( $invoice->total_amount )</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>
                        @php
                            $days = \Carbon\Carbon::parse($invoice->due_date)->diffInDays(\Carbon\Carbon::now(), true);
                            if ($days>1) {
                                $class = 'bg-light-warning';
                            }else{
                                $class = '';
                            }
                        @endphp
                        
                        <div class="badge  bg-primary">{{ $days }}Days</div>
                    </td>
                    <td><x-status-badge :status="$invoice->status" /></td>
                    <td class="table-action">    
                        
                            <a href="{{URL::signedRoute('finance-invoice_view', $invoice->invoice_no)}}" class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                                                                
                            
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> <!-- end preview-->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="btn-group float-end">
            {{-- {{ $invoices->links('vendor.pagination.bootstrap-5') }} --}}
        </div>
    </div>
</div>