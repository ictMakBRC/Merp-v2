<div id="procurementManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Procurement</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('procurement-dashboard') }}">{{ __('public.dashboard') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#procurementRequestsMenu" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="procurementRequestsMenu">
                    Requests
                </a>
                <div class="collapse " id="procurementRequestsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-request')}}" class="nav-link ">Department Panel</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-supervisor-panel')}}" class="nav-link ">Supervisor Panel</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-finance-panel')}}" class="nav-link ">Finance Panel</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-operations-panel')}}" class="nav-link ">Operations Panel</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-md-panel')}}" class="nav-link ">MD Panel</a>
                        </li>
  
                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-office-panel')}}" class="nav-link ">Procurement Panel</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="{{route('procurement-stores-panel')}}" class="nav-link ">Stores Panel</a>
                        </li>

                    </ul>

                </div>

            </li>
            <li class="nav-item">
                <a class="nav-link" href="#procurementSideBar" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="procurementSideBar">
                    Settings
                </a>
                <div class="collapse " id="procurementSideBar">
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{route('manage-providers')}}" class="nav-link ">Providers/Suppliers</a>
                        </li>
                       
                        <li class="nav-item mb-2">
                            <a href="{{route('manage-subcategories')}}" class="nav-link ">Sectors & Categories</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Procurement Categorisation</a>
                        </li>
                        
                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Procurement Methods</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Procurement Request Sources</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Contracts Committee</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Evaluation Committee</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Negotiation Committee</a>
                        </li>

                        <li class="nav-item mb-2">
                            <a href="#" class="nav-link ">Contracts Manager</a>
                        </li>
                       
                    </ul>
                    <!--end nav-->
                </div>
                <!--end procurementSideBar-->
            </li>

        </ul>

    </div>

</div>
