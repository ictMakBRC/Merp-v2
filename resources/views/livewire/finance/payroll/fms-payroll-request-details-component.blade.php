<div>
    <!-- resources/views/livewire/payroll-component.blade.php -->
    
    @include('livewire.finance.requests.inc.request-header')
<div>
    <h2>Employee Payroll ( @moneyFormat($totalAmount))</h2>

    <form wire:submit.prevent="generatePayroll">
        <table class="table table-sm">
            <thead>
                <th>#</th>
                <th>Employee</th>
                <th>Contract Salary</th>
                <th>Contract Start Date</th>
                <th>Contract End Date</th>
                <th>Action</th>
            </thead>
        @foreach($employees as $key=> $employee)
        @if($entry == 'Project')
            <tr>                
                <td>{{ $key+1 }}</td>
                <td> 
                    {{ $employee->employee->fullName??'' }}
                </td>
                <td> @moneyFormat($employee->gross_salary??0)</td>
                <td>{{ $employee->start_date }}</td>
                <td>{{ $employee->end_date }}</td>
                <td>
                    <div class="form-check form-switch form-switch-pimary">
                        <input class="form-check-input" type="checkbox" id="selectedEmployees.{{ $employee->employee_id }}" wire:model="selectedEmployees.{{ $employee->id }}">                       
                    </div>
                </td>
            </tr>
        @elseif($entry == 'Department')
            <tr>                
                <td>{{ $key+1 }}</td>
                <td> 
                    <b>{{ $employee->fullName }}</b>
                </td>
                <td> @moneyFormat($employee->officialContract->gross_salary??0)</td>
                <td>{{ $employee->officialContract?->start_date }}</td>
                <td>{{ $employee->officialContract?->end_date }}</td>
                <td>
                    <div class="form-check form-switch form-switch-pimary">
                        <input class="form-check-input" type="checkbox" id="selectedEmployees.{{ $employee->id }}" wire:model="selectedEmployees.{{ $employee->id }}">                       
                    </div>
                </td>
            </tr>
        @endif
        @endforeach
        </table>
        <button class="btn btn-success float-end" type="submit">Generate Payroll</button>
    </form>
    <br>
    <hr>
    
    <form class="m-2" wire:submit.prevent="saveEmployee({{ $request_data->id }})">
        <div class="row">
            <div class="col-md-4">
                <label for="expenditure">Employee Name:</label>
                <select name="employee_id" class="form-select" id="employee_id" wire:model='employee_id'>
                    <option value="">Select Employee</option>
                    @if($entry=='Project')
                    @foreach ($employees as $projectEmployee)
                        <option value="{{ $projectEmployee->employee_id }}">{{ $projectEmployee->employee->fullName }}</option>
                    @endforeach
                    @elseif($entry == 'Department')
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                        @endforeach
                    @endif
                </select>
                @error('employee_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <label for="month">Month:</label>
                <select class="form-select" wire:model="month" id="month">
                    <option value="">Select</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}</option>
                    @endfor
                </select>
                @error('month')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <label  for="year">Year:</label>
                <select class="form-select" wire:model="year" id="year">
                    <option value="">Select</option>
                    @for ($i = date('Y'); $i >= (date('Y') - 10); $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                @error('year')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
                @error('selectedEmployee')
                <div class="text-danger text-small">{{ $message }}</div>
            @enderror
            </div>                        

            <div class="col">
                <label for="amount">Salary ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                <input type="number"  required class="form-control"
                    wire:model="amount">
                @error('amount')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-2 pt-3 text-end">
                <button class="btn btn-primary" type="submit">Add Employee</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @if ($selectedEmployee)                                    
                    @if($this->entry == 'Project')
                    <table class="table">
                        <tr>
                            <td> <b> Contract Salary: </b> @moneyFormat($selectedEmployee->gross_salary??0)</td>
                            <td><b> Contract Start Date: </b> {{ $selectedEmployee->start_date }}</td>
                            <td><b> Contract End Date:</b> {{ $selectedEmployee->end_date }}</td>
                        </tr>
                    </table>
                    @elseif($entry == 'Department')
                    <table class="table">
                        <tr>
                            <td><b> Contract Salary: </b> @moneyFormat($selectedEmployee->gross_salary??0)</td>
                            <td><b> Contract Start Date: </b> {{ $selectedEmployee?->start_date??'' }}</td>
                            <td><b> Contract End Date: </b>{{ $selectedEmployee?->end_date??'' }}</td>
                        </tr>
                    </table>
                    @endif
                @endif
            </div>
        </div>
    </form>
    @php
        $cur = $request_data->currency->code??'';
    @endphp
    <table id="payrollTable" class="b-top-row" style="border-collapse:collapse;" width="100%" cellspacing="0">
        <thead>                            
            <tr>
                <th>
                    Employee
                </th>
                <th>
                    Month
                </th>
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
        <tbody>
            @forelse ($req_employees as $req_employee)
                <tr>
                    <td>
                        {{ $req_employee->employee->fullName ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $req_employee->month ?? 'N/A' }}/{{ $req_employee->year ?? 'N/A' }}
                    </td>
                    <td class="text-end">
                        @moneyFormat($req_employee->amount)
                        <input type="hidden" name="amount" value="{{ $req_employee->amount}} ">
                    </td>
                    <td class="text-end">
                        @php
                            $baseAmount  = getCurrencyRate($request_data->currency_id, 'base', $req_employee->amount);
                            $payebase = calculatePAYE($baseAmount);
                            $paye = getCurrencyRate($request_data->currency_id, 'foreign', $payebase);
                        @endphp
                        @moneyFormat($paye)       
                        <input type="hidden" name="paye" value="{{ $paye}}">                                 
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
                        {{-- @php
                            $grossSalary = $req_employee->amount + $employerNssf;
                        @endphp
                        @moneyFormat($grossSalary)        --}}
                        
                        <a href="javascript:void(0)" wire:click="deleteRecord('{{ $req_employee->id }}')"
                            class="text-danger">
                            <i class="fa fa-trash"></i>
                        </a>                                 
                    </td>
                </tr>
            @empty
                <tr class="btop">
                    <td colspan="8" class="text-center text-danger">No entries yet</td>
                </tr>
            @endforelse
            <footer>                            
                <tr class="b-top-row">
                    <th colspan="2">
                        Total
                    </th>
                    <th class="text-end">
                        <p id="totalAmount"></p>
                    </th>
                    <th class="text-end">
                        <p id="totalPaye"></p>
                    </th>
                    <th class="text-end"><p id="totalEmployeerNssf"></p></th>
                    <th class="text-end"><p id="totalEmployeeNssf"></p></th>
                    <th class="text-end"><p id="totalNssf"></p></th>
                    <th class="text-end"><p id="totalNet"></p></th>
                    {{-- <th class="text-end">Gross + NSSF 10%({{ $cur }})</th> --}}
                </tr>
            </thead>
        </tbody>
    </table>
</div>
<button class="btn btn-success float-end" wire:click='submitRequest'>Preview & Submit</button>
<div>
</div>
{{-- @push('scripts') --}}
<script type="text/javascript">

    window.sumInputs = function(columnName, totalId) {
        var inputs = document.getElementsByName(columnName),
            sum = 0;

        for (var i = 0; i < inputs.length; i++) {
            var ip = inputs[i];
            sum += parseFloat(ip.value) || 0;
        }

        var total = sum.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        document.getElementById(totalId).innerHTML = total;
    }

    sumInputs('amount', 'totalAmount');
    sumInputs('paye', 'totalPaye');
    sumInputs('employeerNssf', 'totalEmployeerNssf');
    sumInputs('employeeNssf', 'totalEmployeeNssf');
    sumInputs('totalNssf', 'totalNssf');
    sumInputs('netIncome', 'totalNet');
</script>
{{-- @endpush --}}
</div>
