<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">ERP</a>
                        </li>
                        <!--end nav-item-->
                        <li class="breadcrumb-item"><a href="#">HumanResource</a>
                        </li>
                        <!--end nav-item-->
                        <li class="breadcrumb-item active">Employee</li>
                    </ol>
                </div>
                <h4 class="page-title">Employee Profile</h4>
            </div>
            <!--end page-title-box-->
        </div>
        <!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 align-self-center">
                            <div class="media align-items-center">
                                <img src="{{ $employee->user->avatar ? asset('storage/' . Auth::user()->avatar) : asset('assets/images/users/user-vector.png') }}"
                                    alt="profile-user" class="rounded-circle thumb-xl" />
                                <div class="media-body ms-3 align-self-center">
                                    <h5 class="m-0 font-22 fw-bold">{{$employee->full_name}}</h5>
                                    <p class="mb-0 fw-semibold">{{$employee->work_type}}</p>
                                    <p class="mb-0 fw-semibold">{{$employee->designation->name}}</p>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-lg-4 ms-auto">
                            <ul class="list-unstyled personal-detail">
                                <li class=""><i class="dripicons-phone mr-2 text-info font-18"></i> <b> Phone
                                    </b> : {{$employee->contact}}/ {{$employee->alt_contact}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Email </b> : {{$employee->email}}/ {{$employee->alt_email}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Entry Type </b> : {{$employee->entry_type}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Employee Number </b> : {{$employee->employee_number}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Nin Number </b> : {{$employee->nin_number}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Gender </b> : {{$employee->gender}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Nationality </b> : {{$employee->nationality}}</li>
                                <li class="mt-2"><i class="dripicons-mail text-info font-18 mt-2 mr-2"></i> <b>
                                        Religion </b> : {{$employee->religious_affiliation}}</li>
                            </ul>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-3">
                            <h5 class="header-title dual-border mb-0 position-relative">Department</h5>
                            <p class="mt-3 mb-0">{{$employee->department->name}}
                            </p>
                        </div>
                        <!--end col-->
                        <div class="col-md-6 col-lg-3">
                            <h5 class="header-title dual-border mb-0 position-relative">Station</h5>
                            <p class="mt-3 mb-0">{{$employee->station->name}} </p>
                        </div>
                        <!--end col-->
                        <div class="col-md-6 col-lg-3">
                            <h5 class="header-title dual-border mb-0 position-relative">Cluster</h5>
                            <p class="mt-3 mb-0">1st Floor E</p>
                        </div>
                        <!--end col-->
                        <div class="col-md-6 col-lg-3">
                            <h5 class="header-title dual-border mb-0 position-relative">Contacts</h5>
                            {{-- <p class="mt-3 mb-0">
                                <span class="fw-semibold">Morning Timing :</span> 10:00 AM - 01:00 PM
                            </p>
                            <p class="mb-0">
                                <span class="fw-semibold">Evening Timing :</span> 04:00 PM - 07:00 PM
                            </p> --}}
                            <p class="mt-1">
                                N/A
                            </p>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
    <div class="row">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Experiences</h4>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <p class="mb-0">
                        N/A
                    </p>
                </div>
                <!--end card-body-->
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Family Background</h4>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <p class="mb-0">
                        N/A
                    </p>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Education Background</h4>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <p class="mb-0">
                        N/A
                    </p>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
            <!--end card-->
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Projects</h4>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!--end card-header-->
                <div class="card-body">
                    <p class="mb-0">
                        N/A
                    </p>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body border-bottom">
                    <div class="media align-items-center">
                        <div
                            class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                            <i class="las la-medal align-self-center text-secondary font-24"></i>
                        </div>

                        <div class="media-body ms-3 align-self-center">
                            <h5 class="m-0 font-15">Activated on</h5>
                            <p class="mb-0 text-muted">12/11/2024</p>
                        </div>
                    </div>
                </div>

                <!--end card-body-->
                <div class="card-body">
                    <div class="media align-items-center">
                        <div
                            class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                            <i class="las la-award align-self-center text-secondary font-24"></i>
                        </div>
                        <div class="media-body ms-3 align-self-center">
                            <h5 class="m-0 font-15">Status</h5>
                            <p class="mb-0 text-muted">Active</p>
                        </div>
                    </div>
                </div>
                <!--end card-body-->
            </div>
            <!--end card-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->

</div><!-- container -->