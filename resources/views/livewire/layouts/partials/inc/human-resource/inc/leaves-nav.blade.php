<li class="nav-item">
    <a class="nav-link" href="#employeeLeaveMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="employeeLeaveMenu"><i class="ti ti-calendar-off me-2"></i>
        Leaves
    </a>
    <div class="collapse " id="employeeLeaveMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('leave.requests')}}" class="nav-link ">My Requests</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a href="{{route('leave.requests.delegations')}}" class="nav-link ">My Delegations</a>
            </li>

            <li class="nav-item">
                <a href="{{route('leave.requests.departmental')}}" class="nav-link ">Departmental Requests</a>
            </li>
            <!--end nav-item-->
        </ul>
        <!--end nav-->
    </div>
</li>

<li class="nav-item {{ request()->segment(3) == 'leaves' ? 'menuitem-active' : '' }}">
    <a class="nav-link" href="#leaves" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="leaves"><i class="ti ti-calendar-off me-2"></i>
        Manage Leaves
    </a>
    <div class="collapse " id="leaves">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('hr-leave_requests','my')}}" class="nav-link ">My Requests</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a href="{{route('leave.requests.delegations')}}" class="nav-link ">My Delegations</a>
            </li>

            <li class="nav-item">
                <a href="{{route('hr-leave_requests','unit')}}" class="nav-link ">Uint Requests</a>
            </li>

            <li class="nav-item">
                <a href="{{route('hr-leave_requests','all')}}" class="nav-link ">All Requests</a>
            </li>
            <!--end nav-item-->
        </ul>
        <!--end nav-->
    </div>
</li>