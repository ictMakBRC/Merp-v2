<li class="nav-item">
    <a class="nav-link" href="#employeeDataMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="employeeDataMenu"><i class="ti ti-users me-2"></i>
        Employees
    </a>
    <div class="collapse " id="employeeDataMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('human-resource-capture-new-info')}}" class="nav-link ">Employee Centre</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a href="{{route('human-resource-employees-list')}}" class="nav-link ">All Employees</a>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a href="#officialContactsSubMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="officialContactsSubMenu">
                    Contracts
                </a>
                <div class="collapse" id="officialContactsSubMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('human-resource-official_contracts') }}">Official Contracts</a>
                        </li>
                        <!--end nav-item-->
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{ route('human-resource-my_official_contracts') }}">My Contracts</a>
                        </li> --}}
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
            </li>

            {{-- <li class="nav-item">
                <a href="#payRoll" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="payRoll">
                    Payroll
                </a>
                <div class="collapse" id="payRoll">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('human-resource-official_payroll') }}">Generate Payroll</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="payslips">My Payslips</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
            </li> --}}
        </ul>
        <!--end nav-->
    </div>
</li>
