<div>
    @push('styles')
        <style>
            .hr-custom {
                margin: 2px 0;
                padding: 2px 0;
            }
        </style>
    @endpush
    <div class="card p-2">
        <div class="card-header">
            @include('livewire.partials.brc-header')
            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Fiscal Year</th>
                        <th>Unit</th>
                        <th>Revenue</th>
                        <th>Expenditure</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $budget_data->name }}</td>
                        <td>{{ $budget_data->fiscalYear->name ?? 'N/A' }}</td>
                        <td>{{ $budget_data->requestable->name ?? 'N/A' }}</td>
                        <td>{{ $budget_data->estimated_income }}</td>
                        <td>{{ $budget_data->estimated_expenditure }}</td>
                        <td>{{ $budget_data->currency->code ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h2 class="text-primary">Revenue <span class="text-end"><a class="btn btn-sm btn-success text-end float-end"
                    data-bs-toggle="modal" data-bs-target="#viewBudgetModal" href="javascript:void(0)">Preview
                    Budget</a></span></h2>
        @foreach ($incomes as $income)
            @if (count($unitLines->where('account_id', $income->id))>0)
            <hr class="hr-custom">
                <h4>{{ $income->name }}</h4>                      
                <div class="ms-auto text-end">
                    <button wire:click="selectLine({{ $income->id }},'Revenue')" data-bs-target="#newItemBudgetModal" data-bs-toggle="modal" class="btn btn-success btn-sm" type="submit">Add Item</button>
                </div>
                @if (count($budget_lines->where('chat_of_account', $income->id)) > 0)
                    <div class="table-responsive-sm pt-2">
                        <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Ammount ({{ $budget_data->currency->code ?? 'N/A' }})</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1; @endphp
                                @foreach ($budget_lines->where('chat_of_account', $income->id) as $key => $budget)
                                    <tr>
                                        <td>{{ $number }}</td>
                                        <td>{{ $budget->name }}</td>
                                        <td>{{ $budget->quantity??1 }}</td>
                                        <td>@moneyFormat($budget->allocated_amount)</td>
                                        <td>{!! $budget->description !!}</td>
                                        <td class="table-action">

                                            <a href="javascript:void(0)" wire:click="confirmDelete('{{ $budget->id }}')"
                                                class="text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    @php $number++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        <h5 class="text-end">Total: <span>@moneyFormat($budget_lines->where('chat_of_account', $income->id)->sum('allocated_amount'))</span></h5>
                    </div> <!-- end preview-->
                @endif   
            @endif
        @endforeach
        <h4 class="text-center">Total Revenue: <span>@moneyFormat($budget_lines->where('type', 'Revenue')->sum('allocated_amount'))</span></h4>
    </div>
    <div class="card p-2">
        <h2 class="text-info text-center">Expenses</h2>
        @foreach ($expenses as $expense)
            @if (count($unitLines->where('account_id', $expense->id))>0)
                <hr class="hr-custom">
                <h4>{{ $expense->name }} </h4>        
                <div class="ms-auto text-end">
                    <button wire:click="selectLine({{ $expense->id }},'Expense')" data-bs-target="#newItemBudgetModal" data-bs-toggle="modal" class="btn btn-info btn-sm" type="submit">Add Item</button>
                </div>
                @if (count($budget_lines->where('chat_of_account', $expense->id)) > 0)
                    <div class="table-responsive-sm pt-2">
                        <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Ammount({{ $budget_data->currency->code ?? 'N/A' }})</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1;@endphp
                                @foreach ($budget_lines->where('chat_of_account', $expense->id) as $key => $budget)
                                    <tr>
                                        <td>{{ $number }}</td>
                                        <td>{{ $budget->name }}</td>
                                        <td>{{ $budget->quantity??1 }}</td>
                                        <td>@moneyFormat($budget->allocated_amount)</td>
                                        <td>                                                 
                                                    <div class="scrollable list-group">                                                   
                                                        {!! $budget->description !!}
                                                    </div>
                                        </td>
                                        <td class="table-action">
                                            <a href="javascript:void(0)" wire:click="confirmDelete('{{ $budget->id }}')"
                                                class="text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    @php $number++;@endphp
                                @endforeach
                            </tbody>
                        </table>
                        <h5 class="text-end">Total: <span>@moneyFormat($budget_lines->where('chat_of_account', $expense->id)->sum('allocated_amount'))</span></h5>
                    </div> <!-- end preview-->
                @endif
            @endif
        @endforeach

        <h4 class="text-center">Total Expenses: <span>@moneyFormat($budget_lines->where('type', 'Expense')->sum('allocated_amount'))</span></h4>
    </div>
    <span class="text-end"><a class="btn btn-sm btn-success text-end float-end" data-bs-toggle="modal"
            data-bs-target="#viewBudgetModal" href="javascript:void(0)">Preview Budget</a>
            <a class="btn btn-sm btn-success text-end float-end" wire:click='saveBudget' href="javascript:void(0)">Save Budget</a>
        </span>
    @include('livewire.finance.budget.inc.preview-budget')
    @include('livewire.finance.budget.inc.new-budget-item-form')
    @include('livewire.partials.delete')
    @push('scripts')
    <script>
        let editorInstance;
        ClassicEditor
            .create(document.querySelector('#description'))
            .then(editor => {
                editorInstance = editor;
                editor.model.document.on('change:data', () => {
                @this.set('description', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
         

        window.addEventListener('delete-modal', event => {
           $('#delete_modal').modal('show');
       });
       window.addEventListener('close-modal', event => {
           $('#newItemBudgetModal').modal('hide');
           $('#delete_modal').modal('hide');
           $('#show-delete-confirmation-modal').modal('hide');
           if (editorInstance) {
                editorInstance.setData('');
            }
       });
            
    </script>
    @endpush
</div>
