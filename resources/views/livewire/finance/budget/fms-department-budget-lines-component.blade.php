<div>
    <div class="card">
        <div class="card-header">
            <h1 class="text-info text-center">Budget lines for {{ $requestable?->name }} unit</h1>
        </div>
        <div class="card-body">
            <h2 class="text-primary">Revenue</h2>
            @foreach ($incomes as $income)
                <hr class="hr-custom">
                <h4>{{ $income->name }}</h4>
                <form wire:submit.prevent="saveBudgetLine({{ $income->id }})">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="budgetAmount_{{ $income->id }}">Budget Name:</label>
                            <input type="text" class="form-control" wire:model="name.{{ $income->id }}">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
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
                @if (count($budget_lines->where('account_id', $income->id)) > 0)
                    <div class="table-responsive-sm pt-2">
                        <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1; @endphp
                                @foreach ($budget_lines->where('account_id', $income->id) as $key => $budget)
                                    <tr>
                                        <td>{{ $number }}</td>
                                        <td>{{ $budget->name }}</td>
                                        <td>{{ $budget->description }}</td>
                                        <td class="table-action">

                                            <a href="javascript:void(0)"
                                                wire:click="confirmDelete('{{ $budget->id }}')" class="text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    @php $number++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                @endif
            @endforeach
        </div>
        <div class="p-2">
            <h2 class="text-info">Expenses</h2>
            @foreach ($expenses as $expense)
                <hr class="hr-custom">
                <h4>{{ $expense->name }}</h4>
                <form wire:submit.prevent="saveBudgetLine({{ $expense->id }})">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="budgetname_{{ $expense->id }}">Budget Name:</label>
                            <input type="text" class="form-control" wire:model="name.{{ $expense->id }}">
                            @error('name')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
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
                @if (count($budget_lines->where('account_id', $expense->id)) > 0)
                    <div class="table-responsive-sm pt-2">
                        <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $number = 1;@endphp
                                @foreach ($budget_lines->where('account_id', $expense->id) as $key => $budget)
                                    <tr>
                                        <td>{{ $number }}</td>
                                        <td>{{ $budget->name }}</td>
                                        <td>{{ $budget->description }}</td>
                                        <td class="table-action">
                                            <a href="javascript:void(0)"
                                                wire:click="confirmDelete('{{ $budget->id }}')" class="text-danger">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#updateLine" 
                                            wire:click="editData('{{ $budget->id }}')" class="text-info">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        </td>
                                    </tr>
                                    @php $number++;@endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                @endif
            @endforeach
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="updateLine" tabindex="-1" role="dialog" aria-labelledby="updateLine" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="updateLine">
                        @if (!$toggleForm)
                            New Line
                        @else
                            Edit Budget-line
                        @endif
                    </h6>
                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" wire:click="close()" aria-label="Close"></button>
                </div><!--end modal-header-->                       
                
                    <form  wire:submit.prevent="updateInvline()">            
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label for="name" class="form-label required">Name</label>
                                    <input type="text" id="name" class="form-control" name="name" required
                                        wire:model.defer="name">
                                    @error('name')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="is_active" class="form-label required">{{ __('public.status') }}</label>
                                    <select class="form-select select2" id="is_active" wire:model.defer="is_active">
                                        <option selected value="">Select</option>
                                        <option value='1'>Active</option>
                                        <option value='0'>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="countryName" class="form-label">Description</label>
                                    <textarea  id="description" class="form-control"
                                    name="description" wire:model.defer="description"></textarea>
                                    @error('description')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="close()" >{{ __('public.close') }}</button>
                            @if($toggleForm) 
                            <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                            @else 
                            <x-button type="submit"  class="btn-success btn-sm">{{ __('public.save') }}</x-button>
                            @endif
                        </div><!--end modal-footer-->
                    </form>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
</div>
