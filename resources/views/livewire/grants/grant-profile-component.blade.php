<div>    
    {{-- @include('livewire.finance.budget.inc.preview-budget') --}}
    <div class="modal-body">
        @include('livewire.partials.brc-header')
        
        <div class="card-header text-center">
            <div class="row">
                <div class="col-3">
                    <p>Name:{{ $budget_data->name }}</p>
                </div>
                <div class="col-3">
                    <p>Unit:{{ $budget_data->project->name??$budget->department->name??'N/A' }}</p>
                </div>
                <div class="col-3">
                    <p>Fiscal Year:{{ $budget_data->fiscalYear->name??'N/A' }}</p>
                </div>
                <div class="col-3">
                    <p>Currency:{{ $budget_data->currency->code??'N/A' }}</p>
                </div>
            </div>
            
            
        </div>
        <div class="card p-2">
            
            <h2 class="text-primary">Revenue</h2>
                @foreach ($incomes as $income)  
                <hr class="hr-custom">           
                <h5>{{ $income->name }}</h5> 
                @if (count($budget_lines->where('chat_of_account',$income->id))>0)
                    
                <div class="table-responsive-sm pt-2">
                    <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Ammount ({{ $budget_data->currency->code??'N/A' }})</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $number = 1;@endphp
                            @foreach ($budget_lines->where('chat_of_account',$income->id) as $key => $budget)
                                <tr>
                                    <td>{{ $number }}</td>
                                    <td>{{ $budget->name }}</td>
                                    <td>{{ $budget->quantity??1 }}</td>
                                    <td>@moneyFormat($budget->allocated_amount)</td>
                                    <td>{{ $budget->description }}</td>                                               
                                </tr>
                                @php $number++;@endphp
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="text-end">Total: <span>@moneyFormat($budget_lines->where('chat_of_account',$income->id)->sum('allocated_amount'))</span></h5>
                </div> <!-- end preview-->
                @endif
            @endforeach
            <h4 class="text-center">Total Revenue: <span>@moneyFormat($budget_lines->where('type','Revenue')->sum('allocated_amount'))</span></h4>
        </div>
        <div class="card p-2">
            <h2 class="text-info text-center">Expenses</h2>
                @foreach ($expenses as $expense)  
                <hr class="hr-custom">           
                <h5>{{ $expense->name }}</h5> 
                @if (count($budget_lines->where('chat_of_account',$expense->id))>0)
                    
                <div class="table-responsive-sm pt-2">
                    <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Ammount({{ $budget_data->currency->code??'N/A' }})</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $number = 1;@endphp
                            @foreach ($budget_lines->where('chat_of_account',$expense->id) as $key => $budget)
                                <tr>
                                    <td>{{ $number }}</td>
                                    <td>{{ $budget->name }}</td>
                                    <td>{{ $budget->quantity??1 }}</td>
                                    <td>@moneyFormat($budget->allocated_amount)</td>
                                    <td>{{ $budget->description }}</td>
                                </tr>
                                @php $number++;@endphp
                            @endforeach
                        </tbody>
                    </table>
                    <h5 class="text-end">Total: <span>@moneyFormat($budget_lines->where('chat_of_account',$expense->id)->sum('allocated_amount'))</span></h5>
                </div> <!-- end preview-->
                @endif
            @endforeach                        
            <h4 class="text-center">Total Expenses: <span>@moneyFormat($budget_lines->where('type','Expense')->sum('allocated_amount'))</span></h4>
        </div>
    </div>
</div>
