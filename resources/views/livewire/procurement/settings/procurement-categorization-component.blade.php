<div>
    <div class="row" x-data="{ create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        {{ __('Procurement Categorizations') }}
                                    @else
                                        {{ __('Edit Categorization') }}
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div x-cloak x-show="create_new">
                        <form
                            @if (!$toggleForm) wire:submit.prevent="storeCategorization"
                        @else
                        wire:submit.prevent="updateCategorization" @endif>
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label for="categorization"
                                        class="form-label required">{{ __('Categorization') }}</label>
                                    <select class="form-select" id="categorization" wire:model.lazy="categorization">
                                        <option selected value="">Select</option>
                                        <option value="Micro">Micro Procurement</option>
                                        <option value="Macro">Macro Procurement</option>
                                    </select>
                                    @error('categorization')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="threshold"
                                        class="form-label required">{{ __('Threshold Amount') }}</label>
                                    <input type="number" id="threshold" class="form-control"
                                        wire:model.defer="threshold" step="0.01"
                                        @if ($readonly) {{ 'readonly' }} @endif>
                                    @error('threshold')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label for="contract_requirement_threshold"
                                        class="form-label required">{{ __('Contract Requirement Threshold') }}</label>
                                    <input type="number" id="contract_requirement_threshold" class="form-control"
                                        wire:model.defer="contract_requirement_threshold"
                                        @if ($categorization == 'Micro') readonly placeholder="Not Required"
                                    @else
                                    required @endif
                                        step="0.01">
                                    @error('contract_requirement_threshold')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label for="currency_id" class="form-label required">{{ __('Currency') }}</label>
                                    <select class="form-select" id="currency_id" wire:model.lazy="currency_id"
                                        disabled>
                                        <option selected value="">Select</option>
                                        @include('layouts.currencies')
                                    </select>
                                    @error('currency_id')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="description" class="form-label">{{ __('Description') }}</label>
                                    <textarea type="text" id="description" class="form-control" wire:model.defer="description"></textarea>
                                    @error('description')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="modal-footer">
                                <x-button type="submit" class="btn btn-success">{{ __('public.save') }}</x-button>
                            </div>
                        </form>
                        <hr>
                    </div>

                    <div class="tab-content">

                        <div class="table-responsive">
                            <table class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ __('Categorization') }}</th>
                                        <th>{{ __('Threshold') }}</th>
                                        <th>{{ __('Contract Requirement Threshold') }}</th>
                                        <th>{{ __('Currency') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('public.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categorizations as $key => $category)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category->categorization }}</td>
                                            <td>
                                                @if ($category->categorization == 'Macro')
                                                    {{ '>=' }} @moneyFormat($category->threshold)
                                                @else
                                                    {{ '<=' }} @moneyFormat($category->threshold)
                                                @endif
                                            </td>
                                            <td>
                                                @if ($category->categorization == 'Macro')
                                                {{ '>=' }} @moneyFormat($category->contract_requirement_threshold)
                                                @else
                                                    {{ __('N/A') }}
                                                @endif
                                            </td>
                                            <td>{{ $category->currency->code ?? 'N/A' }}</td>
                                            <td>{{ $category->description ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn btn-sm btn-outline-success"
                                                    wire:click="editData({{ $category->id }})"
                                                    title="{{ __('public.edit') }}">
                                                    <i class="ti ti-edit fs-18"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>
