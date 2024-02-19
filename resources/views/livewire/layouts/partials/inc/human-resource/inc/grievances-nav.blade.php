<li class="nav-item">
    <a class="nav-link" href="#grievancesMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="grievancesMenu"><i class="ti ti-mood-confuzed me-2"></i>
        Grievances
    </a>
    <div class="collapse " id="grievancesMenu">
        <ul class="nav flex-column">
            {{-- <li class="nav-item">
                <a href="{{route('my-grievances')}}" class="nav-link ">My Grievances</a>
            </li> --}}
            {{-- @if (Auth::user()->hasPermission(['view_grievances']))
                <li class="nav-item">
                    <a href="/human-resource/grievances" class="nav-link ">Grievances</a>
                </li>
            @endif
            @if (Auth::user()->hasPermission(['view_grievance_types']))
                <li class="nav-item d-none">
                    <a href="/human-resource/grievance-types" class="nav-link ">Types</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('hr_grievances-types') }}" class="nav-link ">Grievance Types</a>
                </li>
            @endif --}}
            @if (Auth::user()->hasPermission(['create_grievance']))
                <li class="nav-item">
                    <a href="{{ route('hr_grievances-user') }}" class="nav-link ">My Grievances</a>
                </li>
            @endif
            @if (Auth::user()->hasPermission(['view_grievances']))
                <li class="nav-item">
                    <a href="{{ route('hr_grievances-list','all') }}" class="nav-link ">All Grievances</a>
                </li>
            @endif
            @if (Auth::user()->hasPermission(['view_department_grievances']))
                <li class="nav-item">
                    <a href="{{ route('hr_grievances-list','unit') }}" class="nav-link ">Unit Grievances</a>
                </li>
            @endif
        </ul>
        <!--end nav-->
    </div>
</li>