<div class="tab-content">
    @include('livewire.human-resource.employee-data.inc.filter-employees')
    <div class="row">
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
                <option value="first_name">First Name</option>
                <option value="surname">Surname</option>
                <option value="id">Latest</option>
                <option value="is_active">Status</option>
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
        <table class="table table-striped mb-0 w-100 ">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Emp-No</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Department</th>
                    {{-- <th>Work Type</th> --}}
                    <th>Designation</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $key => $employee)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $employee->employee_number }}</td>
                        <td>{{ $employee->fullName }}</td>
                        <td>{{ $employee->gender }}</td>
                        <td>{{ $employee->contact }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->department ? $employee->department->name : 'N/A' }}</td>
                        <td>{{ $employee->designation ? $employee->designation->name : 'N/A' }}</td>
                        @if (!$employee->is_active)
                            <td><span class="badge bg-danger">Inactive</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        <td class="table-action">
                            <a href="{{ URL::signedRoute('employee-details', $employee->id) }}" class="btn btn btn-sm btn-outline-success"> <i
                                    class="ti ti-eye"></i></a>   
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{ $employees->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
