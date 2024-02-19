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
                    <td>{{ $invoice->requestable->name ?? 'N/A' }}</td>
                    <td>{{ $invoice->billtable->name ?? 'N/A' }}</td>
                    <td>@moneyFormat($invoice->total_amount)</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>
                        @php
                            $due_date = \Carbon\Carbon::parse($invoice->due_date);
                            $today = \Carbon\Carbon::now();
                            $days = \Carbon\Carbon::parse($invoice->due_date)->diffInDays(\Carbon\Carbon::now(), true);
                            if ($days > 1 && $invoice->status != 'Fully Paid' && $due_date<$today) {
                                $class = 'bg-light-warning';
                            } else {
                                $class = '';
                                $days = 0;
                            }
                        @endphp
                        {{ $today.'-'.$due_date }}
                        <div class="badge  bg-primary">{{ $days }}Days</div>
                    </td>
                    <td><x-status-badge :status="$invoice->status" /></td>
                    <td class="table-action">
                        @if ($invoice->status == 'Pending')
                            <a href="{{ URL::signedRoute('finance-invoice_items', $invoice->invoice_no) }}"
                                class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-edit"></i></a>
                        @else
                            <a href="{{ URL::signedRoute('finance-invoice_view', $invoice->invoice_no) }}"
                                class="action-ico btn-sm btn btn-outline-success mx-1"><i class="fa fa-eye"></i></a>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div> <!-- end preview-->
