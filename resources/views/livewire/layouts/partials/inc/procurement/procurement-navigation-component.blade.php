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
            <!--end nav-item-->

            <li class="nav-item">
                <a class="nav-link" href="#procurementSideBar" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="procurementSideBar">
                    Settings
                </a>
                <div class="collapse " id="procurementSideBar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('manage-providers')}}" class="nav-link ">Providers/Suppliers</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('manage-subcategories')}}" class="nav-link ">Sectors & Categories</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
                <!--end procurementSideBar-->
            </li>
            <!--end nav-item-->
        </ul>
        <!--end navbar-nav--->
    </div>
    <!--end sidebarCollapse-->
</div><!-- end inventory -->
