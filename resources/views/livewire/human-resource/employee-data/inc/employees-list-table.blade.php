<div class="tab-content">
    @include('livewire.human-resource.employee-data.inc.filter-employees')

 
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
                        <td>{{ $employee->department?$employee->department->name:'N/A' }}</td>
                        <td>{{ $employee->designation?$employee->designation->name:'N/A' }}</td>
                        @if (!$employee->is_active)
                            <td><span class="badge bg-danger">Inactive</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        <td class="table-action">
                            <a href="{{ route('employee-details', $employee->id) }}"
                                class="action-icon"> <i class="ti ti-eye"></i></a>

                                {{-- <a href="{{ URL::signedRoute('hr.viewPaySlip', $employee->id) }}"
                                    class="action-icon"> <i class="mdi mdi-eye"></i></a> --}}
                                    {{-- <a href="{{ route('humanresource.downloadPayslip', $employee->id) }}"
                                        class="action-icon"> <i class="mdi mdi-download"></i></a> --}}
                            {{-- @if (Auth::user()->isAbleTo('employee-create'))
                                <a href="{{ route('employees.edit', [$employee->id]) }}"
                                    class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                            @endif --}}
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
