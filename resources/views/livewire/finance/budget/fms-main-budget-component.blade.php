<div>
    <style>
        .num {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            font-size: 14px;
            padding: 1px 2px;
            text-align: right;
            float: right;
            right: 0;
        }
    </style>
    @include('livewire.partials.brc-header')
    <h3 class="text-center">Mak BRC BUDGET ({{ $baseCurrency->code ?? 'UGH' }}) for FY
        {{ $financialYear->start_date . ' : ' . $financialYear->end_date }}</h3>
    <div class="table-responsive">
        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
            <tbody>
                @php
                    $totalRevenue = 0;
                @endphp
                <tr>
                    <td>

                        <div class="accordion accordion-flush" id="accordionRevenue">
                            @foreach ($main_budgets as $chartAccountId => $chartAccountData)
                                @if ($chartAccountData['type'] === 'Revenue')
                                    <div class="card">
                                        <a class=" collapsed" type="button" data-bs-toggle="collapse"
                                            wire:click="getDepartMentBudgets({{ $chartAccountData['chartOfAccount']['id'] }})"
                                            data-bs-target="#coa_{{ $chartAccountData['chartOfAccount']['id'] }}"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            <div class="card-header" role="tab" id="questionOne">
                                                <h5 class="accordion-header card-title" id="flush-headingOne">
                                                    {{ $chartAccountData['chartOfAccount']['name'] }}
                                                    <span class="num">@moneyFormat($chartAccountData['amount'])</span>
                                                </h5>
                                            </div>
                                        </a>
                                        <div wire:ignore.self id="coa_{{ $chartAccountData['chartOfAccount']['id'] }}"
                                            class="accordion-collapse collapse card-bodyg"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionRevenue">
                                            <div class="accordion-body ml-4">
                                                @if ($departMentBudgets || $projecttBudgets)
                                                    <div class="table-responsive-sm pt-2">
                                                        <table
                                                            class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Department</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $number = 1; @endphp
                                                                @foreach ($departMentBudgets as $dptBudget)
                                                                    <tr>
                                                                        <td>{{ $number }}</td>
                                                                        <td>{{ $dptBudget['department'] }}</td>
                                                                        <td class="text-end">@moneyFormat($dptBudget['amount'])</td>

                                                                    </tr>
                                                                    @php $number++; @endphp
                                                                @endforeach
                                                                @foreach ($projecttBudgets as $projectBudget)
                                                                    <tr>
                                                                        <td>{{ $number }}</td>
                                                                        <td>{{ $projectBudget['project'] }}</td>
                                                                        <td class="float-end">@moneyFormat($projectBudget['project_amount'])</td>

                                                                    </tr>
                                                                    @php $number++; @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end preview-->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $totalRevenue += $chartAccountData['amount'];
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>
                        <h4 class="text-end">Total Revenue: @moneyFormat($totalRevenue)</<i class="fa fa-html5"
                                aria-hidden="true"></i></h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end preview-->

    <div class="table-responsive">
        <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
            <tbody>
                @php
                    $totalExpenses = 0;
                @endphp
                <tr>
                    <td>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @foreach ($main_budgets as $chartAccountId => $chartAccountData)
                                @if ($chartAccountData['type'] === 'Expense')
                                    <div class="card">

                                        <a class="collapsed" type="button" data-bs-toggle="collapse"
                                            wire:click="getDepartMentBudgets({{ $chartAccountData['chartOfAccount']['id'] }})"
                                            data-bs-target="#coa_{{ $chartAccountData['chartOfAccount']['id'] }}"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            <div class="card-header" role="tab" id="questionOne">
                                                <h5 class="accordion-header card-title" id="flush-headingOne">
                                                    {{ $chartAccountData['chartOfAccount']['name'] }}
                                                    <span class="num">@moneyFormat($chartAccountData['amount'])</span>
                                                </h5>
                                            </div>
                                        </a>
                                        <div wire:ignore.self id="coa_{{ $chartAccountData['chartOfAccount']['id'] }}"
                                            class="accordion-collapse collapse card-bodyg"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body ml-4">
                                                @if ($departMentBudgets || $projecttBudgets)
                                                    <div class="table-responsive-sm pt-2">
                                                        <table
                                                            class="table table-sm table-bordered table-striped mb-0 w-100 sortable">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>No.</th>
                                                                    <th>Department</th>
                                                                    <th class="text-end">Amount</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php $number = 1; @endphp
                                                                @foreach ($departMentBudgets as $dptBudget)
                                                                    <tr>
                                                                        <td>{{ $number }}</td>
                                                                        <td>{{ $dptBudget['department'] }}</td>
                                                                        <td class="text-end">@moneyFormat($dptBudget['amount'])</td>

                                                                    </tr>
                                                                    @php $number++; @endphp
                                                                @endforeach
                                                                @foreach ($projecttBudgets as $projectBudget)
                                                                    <tr>
                                                                        <td>{{ $number }}</td>
                                                                        <td>{{ $projectBudget['project'] }}</td>
                                                                        <td class="float-end">@moneyFormat($projectBudget['project_amount'])</td>

                                                                    </tr>
                                                                    @php $number++; @endphp
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end preview-->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $totalExpenses += $chartAccountData['amount'];
                                    @endphp
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4 class="text-end">Total Expenses: @moneyFormat($totalExpenses)</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row text-center">
        @php
            $difference = $totalRevenue - $totalExpenses;
        @endphp
        <div class="col-4">
            <h5>Revenue: @moneyFormat($totalRevenue)</h5>
        </div>
        <div class="col-4">
            <h5>Expenditure: @moneyFormat($totalExpenses)</h5>
        </div>
        <div class="col-4">
            <h5 @if ($difference < 0) class="text-danger" @endif>Difference: @moneyFormat($difference)</h5>
        </div>
    </div>

    @if ($budget_data != null)
        @include('livewire.finance.budget.inc.preview-budget')
    @endif
</div>
