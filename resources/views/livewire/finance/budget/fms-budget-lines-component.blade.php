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
                        <th>fiscal_year</th>
                        <th>Department/Project</th>
                        <th>Revenue</th>
                        <th>Expenditure</th>
                        <th>Currency</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $budget_data->name }}</td>
                        <td>{{ $budget_data->fiscalYear->name ?? 'N/A' }}</td>
                        <td>{{ $budget_data->project->name ?? ($budget->department->name ?? 'N/A') }}</td>
                        <td>{{ $budget_data->esitmated_income }}</td>
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
            <hr class="hr-custom">
            <h4>{{ $income->name }}</h4>
            <form wire:submit.prevent="saveBudgetLine({{ $income->id }})">
                <div class="row">
                    <div class="col-md-3">
                        <label for="budgetAmount_{{ $income->id }}">Budget Name:</label>
                        <input type="text" class="form-control" wire:model="name.{{ $income->id }}">
                        @error('name')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="quantity_{{ $income->id }}">Quantity</label>
                        <input type="number" step='any' required class="form-control"
                            wire:model="quantity.{{ $income->id }}">
                        @error('quantity')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="allocated_amount_{{ $income->id }}">Budget Amount
                            ({{ $budget_data->currency->code ?? 'N/A' }}):</label>
                        <input type="number" required class="form-control"
                            wire:model="allocated_amount.{{ $income->id }}">
                        @error('allocated_amount')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="description_{{ $income->id }}">Income description:</label>
                        <input type="text" required class="form-control"
                            wire:model="description.{{ $income->id }}">
                        @error('description')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-2 pt-3 text-end">
                        <button wire:click="$set('type','Revenue')" class="btn btn-primary" type="submit">Save
                            Item</button>
                    </div>
                </div>
            </form>
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
                                    <td>{{ $budget->description }}</td>
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
        @endforeach
        <h4 class="text-center">Total Revenue: <span>@moneyFormat($budget_lines->where('type', 'Revenue')->sum('allocated_amount'))</span></h4>
    </div>
    <div class="card p-2">
        <h2 class="text-info text-center">Expenses</h2>
        @foreach ($expenses as $expense)
            <hr class="hr-custom">
            <h4>{{ $expense->name }}</h4>
            <form wire:submit.prevent="saveBudgetLine({{ $expense->id }})">
                <div class="row">
                    <div class="col-md-3">
                        <label for="budgetAmount_{{ $expense->id }}">Budget Line:</label>
                        <input type="text" class="form-control" wire:model="name.{{ $expense->id }}">
                        @error('name')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="allocated_amount_{{ $expense->id }}">Budget
                            Amount({{ $budget_data->currency->code ?? 'N/A' }}):</label>
                        <input type="number" required class="form-control"
                            wire:model="allocated_amount.{{ $expense->id }}">
                        @error('allocated_amount')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="quantity_{{ $expense->id }}">Quantity</label>
                        <input type="number" step='any' required class="form-control"
                            wire:model="quantity.{{ $expense->id }}">
                        @error('quantity')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="description_{{ $expense->id }}">Expense description:</label>
                        <input type="text" required class="form-control"
                            wire:model="description.{{ $expense->id }}">
                        @error('description')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-2 pt-3 text-end">
                        <button wire:click="$set('type','Expense')" class="btn btn-info" type="submit">Save
                            Item</button>
                    </div>
                </div>
            </form>
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
                                    <td>{{ $budget->description }}</td>
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
        @endforeach

        <h4 class="text-center">Total Expenses: <span>@moneyFormat($budget_lines->where('type', 'Expense')->sum('allocated_amount'))</span></h4>
    </div>
    <span class="text-end"><a class="btn btn-sm btn-success text-end float-end" data-bs-toggle="modal"
            data-bs-target="#viewBudgetModal" href="javascript:void(0)">Preview Budget</a>
            <a class="btn btn-sm btn-success text-end float-end" wire:click='saveBudget' href="javascript:void(0)">Save Budget</a>
        </span>
    @include('livewire.finance.budget.inc.preview-budget')
    @include('livewire.partials.delete')
</div>
