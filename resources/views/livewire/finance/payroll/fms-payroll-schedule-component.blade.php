<div>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
            <table class="table-striped text-info">
                <tr>
                    <td>Current Rates:</td>
                    @foreach ($currencies as $currency)
                        <td>{{ $currency->code.' Rate '. $currency->exchange_rate.' | ' }}</td>
                    @endforeach
                </tr>
            </table>
            </div>
        </div>
        <div class="col-md-3 mt-2">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2 position-relative mb-1">
                        <div class="input-group">
                            <input type="text" wire:model.debounce.300ms="searchEmployee"
                                class="form-control" placeholder="Search to add employees">
                            <a href="javascript: void(0)" data-bs-toggle="modal" data-bs-target="#addnew"
                                title="Add a new employee Meta data"
                                class="input-group-text bg-transparent "><i class="fa fa-plus"></i></a>                           
                        </div>
                    </form>

                    <div class="employee-content">
                        <div class="employee-navigation">
                            <div class="scrollable list-group list-group-flush">
                                @forelse ($employees as $key => $emp)
                                    <a href="javascript:void(0)" style="font-size: 10px"
                                        wire:click="addEmployee({{ $emp->id }})"
                                        class="list-group-item active d-flex align-items-center mb-1">
                                        <span>{{$emp->employee->fullName.' '.$emp->amount.' '.$emp->currency->code  }}  @  {{ $emp->requestable->name }}</span>
                                        
                                        <span class="badge bg-info  ms-auto">{{ $emp->month.'/'.$emp->year }}</span></a>

                                @empty
                                    <div class="card-body p-4 text-center">
                                        <h5 class="font-weight-bold">List empty ?</h5>
                                        <p>Dont'worry click on the button below to add employees.</p>
                                        <div class="mt-5"> <a href="javascript:;" data-bs-toggle="modal"
                                                data-bs-target="#addnew"
                                                class="btn btn-primary btn-sm px-md-5 radius-30">+ Employee
                                                Data</a>

                                        </div>
                                    </div>
                                @endforelse
                                
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
                
            <div class="card-body">
                <div class="tab-content">
                    <x-table-utilities>
                      
                    </x-table-utilities>
                    @php
                        $cur = $baseCurrency->code??'UGX';
                    @endphp
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped mb-0 w-100 sortable" style="font-size: 9.5px">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Employee</th>
                                    <th>Gross({{ $payroll->currency->code }})</th>
                                    <th>Gross({{ $cur }})</th>
                                    <th>PAYE TAX({{ $cur }})</th>
                                    <th>NSSF 10%({{ $cur }})</th>
                                    <th>NSSF 5%({{ $cur }})</th>
                                    <th>NSSF 15%({{ $cur }})</th>
                                    <th>Net({{ $cur }})</th>
                                    <th>Net({{ $payroll->currency->code }})</th>
                                    <th>Gross + NSSF 10%({{ $cur }})</th>
                                    <th>Gross + NSSF 10%({{ $payroll->currency->code }})</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payroll_employees as $key => $emp_payroll)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $emp_payroll->employee->fullName }}</td>
                                        <td class="text-end">@moneyFormat($emp_payroll->salary)</td>
                                        <td class="text-end">@moneyFormat($emp_payroll->base_salary)</td>
                                        <td class="text-end">
                                            @php
                                                $paye = calculatePAYE($emp_payroll->base_salary);
                                            @endphp
                                            @moneyFormat($paye)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $employerNssf = getEmployeerNssf($emp_payroll->base_salary);
                                            @endphp
                                            @moneyFormat($employerNssf)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $employeNssf = getEmployeeNssf($emp_payroll->base_salary);
                                            @endphp
                                            @moneyFormat($employeNssf)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $totalNssf = $employeNssf + $employerNssf;
                                            @endphp
                                            @moneyFormat($totalNssf)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $totalDeduction = $employeNssf + $paye;
                                                $netSalary = $emp_payroll->base_salary - $totalDeduction;
                                            @endphp
                                            @moneyFormat($netSalary)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $deductionForeign = getCurrencyRate($emp_payroll->currency_id, 'foreign', $totalDeduction );
                                                $netSalaryForeign = $emp_payroll->salary - $deductionForeign;
                                            @endphp
                                            @moneyFormat($netSalaryForeign)                                        
                                        </td>
                                        
                                        <td class="text-end">
                                            @php
                                                $grossSalary = $emp_payroll->base_salary + $employerNssf;
                                            @endphp
                                            @moneyFormat($grossSalary)                                        
                                        </td>
                                        <td class="text-end">
                                            @php
                                                $employerNssfForegine = getCurrencyRate($emp_payroll->currency_id, 'foreign', $employerNssf );
                                                $grossSalaryForeign = $emp_payroll->salary - $employerNssfForegine;
                                            @endphp
                                            @moneyFormat($grossSalaryForeign)                                        
                                        </td>
                                        <td class="table-action">
                                            <a href="javascript:void()" class="text-danger" wire:click='removeEmployee({{ $emp_payroll->id }})'>
                                                <i class="fa fa-trash"></i>
                                            </a>  
                                            <a href="{{ route('finance-pay_slip',$emp_payroll->id )}}" target="_blank" class="text-info" >
                                                <i class="fa fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
            </div> <!-- end card body-->
        </div>
    </div>
</div>
