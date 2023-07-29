<div id="humanResourceManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Human Resource</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('human-resource-dashboard') }}">{{ __('public.dashboard') }}</a>
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarAnalytics">
                    Manage
                </a>
                <div class="collapse " id="sidebarAnalytics">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('human-resource-departments')}}" class="nav-link ">Departments</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('human-resource-stations')}}" class="nav-link ">Duty Stations</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('human-resource-designations')}}" class="nav-link ">Designations</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('human-resource-holidays')}}" class="nav-link ">Holidays</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('human-resource-offices')}}" class="nav-link ">Offices</a>
                        </li>
                        <!--end nav-item-->
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


