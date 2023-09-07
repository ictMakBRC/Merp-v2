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