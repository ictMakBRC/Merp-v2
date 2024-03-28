<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Project Contracts (<span
                                        class="text-danger fw-bold">{{ $contracts->total() }}</span>)

                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row">
                            <div class="mb-3 col-md-3 ">
                                <label for="project_id" class="form-label">Project</label>
                                <select class="form-select" wire:model='project_id'>
                                    <option value="0" selected>All</option>
                                    @forelse ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-info" wire:loading wire:target='project_id'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 col-md-3 ">
                                <label for="employee_id" class="form-label">Employee</label>
                                <select class="form-select" wire:model='employee_id'>
                                    <option value="0" selected>All</option>
                                    @forelse ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->fullName }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-info" wire:loading wire:target='employee_id'>
                                    <div class='spinner-border spinner-border-sm text-dark mt-2' role='status'>
                                        <span class='sr-only'></span>
                                    </div>
                                </div>
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
                                    <option value="5">5</option>
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
                                    <option value="end_date">End Date</option>
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

                            <div class="mt-4 col-md-1">
                                <x-export-button></x-export-button>
                            </div>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table class="table w-100 mb-0 table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Emp-No</th>
                                        <th>Employee Name</th>
                                        <th>Project/Study</th>
                                        <th>Designation</th>
                                        {{-- <th>Contract Summary</th> --}}
                                        <th>From</th>
                                        <th>To</th>
                                        <th>FTE</th>
                                        <th>G-Pay</th>
                                        <th>Contract</th>
                                        <th>Status</th>
                                        {{-- <th>Days to Expire</th> --}}
                                    </tr>
                                </thead>
                                @forelse ($contracts as $key => $contract)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $contract->employee->employee_number ?? 'N/A' }}</td>
                                        <td>{{ $contract->employee->fullname ?? 'N/A' }}</td>
                                        <td>{{ $contract->project->project_code ?? 'N/A' }}</td>
                                        <td>{{ $contract->designation->name ?? 'N/A' }}
                                        </td>
                                        <td>@formatDate($contract->start_date)</td>
                                        <td>@formatDate($contract->end_date)</td>
                                        <td>
                                            {{ $contract->fte ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ getCurrencyCode($contract->project->currency_id) . ' ' . $contract->gross_salary ?? '0' }}
                                        </td>
                                        <td>
                                            @if ($contract->contract_file_path)
                                                <button
                                                    wire:click='downloadContract("{{ $contract->contract_file_path }}")'
                                                    class="btn btn-sm btn-outline-success"
                                                    title="{{ __('public.download') }}"><i
                                                        class="ti ti-download"></i></button>
                                            @else
                                                {{ __('N/A') }}
                                            @endif

                                        </td>

                                        @if ($contract->status == 'Running')
                                            <td><span class="badge bg-success">{{ $contract->status }}</span>
                                            </td>
                                        @else
                                            <td><span class="badge bg-warning">{{ $contract->status }}</span>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                @endforelse

                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $contracts->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>


</div>
