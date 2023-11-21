  <div class="details">
                    <div class="header">
                        <h6>Details of the Request <span class="text-end float-end text-warning">Balance =
                                @moneyFormat($amountRemaining)</span></h6>
                    </div>

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
                                    @moneyFormat($amountRemaining)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>