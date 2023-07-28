<div>
    <div class="leftbar-tab-menu">
        <div class="main-icon-menu">
            <a href="{{ route('home') }}" class="logo logo-metrica d-block text-center">
                <span>
                    <img src="{{ asset('assets/images/logos/fav-icon.png') }}" alt="logo-small" class="logo-sm">
                </span>
            </a>
            <div class="main-icon-menu-body">
                <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                    <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard"
                            data-bs-trigger="hover">
                            <a href="#home" id="dashboard-tab" class="nav-link">
                                <i class="ti ti-smart-home menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Human Resource"
                            data-bs-trigger="hover">
                            <a href="#humanResourceManagement" id="humanResourceManagement-tab" class="nav-link">
                                <i class="ti ti-users menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Finance"
                            data-bs-trigger="hover">
                            <a href="#financeManagement" id="financeManagement-tab" class="nav-link">
                                <i class="ti ti-report-money menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Inventory Management" data-bs-trigger="hover">
                            <a href="#inventoryManagement" id="inventoryManagement-tab" class="nav-link">
                                <i class="ti ti-tallymarks menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Assets Management" data-bs-trigger="hover">
                            <a href="#assetsManagement" id="assetsManagement-tab" class="nav-link">
                                <i class="ti ti-transfer-in menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Procurement Management" data-bs-trigger="hover">
                            <a href="#procurementManagement" id="procurementManagement-tab" class="nav-link">
                                <i class="ti ti-truck-delivery menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right"
                            title="Documents Management" data-bs-trigger="hover">
                            <a href="#documentsManagement" id="documentsManagement-tab" class="nav-link">
                                <i class="ti ti-files menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="User Management"
                            data-bs-trigger="hover">
                            <a href="#userManagement" id="userManagement-tab" class="nav-link">
                                <i class="ti ti-user-plus menu-icon"></i>
                            </a>
                            <!--end nav-link-->
                        </li>
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div>
                <!--end /div-->
            </div>
            <!--end main-icon-menu-body-->
            {{-- <div class="pro-metrica-end">
                <a href="" class="profile">
                    <img src="assets/images/users/user-4.jpg" alt="profile-user" class="rounded-circle thumb-sm">
                </a>
            </div><!--end pro-metrica-end--> --}}
        </div>
        <!--end main-icon-menu-->

        <div class="main-menu-inner">
            <!-- LOGO -->
            <div class="topbar-left">
                <a href="{{ route('home') }}" class="logo">
                    <span>
                        <img src="{{ asset('assets/images/logos/merp-logo.png') }}" alt="logo-large"
                            class="logo-lg logo-dark">
                        <img src="{{ asset('assets/images/logos/merp-logo.png') }}" alt="logo-large"
                            class="logo-lg logo-light">
                    </span>
                </a>
                <!--end logo-->
            </div>
            <!--end topbar-left-->
            <!--end logo-->
            <div class="menu-body navbar-vertical tab-content" data-simplebar>
                <div id="home" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="dasboard-tab">
                    <div class="title-box">
                        <h6 class="menu-title">Home</h6>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Dashboard</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div><!-- end Dashboards -->

                <!--start human-resource -->
                <livewire:layouts.partials.inc.human-resource.human-resource-navigation-component />
                <!--end human-resource -->

                <!--start finance -->
                <livewire:layouts.partials.inc.finance.finance-navigation-component />
                <!--end finance -->

                <!--start inventory -->
                <livewire:layouts.partials.inc.inventory.inventory-navigation-component />
                <!--end inventory -->

                <!--start assets -->
                <livewire:layouts.partials.inc.assets.assets-navigation-component />
                <!--end assets -->

                <!--start procurement -->
                <livewire:layouts.partials.inc.procurement.procurement-navigation-component />
                <!--end procurement -->

                <!--start documents -->
                <livewire:layouts.partials.inc.documents.documents-navigation-component />
                <!--end documents -->

                <!--start user-management -->
                @include('livewire.layouts.partials.inc.user-management.user-mgt-nav')
                <!--end user-management -->

            </div>
            <!--end menu-body-->
        </div><!-- end main-menu-inner-->
    </div>
</div>
