<div id="documentsManagement"
    class="main-icon-menu-pane tab-pane {{ request()->segment(1) == 'documents' ? 'active menuitem-active' : '' }}"
    role="tabpanel" aria-labelledby="apps-tab">
    <div class="title-box">
        <h6 class="menu-title">Documents</h6>
    </div>

    <div class="collapse navbar-collapse" id="sidebarCollapse">
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('documents-dashboard') }}">{{ __('public.dashboard') }}</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item  {{ request()->segment(3) == 'requests' ? 'menuitem-active' : '' }}">
                <a class="nav-link" href="#docrequests" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="docrequests">
                    Requests
                </a>
                <div class="collapse " id="docrequests">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('documents-request.dashboard') }}" class="nav-link ">Dashboard</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('documents-request.out') }}" class="nav-link ">My Requests</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('documents-request.in') }}" class="nav-link ">Incoming Requests</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('documents-request.sent') }}" class="nav-link ">My Documents</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('documents-request.signed') }}" class="nav-link ">Signed Documents</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
                <!--end requests-->
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="sidebarAnalytics">
                    Settings
                </a>
                <div class="collapse " id="sidebarAnalytics">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="{{ route('documents-folders') }}" class="nav-link ">Folders</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a href="{{ route('documents-categories') }}" class="nav-link ">Categories</a>
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
</div><!-- end documents -->
