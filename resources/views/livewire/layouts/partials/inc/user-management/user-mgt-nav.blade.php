<div id="userManagement" class="main-icon-menu-pane tab-pane" role="tabpanel" aria-labelledby="dasboard-tab">
    <div class="title-box">
        <h6 class="menu-title">{{ __('user-mgt.user_management') }}</h6>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('usermanagement') }}">{{ __('user-mgt.users') }}</a>
        </li>
        <!--end nav-item-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user-roles.index') }}">{{ __('user-mgt.roles') }}</a>
        </li>
        <!--end nav-item-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user-permissions.index') }}">{{ __('user-mgt.permissions') }}</a>
        </li>
        <!--end nav-item-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('user-roles-assignment.index') }}">{{ __('user-mgt.role_assignment') }}</a>
        </li>
        <!--end nav-item-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logs') }}">{{ __('user-mgt.login_activity') }}</a>
        </li>
        <!--end nav-item-->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('useractivity') }}">{{ __('user-mgt.user_activity') }}</a>
        </li>
        <!--end nav-item-->
    </ul>
    <!--end nav-->
</div><!-- end user management-->
