<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'), create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    @if (!$toggleForm)
                                        {{ __('Procurements Sectors and Categories') }}
                                        {{-- @include('livewire.layouts.partials.inc.filter-toggle-alpine') --}}
                                    @else
                                        {{ __('Edit Subcategory') }}
                                    @endif

                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('livewire.procurement.settings.inc.subcategory-create-form')

                    <div class="tab-content">

                        <div class="row mb-0">
                            <div class="mt-4 col-md-1">
                                <x-export-button></x-export-button>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label for="from_date" class="form-label">{{ __('public.from_date') }}</label>
                                <input id="from_date" type="date" class="form-control" wire:model.lazy="from_date">
                                <div class="text-info" wire:loading wire:target='from_date'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="to_date" class="form-label">{{ __('public.to_date') }}</label>
                                <input id="to_date" type="date" class="form-control" wire:model.lazy="to_date">
                                <div class="text-info" wire:loading wire:target='to_date'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="perPage" class="form-label">{{ __('public.per_page') }}</label>
                                <select wire:model="perPage" class="form-select" id="perPage">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <div class="text-info" wire:loading wire:target='perPage'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-2">
                                <label for="orderBy" class="form-label">{{ __('public.order_by') }}</label>
                                <select wire:model="orderBy" class="form-select">
                                    <option value="name">Name</option>
                                    <option value="code">Code</option>
                                    <option value="category">Category</option>
                                    <option value="id">Latest</option>

                                </select>
                                <div class="text-info" wire:loading wire:target='orderBy'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-1">
                                <label for="orderAsc" class="form-label">{{ __('public.order') }}</label>
                                <select wire:model="orderAsc" class="form-select" id="orderAsc">
                                    <option value="1">Asc</option>
                                    <option value="0">Desc</option>
                                </select>
                                <div class="text-info" wire:loading wire:target='orderAsc'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3">
                                <label for="search" class="form-label">{{ __('public.search') }}</label>
                                <input id="search" type="text" class="form-control" wire:model.lazy="search"
                                    placeholder="search">
                                <div class="text-info" wire:loading wire:target='search'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>


                        <div class="table-responsive">
                            <table class="table table-striped mb-0 w-100 sortable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>{{ __('public.name') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('public.status') }}</th>
                                        <th>{{ __('public.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subcategories as $key => $subcategory)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $subcategory->name }}</td>
                                            <td>{{ $subcategory->category ?? 'N/A' }}</td>
                                            <td>{{ $subcategory->code ?? 'N/A' }}</td>
                                            @if ($subcategory->is_active == 0)
                                                <td><span class="badge bg-danger">Suspended</span></td>
                                            @else
                                                <td><span class="badge bg-success">Active</span></td>
                                            @endif
                                            <td>
                                                {{-- <button class="btn btn btn-sm btn-outline-success" wire:click="editData({{ $user->id }})" data-bs-toggle="tooltip" data-bs-placement="right" title="{{__('public.edit')}}" data-bs-trigger="hover">
                                                    <i class="ti ti-edit fs-18"></i></button> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $subcategories->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

</div>
