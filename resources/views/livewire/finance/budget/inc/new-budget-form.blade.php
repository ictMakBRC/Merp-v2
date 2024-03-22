<div x-cloak x-show="create_new">
    <form
        @if ($toggleForm) wire:submit.prevent="updateBudget" @else wire:submit.prevent="storeBudget" @endif>

        <div class="row">

            <div class="mb-3 col-2">
                <label for="fiscal_year" class="form-label required">Fiscal year</label>
                <select id="fiscal_year" class="form-control" name="fiscal_year" required wire:model="fiscal_year">
                    <option value="">Select</option>
                    @foreach ($years as $fy)
                        <option value="{{ $fy->id }}">{{ $fy->name }}</option>
                    @endforeach
                </select>
                @error('fiscal_year')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            @if ($unit_type == 'all')
                @include('livewire.partials.project-department-toggle')
            @else
                <div class="col-3">
                    <label for="unit" class="form-label required">Unit {{ $department_id }}</label>
                    <input type="text" class="form-control" id="unit" readonly
                        value="{{ $requestable->name ?? 'NA' }}" id="">

                    @error('department_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                    @error('project_id')
                        <div class="text-danger text-small">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <div class="mb-3 col-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select id="currency_id" class="form-control" name="currency_id" required wire:model="currency_id">
                    <option value="">Select</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                    @endforeach
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-2">
                <label for="name" class="form-label required">Rate</label>
                <input type="number" id="rate" step="any"
                    class="form-control" name="rate" required wire:model="rate">
                @error('rate')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col">
                <label for="name" class="form-label required">Name</label>
                <input type="text" id="name" onkeyup="this.value = this.value.toUpperCase();"
                    class="form-control" name="name" required wire:model="name">
                @error('name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-3">
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
            <div class="mb-3 col-md-4">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" class="form-control" name="description" wire:model.defer="description"></textarea>
                @error('description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="modal-footer">
            <x-button class="btn btn-success">{{ __('public.save') }}</x-button>
        </div>
        <hr>
    </form>
    <hr>
</div>
