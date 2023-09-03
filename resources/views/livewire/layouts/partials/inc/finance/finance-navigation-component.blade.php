<div id="financeManagement" class="main-icon-menu-pane tab-pane {{ request()->segment(1) == 'finance' ? 'active menuitem-active' : '' }}" role="tabpanel" aria-labelledby="apps-tab">
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
            <li class="nav-item">
                <a class="nav-link" href="#accounting" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="accounting">
                    Accounting
                </a>
                <div class="collapse " id="accounting">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('finance-chart_of_accounts') }}" class="nav-link ">Chart Of Accounts</a>
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Cashflow</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('finance-invoices') }}">{{ __('Invoices') }}</a>
            </li>
            <!--end nav-->      <!--end nav-item-->
            <li class="nav-item">
                <a class="nav-link" href="#ledger" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="ledger">
                    Ledger
                </a>
                <div class="collapse " id="ledger">
                    <ul class="nav flex-column">
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('finance-ledger_accounts')}}" class="nav-link ">All accouts</a>
                        </li>
                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Deparment Budget</a>
                        </li>
                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Org. Main Budget</a>
                        </li>
                    </ul>

                    <!--end nav-->
                </div>
                <!--end sidebarAnalytics-->
            </li>
            <!--end nav-item-->
            <li class="nav-item {{ request()->segment(3) == 'budgets' ? 'menuitem-active' : '' }}">
                <a class="nav-link" href="#budgeting" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="budgeting">
                    Budgeting
                </a>
                <div class="collapse " id="budgeting">
                    <ul class="nav flex-column">
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('finance-budgets')}}" class="nav-link ">All Budgets</a>
                        </li>
                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Deparment Budget</a>
                        </li>
                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Org. Main Budget</a>
                        </li>
                    </ul>

                    <!--end nav-->
                </div>
                <!--end sidebarAnalytics-->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarAnalytics">
                    Settings
                </a>
                <div class="collapse " id="sidebarAnalytics">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('finance-chart_of_account_types') }}" class="nav-link ">Account Types</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('finance-chart_of_account_sub_types') }}" class="nav-link ">Accout
                                Subtypes</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('finance-customers') }}" class="nav-link ">Customers</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('finance-currencies') }}" class="nav-link ">Currencies</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('finance-categories') }}" class="nav-link ">Service Categories</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('finance-services') }}" class="nav-link ">Services</a>
                        </li>
                    </ul>
                    <!--end nav-->
                </div>
                <!--end sidebarAnalytics-->
            </li>
            <!--end nav-item-->
        </ul>
        <!--end navbar-nav--->
    </div>
    <!--end sidebarCollapse-->
</div><!-- end finance -->
