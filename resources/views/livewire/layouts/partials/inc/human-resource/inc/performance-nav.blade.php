<li class="nav-item">
    <a class="nav-link" href="#performanceMenu" data-bs-toggle="collapse" role="button" aria-expanded="false"
        aria-controls="performanceMenu"><i class="ti ti-file-analytics me-2"></i>
        Performance
    </a>
    <div class="collapse"
        id="performanceMenu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#appraisalsMenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="appraisalsMenu">
                    Appraisals
                </a>
                
                <div class="collapse" id="appraisalsMenu">
                    <ul class="nav flex-column">                             
                        @if (Auth::user()->hasPermission(['create_appraisals']))                   
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_appraisals','all')}}">All Appraisals</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_appraisals','personal')}}">My Appraisals</a>
                        </li>
                    </ul>
                </div>
                {{-- <div class="collapse {{isLinkActive(['appraisals.show'], 'show')}}" id="appraisalsMenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('my.appraisals')}}">My Appraisals</a>
                        </li>
                        <!--end nav-item-->
                        @permission('create_appraisal')
                        <li class="nav-item">
                            <a class="nav-link {{isLinkActive(['appraisals.show'], 'active')}}"
                                href="{{route('appraisals.create')}}">
                                @if(showWhenLinkActive('appraisals.show'))
                                <span>Show</span>
                                @else
                                <span>New</span>
                                @endif
                            </a>
                        </li>
                        @endpermission
                        @permission('view_appraisals')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('appraisals')}}">All Appraisals</a>
                        </li>
                        @endpermission
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div> --}}
            </li>
            <!--end nav-item-->
            <li class="nav-item {{ request()->segment(3) == 'warnings' ? 'menuitem-active' : '' }}">
                <a href="#warningsMenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="warningsMenu">
                    Warning
                </a>
                <div class="collapse" id="warningsMenu">
                    <ul class="nav flex-column">
                        {{-- @permission('create_warning')
                        <li class="nav-item">
                            <a class="nav-link {{isLinkActive(['warnings.show'], 'active')}}"
                                href="{{route('warnings.create')}}">
                                @if(showWhenLinkActive('warnings.show'))
                                <span>Show</span>
                                @else
                                <span>New</span>
                                @endif</a>
                        </li>
                        @endpermission
                        <!--end nav-item-->
                        @permission('view_warnings')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('warnings')}}">All Warnings</a>
                        </li>
                        @endpermission --}}
                        <!--end nav-item-->
                        
                        @if (Auth::user()->hasPermission(['create_warning']))
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_warnings','all')}}">All Warnings</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_warnings','personal')}}">My Warnings</a>
                        </li>
                    </ul>
                    <!--end nav-->
                </div>
            </li>
            <!--end nav-item-->

            <li class="nav-item {{ request()->segment(3) == 'terminations' ? 'menuitem-active' : '' }}">
                <a href="#terminationMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="terminationMenu">
                    Termination
                </a>
                <div class="collapse" id="terminationMenu">
                    <ul class="nav flex-column">                             
                        @if (Auth::user()->hasPermission(['create_termination']))                   
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_terminations','all')}}">All Terminations</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_terminations','personal')}}">My Terminations</a>
                        </li>
                    </ul>
                </div>

                {{-- <div class="collapse {{isLinkActive(['terminations.show'], 'show')}}" id="terminationMenu">
                    <ul class="nav flex-column">
                        @permission('create_termination')
                        <li class="nav-item">
                            <a class="nav-link {{isLinkActive(['terminations.show'], 'active')}}"
                                href="{{route('terminations.create')}}">
                                @if(showWhenLinkActive('terminations.show'))
                                <span>Show</span>
                                @else
                                <span>New</span>
                                @endif</a>
                            </a>
                        </li>
                        @endpermission
                        <!--end nav-item-->
                        @permission('view_terminations')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('terminations')}}">All Terminations</a>
                        </li>
                        @endpermission
                        <!--end nav-item-->
                    </ul>
                    <!--end nav-->
                </div> --}}
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a href="#resignationMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="resignationMenu">
                    Resignation
                </a>
                <div class="collapse" id="resignationMenu">
                    <ul class="nav flex-column">                             
                        @if (Auth::user()->hasPermission(['view_resignations']))                   
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_resignations','all')}}">All Resignations</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('hr_resignations','personal')}}">My Resignations</a>
                        </li>
                    </ul>
                </div>
                {{-- <div class="collapse {{isLinkActive(['resignations.show'], 'show')}}" id="resignationMenu">
                    <ul class="nav flex-column">
                        @permission('create_resignation')
                        <li class="nav-item">
                            <a class="nav-link {{isLinkActive(['resignations.show'], 'active')}}"
                                href="{{route('resignations.create')}}">
                                @if(showWhenLinkActive('resignations.show'))
                                <span>Show</span>
                                @else
                                <span>New</span>
                                @endif</a></a>
                        </li>
                        @endpermission
                        <!--end nav-item-->
                        @permission('view_resignations')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('resignations')}}">All Resignations</a>
                        </li>
                        @endpermission
                        <!--end nav-item-->

                    </ul>
                    <!--end nav-->
                </div> --}}
            </li>
            <!--end nav-item-->

            <li class="nav-item">
                <a href="#exitInterviewsMenu" class="nav-link" data-bs-toggle="collapse" role="button"
                    aria-expanded="false" aria-controls="exitInterviewsMenu">
                    Exit Interviews
                </a>
                <div class="collapse {{isLinkActive(['exit-interviews.show'], 'show')}}" id="exitInterviewsMenu">
                    <ul class="nav flex-column">
                        @permission('create_exit_interview')
                        <li class="nav-item">
                            <a class="nav-link {{isLinkActive(['exit-interviews.show'], 'active')}}"
                                href="{{route('exit-interviews.create')}}">
                                @if(showWhenLinkActive('exit-interviews.show'))
                                <span>Show</span>
                                @else
                                <span>New</span>
                                @endif</a>
                            </a>
                        </li>
                        @endpermission
                        <!--end nav-item-->
                        @permission('view_exit_interviews')
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('exit-interviews')}}">All Exit interviews</a>
                        </li>
                        @endpermission
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