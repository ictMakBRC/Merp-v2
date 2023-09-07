<div>
    <div class="row">
        <div class="row col-md-6">
            <div class="mb-3 col-md-12">
                <label for="provider_id" class="form-label required">{{ __('Provider') }}</label>
                <select class="form-select" id="provider_id" wire:model.lazy="provider_id">
                    <option selected value="">Select</option>
                    @forelse ($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @empty
                    @endforelse
                </select>
                @error('provider_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-12">
                <label for="sector" class="form-label required">{{ __('Sector Category') }}</label>
                <select class="form-select" id="sector" wire:model.lazy="category">
                    <option selected value="">Select</option>
                    <option value="Supplies">Supplies</option>
                    <option value="Services">Services</option>
                    <option value="Works">Works</option>
                    <option value="Consultancy">Consultancy</option>
                </select>
                @error('sector')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 col-md-12 scrollable-div">
                <div class="list-group list-group-flush">
                    @forelse ($subcategories as $subcategory)
                        <div class="form-check list-group-item py-1 ms-2">
                            <input class="form-check-input" type="checkbox" value="{{ $subcategory->id }}"
                                id="subcategory{{ $subcategory->id }}" wire:model="provider_subcategories">
                            <label class="form-check-label"
                                for="subcategory{{ $subcategory->id }}">{{ $subcategory->name }}</label>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="row col-md-6">
            <div class="col-12">
                @if (!$selectedSubcategories->isEmpty())
                    <div class="table-responsive scrollabe-content scrollable">
                        <table class="table mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('public.short_code') }}</th>
                                    <th>{{ __('public.name') }}</th>
                                    <th>{{ __('public.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selectedSubcategories as $key=>$subcategory)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $subcategory->code }}
                                        </td>
                                        <td>{{ $subcategory->name }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <button wire:click='detachSubcategory({{ $subcategory->id }})'
                                                    class="btn-outline-danger btn btn-sm"
                                                    title="{{ __('public.cancel') }}"><i class="ti ti-x"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-warning"><i class='bx bx-primary-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-warning">{{ __('Subcategories') }}</h6>
                                <div>{{ __('public.not_found') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if (count($provider_subcategories))
                    <hr>
                    <div class="modal-footer">
                        <button class="btn btn-outline-success btn-sm"
                            wire:click='attachSubcategories'>{{ __('public.submit') }}</button>
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
