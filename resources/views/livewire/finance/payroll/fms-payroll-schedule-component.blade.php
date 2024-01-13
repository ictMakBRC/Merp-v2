<div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table-striped text-info">
                    <tr>
                        <td>Current Rates:</td>
                        @foreach ($currencies as $currency)
                            <td>{{ $currency->code . ' Rate ' . $currency->exchange_rate . ' | ' }}</td>
                        @endforeach
                    </tr>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <form wire:submit.prevent="createPayrollRate()">
                    <div class="row">

                        <div class="col-5">
                            <label for="year">Currency:</label>
                            <select class="form-select" wire:model="currency_id" id="currency_id">
                                <option value="">select</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-5">
                            <label for="year">Rate:</label>
                            <input type="number" step="any" class="form-control" wire:model="rate" id="rate">
                        </div>

                        <div class="col-2 pt-3 text-end">
                            <button class="btn btn-primary" type="submit">Create Payroll</button>
                        </div>
                    </div>
                </form>
            </div>
            @foreach ($payroll_rates as $payroll_rate)
                @if (count($employees->where('currency_id',$payroll_rate->currency_id))>0 && $payroll->status =='Pending')
                    <div class="row">
                        <div class="col-md-3">
                            <h6>Submitted Units Under {{ $payroll_rate->currency->code }}</h6>
                            <div class="scrollable list-group">
                                <a href="javascript:void(0)" style="font-size: 10px" wire:click="setUnit({{ null }}, {{ null }})"
                                    class="list-group-item active d-flex align-items-center mb-1">
                                    <span>All Units</span>                            
                                    <span class="badge bg-info  ms-auto">{{ $unit_groups->count()}}</span></a>
                            @foreach ($unit_groups->where('currency_id',$payroll_rate->currency_id) as $unit)
                                <a href="javascript:void(0)" style="font-size: 10px" wire:click='setUnit({{ $unit->requestable_id }}, "{{ $unit->requestable_type }}")'
                                class="list-group-item active d-flex align-items-center mb-1">
                                <span>{{$unit->requestable->name.' '.$unit->total_amount }}</span>                            
                                <span class="badge bg-info  ms-auto">{{ $unit->submission_count}}</span></a>
                            @endforeach
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                @php
                                    $cur = $payroll_rate->currency->code ?? '';
                                @endphp
                                 <h6 class="text-success text-center">Submitted Employee Salary list Earning in {{ $payroll_rate->currency?->code }}</h6>
                                <table id="payrollTable" class="b-top-row" style="border-collapse:collapse;" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Unit</th>
                                            <th>Employee</th>
                                            <th>Month</th>
                                            <th class="text-end">
                                                Amount ({{ $cur }})
                                            </th>
                                            <th class="text-end">PAYE TAX({{ $cur }})</th>
                                            <th class="text-end">NSSF 10%({{ $cur }})</th>
                                            <th class="text-end">NSSF 5%({{ $cur }})</th>
                                            <th class="text-end">NSSF 15%({{ $cur }})</th>
                                            <th class="text-end">Net({{ $cur }})</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scrollable ">
                                        @forelse ($employees->where('currency_id',$payroll_rate->currency_id) as $key => $req_employee)
                                            <tr>
                                                <td>
                                                    {{ $req_employee->requestable->name }}
                                                </td>
                                                <td>
                                                    {{ $req_employee->employee->fullName ?? 'N/A' }} 
                                                </td>
                                                <td>
                                                    {{ $req_employee->month ?? 'N/A' }}/{{ $req_employee->year ?? 'N/A' }}
                                                </td>
                                                <td class="text-end">
                                                    @moneyFormat($req_employee->amount)
                                                    <input type="hidden" name="amount" value="{{ $req_employee->amount }} ">
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $baseAmount = $payroll_rate->rate *  $req_employee->amount;
                                                        $payebase = calculatePAYE($baseAmount);
                                                        $paye =  $payebase/$payroll_rate->rate;
                                                    @endphp
                                                    @moneyFormat($paye)
                                                    <input type="hidden" name="paye" value="{{ $paye }}">
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $employerNssf = getEmployeerNssf($req_employee->amount);
                                                    @endphp
                                                    @moneyFormat($employerNssf)
                                                    <input type="hidden" name="employeerNssf" value="{{ $employerNssf }}">
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $employeNssf = getEmployeeNssf($req_employee->amount);
                                                    @endphp
                                                    @moneyFormat($employeNssf)
                                                    <input type="hidden" name="employeeNssf" value="{{ $employeNssf }}">
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $totalNssf = $employeNssf + $employerNssf;
                                                    @endphp
                                                    @moneyFormat($totalNssf)
                                                    <input type="hidden" name="totalNssf" value="{{ $totalNssf }}">
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $totalDeduction = $employeNssf + $paye;
                                                        $netSalary = $req_employee->amount - $totalDeduction;
                                                    @endphp
                                                    @moneyFormat($netSalary)
                                                    <input type="hidden" name="netIncome" value="{{ $netSalary }}">
                                                </td>
                                                <td class="text-end">
                                                    <a href="javascript:void(0)" wire:click="addEmployee({{ $payroll_rate->id }}, {{ $req_employee->id }})"
                                                    class="badge bg-success  align-items-center">
                                                    +</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="btop">
                                                <td colspan="8" class="text-center text-danger">No entries yet</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <button wire:click="addAllEmployees({{ $payroll_rate->id }})" class="btn btn-primary btn-xs float-end m-2">Add All {{ $cur }} Employee salaries to payroll</button>
                            </div> 
                        </div>
                    </div>               
                @endif
                <div class="card-body">
                    <div class="tab-content">
                        @php
                            $cur = $baseCurrency->code ?? 'UGX';
                        @endphp
                        <h6 class="text-success text-center">Generated Empoyee Payroll list for {{ $payroll_rate->currency?->code }} @ {{ $payroll_rate->rate }} rate</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable"
                                style="font-size: 9.5px">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Employee</th>
                                        <th>Gross({{ $payroll_rate->currency?->code }})</th>
                                        <th>Gross({{ $cur }})</th>
                                        <th>PAYE TAX({{ $cur }})</th>
                                        <th>NSSF 10%({{ $cur }})</th>
                                        <th>NSSF 5%({{ $cur }})</th>
                                        <th>NSSF 15%({{ $cur }})</th>
                                        <th>Net({{ $cur }})</th>
                                        <th>Net({{ $payroll_rate->currency?->code }})</th>
                                        <th>Gross + NSSF 10%({{ $cur }})</th>
                                        <th>Gross + NSSF 10%({{ $payroll_rate->currency?->code }})</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payroll_employees->where('currency_id',$payroll_rate->currency_id) as $key => $emp_payroll)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $emp_payroll->employee->fullName }}</td>
                                            <td class="text-end">@moneyFormat($emp_payroll->salary)</td>
                                            <td class="text-end">@moneyFormat($emp_payroll->base_salary)</td>
                                            <td class="text-end">
                                                @php
                                                    $paye = calculatePAYE($emp_payroll->base_salary);
                                                @endphp
                                                @moneyFormat($emp_payroll->paye)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $employerNssf = getEmployeerNssf($emp_payroll->base_salary);
                                                @endphp
                                                @moneyFormat($emp_payroll->emp_nssf)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $employeNssf = getEmployeeNssf($emp_payroll->base_salary);
                                                @endphp
                                                @moneyFormat($emp_payroll->worker_nssf)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $totalNssf = $employeNssf + $employerNssf;
                                                @endphp
                                                @moneyFormat($totalNssf)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $totalDeduction = $emp_payroll->worker_nssf + $emp_payroll->paye;
                                                    $netSalary = $emp_payroll->base_salary - $totalDeduction;
                                                @endphp
                                                @moneyFormat($netSalary)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $deductionForeign = $totalDeduction/$payroll_rate->rate;
                                                    $netSalaryForeign = $emp_payroll->salary - $deductionForeign;
                                                @endphp
                                                @moneyFormat($netSalaryForeign)
                                            </td>
    
                                            <td class="text-end">
                                                @php
                                                    $grossSalary = $emp_payroll->base_salary + $emp_payroll->emp_nssf;
                                                @endphp
                                                @moneyFormat($grossSalary)
                                            </td>
                                            <td class="text-end">
                                                @php
                                                    $employerNssfForegine = $emp_payroll->emp_nssf/$payroll_rate->rate;
                                                    $grossSalaryForeign = $emp_payroll->salary - $employerNssfForegine;
                                                @endphp
                                                @moneyFormat($grossSalaryForeign)
                                            </td>
                                            <td class="table-action">
                                                <a href="{{ route('finance-pay_slip', $emp_payroll->id) }}"
                                                    target="_blank" class="text-primary" title="view {{ $emp_payroll->employee->fullName }} payslip">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <a href="{{ route('finance-pay_slip', $emp_payroll->id) }}"
                                                    target="_blank" class="text-info" title="view {{ $emp_payroll->employee->fullName }} detailed">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if ($emp_payroll->status =='Pending')                                                    
                                                    <a href="javascript:void()" title="remove {{ $emp_payroll->employee->fullName }} from payroll" class="text-danger"
                                                        wire:click='removeEmployee({{ $emp_payroll->id }})'>
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#markPaid" wire:click="markAsPaid({{ $emp_payroll->id }}, 'Single')"
                                                    class="text-success" title="mark {{ $emp_payroll->employee->fullName }} as paid">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                    <a href="javascript:void()" data-bs-toggle="modal" data-bs-target="#markPaid" wire:click="markAsPaid({{ $payroll_rate->id }}, 'PayrollRate')"
                        class="text-success m-2 btn-xs btn btn-outline-success float-end" title="mark {{ $payroll_rate->currency->code }} as paid">
                            <i class="fa fa-check"></i>Mark All {{ $payroll_rate->currency->code }} salaries as paid
                    </a>
                </div> <!-- end card body-->
            @endforeach
        </div>
        @if ($payroll->status =='Pending')            
            <button wire:click='markPayrollComplete' class="btn-xs btn btn-outline-success">Mark as complete</button>
        @endif
    </div>
    @include('livewire.finance.payroll.inc.payement-ref')
    @push('scripts')
        <script>
            window.addEventListener('close-modal', event => {
                $('#markPaid').modal('hide');
                $('#delete_modal').modal('hide');
            });
            window.addEventListener('delete-modal', event => {
                $('#delete_modal').modal('show');
            });
        </script>
    @endpush
</div>
