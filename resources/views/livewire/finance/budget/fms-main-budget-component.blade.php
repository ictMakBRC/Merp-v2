<div>
   
    @include('livewire.partials.brc-header')
    <h3 class="text-center">BUDGET</h3>
    <div class="table-responsive">
        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Department/Project</th>
                    <th>fiscal_year</th>
                    <th>Revenue</th>
                    <th>Expenditure</th>
                    <th>Currency</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $key => $budget)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $budget->project->name??$budget->department->name??'N/A' }}</td>
                        <td>{{ $budget->fiscalYear->name??'N/A' }}</td>
                        <td>{{ $budget->esitmated_income }}</td>
                        <td>{{ $budget->estimated_expenditure }}</td>
                        <td>{{ $budget->currency->code??'N/A' }}</td>
                        @if ($budget->is_active == 0)
                            <td><span class="badge bg-danger">Suspended</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        <td class="table-action">                                                  
                            <a data-bs-toggle="modal" data-bs-target="#viewBudgetModal" href="javascript:void(0)" wire:click="viewDptBudget({{$budget->id}})" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-eye"></i>
                            </a>                                
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $budgets->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
   @if ($budget_data!=null)       
    @include('livewire.finance.budget.inc.preview-budget')
   @endif
</div>
