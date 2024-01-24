<div>
    @foreach ($generalLeger as $accountInfo => $entries) 
    
        @php            
            $totalAmount = $entries->sum('amount_local');            
            echo "Account ID: {$accountInfo['0']}, Account Name: {$accountInfo['1']}, Total: $totalAmount\n";
            // foreach ($entries as $entry) {
            //     echo "Transaction ID: {$entry->id}, Date: {$entry->trx_date}, Amount: {$entry->total_amount}\n";
            // }
        @endphp
    @endforeach 
  
    {{-- @php
        foreach ($generalLeger as $accountInfo => $entries) {
    // $accountInfo will be an array with keys 'account_id' and 'account_name'
    $totalAmount = $entries->sum('total_amount');

    // Output or store the result as needed
    echo "Account ID: {$accountInfo['account_id']}, Account Name: {$accountInfo['account_name']}, Total: $totalAmount\n";

    // Output or store individual entries
    foreach ($entries as $entry) {
        echo "Transaction ID: {$entry->id}, Date: {$entry->trx_date}, Amount: {$entry->total_amount}\n";
    }
}
    @endphp --}}
</div>

<div>
    <style>
        .num {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            font-size: 14px;
            padding: 1px 2px;
            text-align: right;
            float: right;
            right: 0;
        }
    </style>
    @include('livewire.partials.brc-header')
    

    <div class="table-responsive d-none">
        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
            <tbody>
                @php
                    $totalExpenses = 0;
                @endphp
                <tr>
                    <td>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach ($generalLeger as $accountInfo => $entries)
                                {{-- @if ($chartAccountData['type'] === 'Expense') --}}
                                @php            
                                $totalAmount = $entries->sum('amount_local');            
                                echo "Account: $accountInfo, Total: $totalAmount\n";
                                // foreach ($entries as $entry) {
                                //     echo "Transaction ID: {$entry->id}, Date: {$entry->trx_date}, Amount: {$entry->total_amount}\n";
                                // }
                            @endphp
                                    <div class="card">

                                        <a class="collapsed" type="button" data-bs-toggle="collapse"
                                            {{-- wire:click="getDepartMentBudgets({{ $chartAccountData['chartOfAccount']['id'] }})" --}}
                                            data-bs-target="#coa_{{ $accountInfo }}"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            <div class="card-header" role="tab" id="questionOne">
                                                <h5 class="accordion-header card-title" id="flush-headingOne">
                                                    {{ $accountInfo }}
                                                    <span class="num">@moneyFormat($totalAmount)</span>
                                                </h5>
                                            </div>
                                        </a>
                                        <div wire:ignore.self id="coa_{{ $accountInfo }}"
                                            class="accordion-collapse collapse card-bodyg"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body ml-4">
                                                    <div class="table-responsive-sm pt-2">
                                                        <table
                                                            class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Date</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $number = 1; @endphp
                                                                @foreach ($entries as $entry)
                                                                    <tr>
                                                                        <td>{{ $number }}</td>
                                                                        <td>{{ $entry->trx_date}}</td>
                                                                        <td class="text-end">@moneyFormat($entry->amount_local)</td>

                                                                    </tr>
                                                                    @php $number++; @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end preview-->
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $totalExpenses += $totalAmount;
                                    @endphp
                                {{-- @endif --}}
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 class="text-end">Total Expenses: @moneyFormat($totalExpenses)</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end preview-->
    {{-- <div class="row text-center">
        @php
            $difference = $totalRevenue - $totalExpenses;
        @endphp
        <div class="col-4">
            <h5>Revenue: @moneyFormat($totalRevenue)</h5>
        </div>
        <div class="col-4">
            <h5>Expenditure: @moneyFormat($totalExpenses)</h5>
        </div>
        <div class="col-4">
            <h5 @if ($difference < 0) class="text-danger" @endif>Difference: @moneyFormat($difference)</h5>
        </div>
    </div> --}}

</div>
