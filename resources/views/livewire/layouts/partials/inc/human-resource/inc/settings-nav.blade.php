<li class="nav-item">
    <a class="nav-link" href="#humanResourceSettingsMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="humanResourceSettingsMenu"> <i class="ti ti-settings me-2"></i>
        Settings
    </a>
    <div class="collapse " id="humanResourceSettingsMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('company-profile')}}" class="nav-link ">Organization Profile</a>
            </li>
            <li class="nav-item">
                <a href="{{route('human-resource-stations')}}" class="nav-link ">Duty Stations</a>
            </li>
            <li class="nav-item">
                <a href="{{route('human-resource-departments')}}" class="nav-link ">Departments</a>
            </li>
            <li class="nav-item">
                <a href="{{route('human-resource-designations')}}" class="nav-link ">Designations</a>
            </li>
            <li class="nav-item">
                <a href="{{route('human-resource-holidays')}}" class="nav-link ">Holidays</a>
            </li>

            <li class="nav-item">
                <a href="{{route('human-resource-offices')}}" class="nav-link ">Offices</a>
            </li>

            <li class="nav-item">
                <a href="{{route('human-resource-leave-types')}}" class="nav-link ">Leave Types</a>
            </li>

            {{-- <li class="nav-item">
                <a href="{{route('human-resource.settings.performances')}}" class="nav-link ">Performance
                    Configurations</a>
            </li>            
            <li class="nav-item">
                <a href="{{ route('hr_grievances-types') }}" class="nav-link ">Grievance Types</a>
            </li>
            </li> --}}

        </ul>
        <!--end nav-->
    </div>
    <!--end sidebarAnalytics-->
</li>