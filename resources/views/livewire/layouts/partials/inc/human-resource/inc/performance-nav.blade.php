<li class="nav-item">
    <a class="nav-link" href="#performanceMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="performanceMenu"><i class="ti ti-file-analytics me-2"></i>
        Performance
    </a>
    <div class="collapse " id="performanceMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#appraisalsMenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="appraisalsMenu">
                    Appraisals
                </a>
                <div class="collapse " id="appraisalsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('my.appraisals')}}">My Appraisals</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('appraisals.create')}}">New </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('appraisals')}}">All Appraisals</a>
                        </li>
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->
            <li class="nav-item">
                <a href="#warningsMenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="warningsMenu">
                    Warning
                </a>
                <div class="collapse" id="warningsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('warnings.create')}}">Create</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('warnings')}}">All Warnings</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a href="#terminationMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="terminationMenu">
                    Termination
                </a>
                <div class="collapse" id="terminationMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('terminations.create')}}">Create</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('terminations')}}">All Terminations</a>
                        </li>
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a href="#resignationMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="resignationMenu">
                    Resignation
                </a>
                <div class="collapse" id="resignationMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('resignations.create')}}">Create</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('resignations')}}">All Resignations</a>
                        </li>
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a href="#exitInterviewsMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="exitInterviewsMenu">
                    Exit Interviews
                </a>
                <div class="collapse" id="exitInterviewsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('exit-interviews.create')}}">Create</a>
                        </li>
                        <!--end nav-item-->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('exit-interviews')}}">All Exit interviews</a>
                        </li>
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->
        </ul>
        <!--end nav-->
    </div>

</li>
<!--end nav-item-->