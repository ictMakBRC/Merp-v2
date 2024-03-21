<div>
    <div class="card">
        <div class="card-header">
            <h1 class="text-info text-center">Budget lines for {{ $requestable?->name }} unit</h1>
        </div>
        <div class="card-body">
            <h2 class="text-primary">Revenue</h2>
            <div class="accordion accordion-flush" id="accordionIncome">
                @foreach ($incomes->where('is_budget', 2) as $parent_income)
                    <div class="card">
                        <a class=" collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#coaI_{{ $parent_income->id }}" aria-expanded="false"
                            aria-controls="flush-collapseOne">
                            <div class="card-header" role="tab">
                                <div class="row">
                                    <div class="col-3">
                                        <h5 class="accordion-header card-title" id="flush-headingOne">
                                            {{ $parent_income->name }}</h5>
                                    </div>
                                    <div class="col-9">
                                        <small>{{ $parent_income->description }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <div wire:ignore.self id="coaI_{{ $parent_income->id }}"
                            class="accordion-collapse collapse card-bodyg" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionIncome">
                            <div class="accordion-body ml-4">
                                @foreach ($incomes->where('is_budget', 1)->where('parent_account', $parent_income->id) as $income)
                                    <hr class="hr-custom">
                                    <h4>{{ $income->name }}</h4>
                                    <form wire:submit.prevent="saveBudgetLine({{ $income->id }})">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="budgetAmount_{{ $income->id }}">Budget Name:</label>
                                                <input type="text" class="form-control"
                                                    wire:model.lazy="name.{{ $income->id }}">
                                                @error('name')
                                                    <div class="text-danger text-small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="description_{{ $income->id }}">Income
                                                    description:</label>
                                                <input type="text" required class="form-control"
                                                    wire:model.lazy="description.{{ $income->id }}">
                                                @error('description')
                                                    <div class="text-danger text-small">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-2 pt-3 text-end">
                                                <button wire:click="$set('type','Revenue')" class="btn btn-primary"
                                                    type="submit">Save
                                                    Item</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if (count($budget_lines->where('account_id', $income->id)) > 0)
                                        <div class="table-responsive-sm pt-2">
                                            <table
                                                class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
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
                                                                    wire:click="confirmDelete('{{ $budget->id }}')"
                                                                    class="text-danger">
                                                                    <i class="fa fa-trash"></i>
                                                                </a>
                                                                <a href="javascript:void(0)"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#updateLine"
                                                                    wire:click="editData('{{ $budget->id }}')"
                                                                    class="text-info">
                                                                    <i class="fa fa-edit"></i>
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
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="p-2">
                <h2 class="text-info">Expenses</h2>
                <div class="accordion accordion-flush" id="accordionExpense">
                    @foreach ($expenses->where('is_budget', 2) as $parent)
                        <div class="card">
                            <a class=" collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#coa_{{ $parent->id }}" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <div class="card-header" role="tab" id="questionOne">
                                    <div class="row">
                                        <div class="col-3">
                                            <h5 class="accordion-header card-title" id="flush-headingOne">
                                                {{ $parent->name }}</h5>
                                        </div>
                                        <div class="col-9">
                                            <small>{{ $parent->description }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <div wire:ignore.self id="coa_{{ $parent->id }}"
                                class="accordion-collapse collapse card-bodyg" aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionExpense">
                                <div class="accordion-body ml-4">
                                    @foreach ($expenses->where('is_budget', 1)->where('parent_account', $parent->id) as $expense)
                                        <hr class="hr-custom">
                                        <h4>{{ $expense->name }}</h4>
                                        <form wire:submit.prevent="saveBudgetLine({{ $expense->id }})">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="budgetname_{{ $expense->id }}">Budget Name:</label>
                                                    <input type="text" class="form-control"
                                                        wire:model.lazy="name.{{ $expense->id }}">
                                                    @error('name')
                                                        <div class="text-danger text-small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="description_{{ $expense->id }}">Expense
                                                        description:</label>
                                                    <input type="text" required class="form-control"
                                                        wire:model.lazy="description.{{ $expense->id }}">
                                                    @error('description')
                                                        <div class="text-danger text-small">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-2 pt-3 text-end">
                                                    <button wire:click="$set('type','Expense')" class="btn btn-info"
                                                        type="submit">Save
                                                        Item</button>
                                                </div>
                                            </div>
                                        </form>
                                        @if (count($budget_lines->where('account_id', $expense->id)) > 0)
                                            <div class="table-responsive-sm pt-2">
                                                <table
                                                    class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
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
                                                                        wire:click="confirmDelete('{{ $budget->id }}')"
                                                                        class="text-danger">
                                                                        <i class="fa fa-trash"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#updateLine"
                                                                        wire:click="editData('{{ $budget->id }}')"
                                                                        class="text-info">
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
                        </div>
                    @endforeach
                </div>
            </div>
            <div wire:ignore.self class="modal fade" id="updateLine" tabindex="-1" role="dialog"
                aria-labelledby="updateLine" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
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
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                                wire:click="close()" aria-label="Close"></button>
                        </div><!--end modal-header-->

                        <form wire:submit.prevent="updateInvline()">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="name" class="form-label required">Name</label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            required wire:model="name">
                                        @error('name')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="is_active"
                                            class="form-label required">{{ __('public.status') }}</label>
                                        <select class="form-select select2" id="is_active"
                                            wire:model="is_active">
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
                                        <textarea id="description" class="form-control" name="description" wire:model="description"></textarea>
                                        @error('description')
                                            <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal"
                                    wire:click="close()">{{ __('public.close') }}</button>
                                @if ($toggleForm)
                                    <x-button type="submit"
                                        class="btn-success btn-sm">{{ __('public.update') }}</x-button>
                                @else
                                    <x-button type="submit"
                                        class="btn-success btn-sm">{{ __('public.save') }}</x-button>
                                @endif
                            </div><!--end modal-footer-->
                        </form>
                    </div><!--end modal-content-->
                </div><!--end modal-dialog-->
            </div><!--end modal-->
            @include('livewire.inventory.inc.confirm-delete')
            @push('scripts')
                <script>
                    window.addEventListener('close-modal', event => {
                        $('#deptItemupdateCreateModal').modal('hide');
                        $('#delete_modal').modal('hide');
                        $('#confirmDelete').modal('hide');
                        $('#updateLine').modal('hide');
                    });
                    window.addEventListener('show-modal', event => {
                        $('#deptItemupdateCreateModal').modal('show');
                    });
                    window.addEventListener('delete-modal', event => {
                        $('#confirmDelete').modal('show');
                    });
                </script>
            @endpush
        </div>
