<div id="inventoryManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Inventory</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('inventory-dashboard') }}">{{ __('public.dashboard') }}</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a class="nav-link" href="#item" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="item">
                    Items management
                </a>
                <div class="collapse " id="item">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('inventory-items') }}" class="nav-link ">Items List</a>
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item">
                            <a href="analytics-reports.html" class="nav-link ">Department Items</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarAnalytics">
                    Settings
                </a>
                <div class="collapse " id="sidebarAnalytics">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('inventory-stores') }}" class="nav-link ">Stores</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('inventory-sections') }}" class="nav-link ">Storage Sections</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('inventory-storage_bins') }}" class="nav-link ">Storage Bins</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('inventory-categories') }}" class="nav-link ">Categories</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('inventory-unit_of_measures') }}" class="nav-link ">Unit of Measures</a>
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
</div><!-- end inventory -->
