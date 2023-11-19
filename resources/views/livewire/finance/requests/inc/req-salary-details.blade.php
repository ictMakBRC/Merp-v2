  <div class="details">
                    <div class="header">
                        <h6>Details of the Request <span class="text-end float-end text-warning">Balance =
                                @moneyFormat($amountRemaining)</span></h6>
                    </div>

                    <form wire:submit.prevent="saveEmployee({{ $request_data->id }})">
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
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ \Carbon\Carbon::create(null, $i, 1)->format('F') }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label  for="year">Year:</label>
                                <select class="form-select" wire:model="year" id="year">
                                    @for ($i = date('Y'); $i >= (date('Y') - 10); $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>                        

                            <div class="col">
                                <label for="amount">Salary ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                                <input type="number"  max="{{ $amountRemaining }}" required class="form-control"
                                    wire:model="amount">
                                @error('amount')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2 pt-3 text-end">
                                <button class="btn btn-primary" type="submit">Save Item</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                @if ($selectedEmployee)                                    
                                    @if($this->entry = 'Project')
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
                                            <td><b> Contract Salary: </b> @moneyFormat($selectedEmployee->officialContract->gross_salary??0)</td>
                                            <td><b> Contract Start Date: </b> {{ $selectedEmployee->officialContract->start_date }}</td>
                                            <td><b> Contract End Date: </b>{{ $selectedEmployee->officialContract->end_date }}</td>
                                        </tr>
                                    </table>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </form>
                    <br>

                    <table class="b-top-row" style="border-collapse:collapse;" width="100%" cellspacing="0">
                        <thead>                            
                            <tr>
                                <th class="btop t-bold" width="149" rowspan="2" valign="top">
                                    Employee
                                </th>
                                <th class="btop t-bold" width="189" rowspan="2" valign="top">
                                    Month
                                </th>
                                <th class="btop t-bold" width="189" rowspan="2" valign="top">
                                    Year
                                </th>
                                <th class="btop t-bold text-center" width="234" colspan="2" valign="top">
                                    Amount (Currency)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($req_employees as $req_employee)
                                <tr>
                                    <td class="btop" width="149">
                                        {{ $req_employee->employee->fullName ?? 'N/A' }}
                                    </td>
                                    <td class="btop" width="189" valign="top">
                                        {{ $req_employee->month ?? 'N/A' }}
                                    </td>
                                    <td class="btop" width="189" valign="top">
                                        {{ $req_employee->year ?? 'N/A' }}
                                    </td>
                                    <td class="btop text-end" width="121">
                                        @moneyFormat($req_employee->amount)
                                        <a href="javascript:void(0)" wire:click="confirmDelete('{{ $req_employee->id }}')"
                                            class="text-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="btop">
                                    <td colspan="4" class="text-center text-danger">No entries yet</td>
                                </tr>
                            @endforelse

                            <tr>
                                <td class="btop t-bold" width="518" colspan="3" valign="top">
                                    Total
                                </td>
                                <td class="btop t-bold text-end">
                                    @moneyFormat($totalAmount)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>