<div wire:ignore.self class="modal fade" id="newItemBudgetModal" tabindex="-1" role="dialog"
    aria-labelledby="viewBudgetModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="viewBudgetModal">
                    Add {{ $type }} Item
                </h6>
                <button type="button" class="btn-close text-danger" data-bs-dismiss="modal"
                 wire:click='close()'   aria-label="Close"></button>
            </div><!--end modal-header-->
            <form wire:submit.prevent="saveBudgetLine({{ $selected_id }})">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="budgetAmount">Budget Line:</label>
                            <select class="form-select" name="line_id" id="line_id" wire:model.defer='line_id'>
                                <option value="">Select</option>
                                @foreach ($unitLines->where('account_id', $selected_id) as $line)
                                    <option value="{{ $line->id }}">{{ $line->name }}</option>
                                @endforeach
                            </select>
                            @error('line_id')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <label for="allocated_amount">Budget
                                Amount({{ $budget_data->currency->code ?? 'N/A' }}):</label>
                            <input type="number" step="any" required class="form-control" wire:model.defer="allocated_amount">
                            @error('allocated_amount')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="quantity">Quantity</label>
                            <input type="number" step='any' required class="form-control"
                                wire:model.defer="quantity">
                            @error('quantity')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 wire:ignore" wire:ignore>
                            <label for="description">Expense description:</label>
                            <textarea required class="form-control" id="description" wire:model.defer="description"></textarea>
                            @error('description')
                                <div class="text-danger text-small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 pt-3 text-end ms-auto">
                            <button class="btn btn-info" type="submit">Save Item</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
