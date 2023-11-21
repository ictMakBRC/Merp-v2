@if (Auth::user()->hasPermission(['access_finance_module']))
    <div id="financeManagement"
        class="main-icon-menu-pane tab-pane {{ request()->segment(1) == 'finance' ? 'active menuitem-active' : '' }}"
        role="tabpanel" aria-labelledby="apps-tab">
        <div class="title-box">
            <h6 class="menu-title">Finance</h6>
        </div>

        <div class="collapse navbar-collapse" id="sidebarCollapse">
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('finance-dashboard') }}">{{ __('public.dashboard') }}</a>
                </li>
                <!--end nav-item-->
                @if (Auth::user()->hasPermission(['access_accounting']))
                    <li class="nav-item">
                        <a class="nav-link" href="#accounting" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="accounting">
                            Accounting
                        </a>
                        <div class="collapse " id="accounting">
                            <ul class="nav flex-column">
                                @if (Auth::user()->hasPermission(['view_coa']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-chart_of_accounts') }}" class="nav-link ">Chart Of
                                            Accounts</a>
                                    </li>
                                @endif
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_cash_flows']))
                                    <li class="nav-item">
                                        <a href="hh-reports.html" class="nav-link ">Cashflow</a>
                                    </li>
                                @endif
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_journal_entry']))
                                    <li class="nav-item">
                                        <a href="jenrty-reports.html" class="nav-link ">Journal Entries</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['access_finance_module']))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('finance-invoices') }}">{{ __('Invoices') }}</a>
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_all_ledger']) || Auth::user()->hasPermission(['view_department_ledger']))
                    <!--end nav-->
                    <li class="nav-item">
                        <a class="nav-link" href="#ledger" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="ledger">
                            Ledger
                        </a>
                        <div class="collapse " id="ledger">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_department_ledger']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-ledger_accounts') }}" class="nav-link ">All
                                            Departments</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_department_ledgerh']))
                                    <li class="nav-item">
                                        <a href="analytics-reports.html" class="nav-link ">My Department</a>
                                    </li>
                                @endif
                                
                                @if (Auth::user()->hasPermission(['view_department_ledger']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-banks') }}" class="nav-link ">Banks</a>
                                    </li>
                                @endif
                            </ul>

                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_department_budget']) ||
                        Auth::user()->hasPermission(['view_organization_budget']))
                    <li class="nav-item {{ request()->segment(3) == 'lists' ? 'menuitem-active' : '' }}">
                        <a class="nav-link" href="#listing" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="listing">
                            Lists
                        </a>
                        <div class="collapse " id="listing">
                            <ul class="nav flex-column">
                                <!--end nav-item-->
                                @if (Auth::user()->hasPermission(['view_organization_budget']))
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
                @if (Auth::user()->hasPermission(['view_department_budget']) ||
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
                                        <a href="{{ route('finance-budgets') }}" class="nav-link ">Unit Budgets</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-main_budget') }}" class="nav-link ">Main
                                            Budgets</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_organization_budget']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-budgets') }}" class="nav-link ">My Dpt Budgets</a>
                                    </li>
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                @if (Auth::user()->hasPermission(['view_all_transactions']) ||
                        Auth::user()->hasPermission(['view_department_transaction']))
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
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('finance-transfers', 'all') }}"
                                            class="nav-link ">Transfers</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route('finance-expenses', 'all') }}"
                                            class="nav-link ">Expenses</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_department_transaction']))
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
                    </li>
                @endif
                
                    {{-- //======================= --}}
                    @if (Auth::user()->hasPermission(['view_all_transactions']) ||
                    Auth::user()->hasPermission(['view_department_transaction']))
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
                                            <a href="{{ route('finance-payroll_list') }}"
                                                class="nav-link ">Main Payrolls</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('finance-payroll_unit_list') }}"
                                                class="nav-link ">Unit Payrolls</a>
                                        </li>
                                    @endif
                                </ul>
                                <!--end nav-->
                            </div>
                            <!--end sidebarAnalytics-->
                        </li>
                    @endif

                @if (Auth::user()->hasPermission(['view_all_transactions']) ||
                        Auth::user()->hasPermission(['view_department_transaction']))
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
                                        <a href="{{ route('finance-requests', 'all') }}" class="nav-link ">Payment
                                            Requests</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-requests_internal', 'all') }}"
                                            class="nav-link ">Internal Transfer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('finance-requests', 'incoming') }}"
                                            class="nav-link ">Incoming</a>
                                    </li>
                                @endif
                                @if (Auth::user()->hasPermission(['view_department_transaction']))
                                @endif
                            </ul>
                            <!--end nav-->
                        </div>
                        <!--end sidebarAnalytics-->
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
                                @if (Auth::user()->hasPermission(['view_customers']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-customers') }}" class="nav-link ">Customers</a>
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
                                @endif
                                {{-- @if (Auth::user()->hasPermission(['finance-services'])) --}}
                                <li class="nav-item">
                                    <a href="{{ route('finance-req_settings') }}" class="nav-link ">Positions</a>
                                </li>
                                <!--end nav-item-->
                                {{-- @endif --}}
                                @if (Auth::user()->hasPermission(['view_services']))
                                    <li class="nav-item">
                                        <a href="{{ route('finance-categories') }}" class="nav-link ">Service
                                            Categories</a>
                                    </li>
                                    <!--end nav-item-->
                                    <li class="nav-item">
                                        <a href="{{ route('finance-services') }}" class="nav-link ">Services</a>
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
