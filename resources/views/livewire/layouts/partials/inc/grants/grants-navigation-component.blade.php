<div id="grantsManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Grants and Projects</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">{{ __('public.dashboard') }}</a>
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a class="nav-link" href="{{ route('manage-grants') }}">{{ __('Grants') }}</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('manage-projects') }}">{{ __('Projects') }}</a>
            </li>
            <!--end nav-item-->

            {{-- <li class="nav-item">
                <a class="nav-link" href="#assetSettings" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="assetSettings">
                    Settings
                </a>
                <div class="collapse " id="assetSettings">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{route('asset-classification')}}" class="nav-link ">Classifications</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{route('asset-category')}}" class="nav-link ">Categories</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
                <!--end assetSettings-->
            </li> --}}
            <!--end nav-item-->
        </ul>
        <!--end navbar-nav--->
    </div>
    <!--end sidebarCollapse-->
</div><!-- end assets -->
