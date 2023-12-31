<li class="nav-item">
    <a class="nav-link" href="#grievancesMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="grievancesMenu"><i class="ti ti-mood-confuzed me-2"></i>
        Grievances
    </a>
    <div class="collapse " id="grievancesMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('my-grievances')}}" class="nav-link ">My Grievances</a>
            </li>
            @permission('view_grievances')
            <li class="nav-item">
                <a href="/human-resource/grievances" class="nav-link ">Grievances</a>
            </li>
            @endpermission
            @permission('view_grievance_types')
            <li class="nav-item">
                <a href="/human-resource/grievance-types" class="nav-link ">Types</a>
            </li>
            @endpermission
        </ul>
        <!--end nav-->
    </div>
</li>