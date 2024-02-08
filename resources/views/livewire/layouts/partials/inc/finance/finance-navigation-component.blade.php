@if (Auth::user()->hasPermission(['access_finance_module']))
    <div id="financeManagement"
        class="main-icon-menu-pane tab-pane {{ request()->segment(1) == 'finance' ? 'active menuitem-active' : '' }}"
        role="tabpanel" aria-labelledby="apps-tab">
        <div class="title-box">
            <h6 class="menu-title">Finance</h6>
            @if (Session::has('unit'))                
                <li class="side-nav-item">Current Unit: {{ Session::get('unit') }} <span wire:click="checkOut" class="badge bg-primary pill float-end ms-auto"><i class="mdi mdi-lock-outline me-1"></i></span></li>
            @endif
        </div>
        <div class="collapse navbar-collapse" id="sidebarCollapse">
            <!-- Navigation -->
            <ul class="navbar-nav">
                {{-- @if (Auth::user()->hasPermission(['view_main_dashboard'])) --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('finance-dashboard') }}">{{ __('public.dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('finance-md_dashboard') }}">{{ __('MD Dashboard') }}</a>
                </li>
               {{--  @endif --}}
               {{-- -@if (Auth::user()->hasPermission(['view_unit_dashboard']))--}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('finance-dashboard_unit',[$unit_id, $unit_type]) }}">{{ __('Unit dashboard') }}</a>
                    </li>
                {{-- @endif--}}
                <!--end nav-item-->
                @if (Auth::user()->hasPermission(['access_accounting']))
                    <li class="nav-item">
                        <a class="nav-link" href="#accounting" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="accounting">
                            Accounting
                        </a>
                        <div class="collapse " id="accounting">
                            <ul class="nav flex-column">
                                @if (Auth::user()->hasPermission(['view_charts_of_account']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-chart_of_accounts') }}" class="nav-link ">Chart Of
                                            Accounts</a>
                                    </li>
                                @endif
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_cash_flows']))
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ">Cashflow</a>
                                    </li>
                                @endif
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_journal_entry']))
                                    <li class="nav-item">
                                        <a href="#" class="nav-link ">Journal Entries</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_unit_invoices']))
                    <li class="nav-item {{ request()->segment(3) == 'payroll' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#invoice" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="payroll">
                            Invoices
                        </a>
                        <div class="collapse " id="invoice">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_all_transactions']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-invoices','all') }}"
                                            class="nav-link ">All</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['create_salary_request']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-invoices_in') }}"
                                            class="nav-link ">Incoming</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-invoices_out') }}"
                                            class="nav-link ">Outgoing</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-unit_services') }}" class="nav-link ">Unit Services</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_all_ledger']) || Auth::user()->hasPermission(['view_unit_ledger']))
                    <!--end nav-->
                    <li class="nav-item">
                        <a class="nav-link" href="#ledger" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="ledger">
                            Ledger
                        </a>
                        <div class="collapse " id="ledger">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_all_ledger']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-ledger_accounts','all') }}" class="nav-link ">All
                                            Units</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-general_ledger') }}" class="nav-link ">General
                                            Ledger</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-banks') }}" class="nav-link ">Bank Accts</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_unit_ledger']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-ledger_accounts', $unit_type) }}" class="nav-link ">Unit Ledger</a>
                                    </li>
                                @endif
                                
                            </ul>

                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['manage_projects']) )
                    <li class="nav-item {{ request()->segment(3) == 'lists' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#listing" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="listing">
                            Lists
                        </a>
                        <div class="collapse " id="listing">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['manage_projects']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-department_list') }}" class="nav-link ">Departments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-project_list') }}" class="nav-link ">Projects</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_unit_budget']) ||
                        Auth::user()->hasPermission(['view_organization_budget']))
                    <li class="nav-item {{ request()->segment(3) == 'budgets' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#budgeting" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="budgeting">
                            Budgeting
                        </a>
                        <div class="collapse " id="budgeting">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_organization_budget']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-budgets','all') }}" class="nav-link ">All Budgets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-main_budget') }}" class="nav-link ">Main
                                            Budgets</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_unit_budget']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-budgets','unit') }}" class="nav-link ">Unit Budgets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-unit_lines') }}" class="nav-link ">Unit Lines</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_all_transactions']) ||
                        Auth::user()->hasPermission(['view_unit_transactions']))
                    <li class="nav-item {{ request()->segment(3) == 'transctions' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#transctions" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="transctions">
                            Transactions
                        </a>
                        <div class="collapse " id="transctions">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_all_transactions']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-transactions', 'all') }}" class="nav-link ">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-revenues', 'all') }}"
                                            class="nav-link ">Income</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-expenses', 'all') }}"
                                            class="nav-link ">Expenses</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_unit_transactions']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-transactions', 'unit') }}" class="nav-link ">History</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                
                    {{-- //======================= --}}
                    @if (Auth::user()->hasPermission(['view_all_transactions']) ||
                    Auth::user()->hasPermission(['create_salary_request'])|| Auth::user()->hasPermission(['view_unit_payroll']))
                        <li class="nav-item {{ request()->segment(3) == 'payroll' ? 'menuitem-active' : '' }}">
                            <a class="nav-link" href="#payroll" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="payroll">
                                Payroll
                            </a>
                            <div class="collapse " id="payroll">
                                <ul class="nav flex-column">
                                    <!--end nav-item-->
                                    @if (Auth::user()->hasPermission(['view_all_transactions']))
                                        <li class="nav-item">
                                            <a href="{{ route('finance-payroll_list','all') }}"
                                                class="nav-link ">Main Payrolls</a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->hasPermission(['view_unit_payroll']))
                                        <li class="nav-item">
                                            <a href="{{ route('finance-payroll_unit_list','unit') }}"
                                                class="nav-link ">Unit Payrolls</a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end nav-->
                            </div>
                            <!--end sidebarAnalytics-->
                        </li>
                    @endif

                @if (Auth::user()->hasPermission(['view_payment_requests']) ||
                        Auth::user()->hasPermission(['view_unit_request']))
                    <li class="nav-item {{ request()->segment(3) == 'requests' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#payemnt_requets" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="payemnt_requets">
                            Requests
                        </a>
                        <div class="collapse " id="payemnt_requets">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_all_transactions']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-requests', 'all') }}" class="nav-link ">All
                                            Requests</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('finance-requests_internal', 'all') }}"
                                            class="nav-link ">Internal Transfer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-requests', 'incoming') }}"
                                            class="nav-link ">Incoming</a>
                                    </li> --}}
                                @endif
                                @if (Auth::user()->hasPermission(['view_unit_request']))
                                <li class="nav-item">
                                    <a href="{{ route('finance-requests', 'unit') }}" class="nav-link ">Payment
                                        Requests</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('finance-requests_internal', 'unit') }}"
                                        class="nav-link ">Internal Transfer</a>
                                </li>
                                <li class="nav-item d-none">
                                    <a href="{{ route('finance-requests', 'incoming') }}"
                                        class="nav-link ">Incoming</a>
                                </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_customers']))
                    <li class="nav-link">
                        <a href="{{ route('finance-customers') }}" class="nav-link ">Customers</a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['access_finance_management_settings']))
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAnalytics">
                            Settings
                        </a>
                        <div class="collapse " id="sidebarAnalytics">
                            <ul class="nav flex-column">
                                @if (Auth::user()->hasPermission(['view_coa']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-chart_of_account_types') }}"
                                            class="nav-link ">Account Types</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="{{ route('finance-chart_of_account_sub_types') }}"
                                            class="nav-link ">Account
                                            Subtypes</a>
                                    </li>
                                    <!--end nav-item-->
                                @endif
                              
                                @if (Auth::user()->hasPermission(['view_currencies']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-currencies') }}" class="nav-link ">Currencies</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="{{ route('finance-currency_rates') }}" class="nav-link ">Ex Rates</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-institutions') }}" class="nav-link ">Institutions</a>
                                    </li>
                                @endif
                                {{-- @if (Auth::user()->hasPermission(['finance-services'])) --}}
                                <li class="nav-item">
                                    <a href="{{ route('finance-req_settings') }}" class="nav-link ">Positions</a>
                                </li>
                                <!--end nav-item-->
                                {{-- @endif --}}
                                @if (Auth::user()->hasPermission(['view_services']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-categories') }}" class="nav-link ">Reveune
                                            Sub-Types</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="{{ route('finance-services') }}" class="nav-link ">Revenues</a>
                                    </li>
                                    <!--end nav-item-->
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="{{ route('finance-unit_services') }}" class="nav-link ">Unit Revenues</a>
                                    </li>
                                    <!--end nav-item-->
                                @endif
                                @if (Auth::user()->hasPermission(['view_years']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-years') }}" class="nav-link ">Years</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                    <!--end nav-item-->
                @endif
            </ul>
            <!--end navbar-nav--->
        </div>
        <!--end sidebarCollapse-->
    </div><!-- end finance -->
@endif
