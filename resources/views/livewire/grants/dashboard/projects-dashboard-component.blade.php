<div>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-3">
            <div class="card report-card border-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-1 fw-semibold">Grants</p>
                            <h4 class="my-1">{{ $totalGrants }}</h4>
                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i
                                        class="mdi mdi-checkbox-marked-circle-outline me-1"></i></span>Total</p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div
                                class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                <i data-feather="dollar-sign" class="align-self-center text-muted icon-sm"></i>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
        <div class="col-md-6 col-lg-3">
            <div class="card report-card border-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-1 fw-semibold">Projects</p>
                            <h4 class="my-1">{{ $totalProjects }}</h4>
                            <p class="mb-0 text-truncate text-muted"><span class="text-success"><i
                                        class="mdi mdi-checkbox-marked-circle-outline me-1"></i></span>Total</p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div
                                class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                <i data-feather="layers" class="align-self-center text-muted icon-sm"></i>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
        <div class="col-md-6 col-lg-3">
            <div class="card report-card border-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-1 fw-semibold">Employees</p>
                            <h4 class="my-1">{{$employeesForRunningProjects}}</h4>
                            <p class="mb-0 text-truncate text-muted">For Running Projects</p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div
                                class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                <i class="align-self-center text-muted icon-sm ti ti-users"></i>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->

        <div class="col-md-6 col-lg-3">
            <div class="card report-card border-info">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <div class="col">
                            <p class="text-dark mb-1 fw-semibold">Total Funding ({{getDefaultCurrency()->code}})</p>
                            <h4 class="my-1">@moneyFormat($totalFundsForRunningProjects)</h4>
                            <p class="mb-0 text-truncate text-muted">For Running Projects</p>
                        </div>
                        <div class="col-auto align-self-center">
                            <div
                                class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                <i data-feather="dollar-sign" class="align-self-center text-muted icon-sm"></i>
                            </div>
                        </div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
    </div><!--end row-->

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Grants | Projects By Year</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="">
                        <div id="grants_and_projects" class="apex-charts"></div>
                    </div>
                </div><!--end card-body-->
            </div><!--end card-->
        </div> <!--end col-->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Projects Status</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="position-absolute bottom-50 start-50 translate-middle mb-n2">
                        <h6 class="mb-0">Projects |Studies</h6>
                        <p class="mb-0 text-uppercase fw-semibold text-muted">STATUS</p>
                    </div>
                    <div id="projects_status" class="apex-charts mb-2"></div>
                    <ul class="list-inline mb-0 text-center">
                        <li class="list-inline-item mb-2 mb-lg-0 fw-semibold">
                            <i class="ti ti-bell-plus text-primary font-16 align-middle me-1"></i>Eminent
                        </li>
                        <li class="list-inline-item mb-2 mb-lg-0 fw-semibold">
                            <i class="ti ti-chart-infographic me-1 mb-lg-0 font-16 align-middle text-info"></i>Running
                        </li>
                        <li class="list-inline-item mb-2 fw-semibold">
                            <i class="ti ti-checkbox text-success me-1 font-16 align-middle"></i>Completed
                        </li>
                    </ul>
                    <hr class="hr-dashed">
                    {{-- <div class="media">
                        <span
                            class="thumb-sm justify-content-center d-flex align-items-center bg-soft-warning rounded-circle me-2">MT</span>
                        <div class="media-body align-self-center">
                            <p class="text-muted mb-0">There are many variations of passages of Lorem Ipsum available...
                                <a href="#" class="text-primary">Read more</a>
                            </p>
                        </div><!--end media-body-->
                    </div> --}}
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Recent Projects</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <a href="{{ route('manage-projects') }}" class="text-primary">View All</a>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Category') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Principal Investigator') }}</th>
                                    <th>{{ __('Progress Status') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('public.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($projects as $key=>$project)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $project->project_code }}</td>
                                        <td>{{ $project->project_category }}</td>
                                        <td>{{ $project->project_type }}</td>
                                        <td>@formatDate($project->start_date)</td>
                                        <td>@formatDate($project->end_date)</td>
                                        <td>{{ $project->principalInvestigator?->fullName ?? 'N/A' }}</td>
                                        <td><span class="badge bg-info">{{ ucfirst($project->progress_status) }}</span>
                                        </td>
                                        @if ($project->end_date >= today())
                                            <td><span class="badge bg-success">Running</span>
                                                @if ($project->days_to_expire >= 0)
                                                    + ({{ $project->days_to_expire }}) days
                                                @else
                                                @endif
                                            </td>
                                        @else
                                            <td><span class="badge bg-danger">Ended</span></td>
                                        @endif

                                        <td>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('project-profile', $project->id) }}"
                                                    class="m-1" title="View Profile"><i class="ti ti-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{-- <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Project Name</th>
                                    <th>Principal Investigator</th>
                                    <th>Start Date</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Product Devlopment</td>
                                    <td>
                                        <img src="assets/images/users/user-2.jpg" alt="" class="thumb-sm rounded me-2">
                                        Kevin J. Heal
                                    </td>
                                    <td>20/3/2021</td>
                                    <td>5/5/2021</td>
                                    <td><span class="badge badge-md badge-boxed  badge-soft-success">Active</span></td>
                                    <td>
                                        <small class="float-end ms-2 pt-1 font-10">92%</small>
                                        <div class="progress mt-2" style="height:3px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 92%;" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                                                                                                                                 
                            </tbody>
                        </table> --}}

                    </div><!--end table-responsive-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->

        {{-- <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Activity</h4>
                        </div><!--end col-->
                        <div class="col-auto">
                            <div class="dropdown">
                                <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    All<i class="las la-angle-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="#">Purchases</a>
                                    <a class="dropdown-item" href="#">Emails</a>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body p-0">
                    <div class="p-3" style="height: 425px;" data-simplebar>
                        <div class="activity">
                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="las la-user-clock bg-soft-primary"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Donald</span>
                                            updated the status of <a href="">Refund #1234</a> to awaiting
                                            customer response
                                        </p>
                                        <small class="text-muted">10 Min ago</small>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-timer-off bg-soft-primary"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Lucy Peterson</span>
                                            was added to the group, group name is <a href="">Overtake</a>
                                        </p>
                                        <small class="text-muted">50 Min ago</small>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <img src="assets/images/users/user-5.jpg" alt=""
                                        class="rounded-circle thumb-sm">
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Joseph Rust</span>
                                            opened new showcase <a href="">Mannat #112233</a> with theme market
                                        </p>
                                        <small class="text-muted">10 hours ago</small>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-clock-outline bg-soft-primary"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Donald</span>
                                            updated the status of <a href="">Refund #1234</a> to awaiting
                                            customer response
                                        </p>
                                        <small class="text-muted">Yesterday</small>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-alert-outline bg-soft-primary"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Lucy Peterson</span>
                                            was added to the group, group name is <a href="">Overtake</a>
                                        </p>
                                        <small class="text-muted">14 Nov 2021</small>
                                    </div>
                                </div>
                            </div>
                            <div class="activity-info">
                                <div class="icon-info-activity">
                                    <img src="assets/images/users/user-4.jpg" alt=""
                                        class="rounded-circle thumb-sm">
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted mb-0 font-13 w-75"><span>Joseph Rust</span>
                                            opened new showcase <a href="">Mannat #112233</a> with theme market
                                        </p>
                                        <small class="text-muted">15 Nov 2021</small>
                                    </div>
                                </div>
                            </div>
                        </div><!--end activity-->
                    </div><!--end analytics-dash-activity-->
                </div> <!--end card-body-->
            </div><!--end card-->
        </div><!--end col--> --}}
    </div><!--end row-->


    @push('scripts')
        <script>
            var options = {
                    chart: {
                        height: 325,
                        type: "area",
                        toolbar: {
                            show: !1
                        }
                    },
                    colors: ["#67c8ff", "#6d81f5"],
                    dataLabels: {
                        enabled: !1
                    },
                    stroke: {
                        show: !0,
                        curve: "smooth",
                        width: [1.5, 1.5],
                        dashArray: [0, 4],
                        lineCap: "round"
                    },
                    series: [{
                            name: "Grants",
                            data: Object.values(@json($grantsAndProjectsPerYear)).map(counts => counts.grants_count)
                        },
                        {
                            name: "Projects/Studies",
                            data: Object.values(@json($grantsAndProjectsPerYear)).map(counts => counts.projects_count)
                        }
                    ],
                    labels: Object.keys(@json($grantsAndProjectsPerYear)),
                    yaxis: {
                        labels: {
                            offsetX: -12,
                            offsetY: 0
                        }
                    },
                    legend: {
                        show: true,
                        position: 'top', // Adjust as needed: 'top', 'bottom', 'right', 'left'
                        horizontalAlign: 'center', // Adjust as needed: 'left', 'center', 'right'
                        onItemClick: {
                            toggleDataSeries: true
                        }
                    },
                    grid: {
                        borderColor: "#e0e6ed",
                        strokeDashArray: 3,
                        xaxis: {
                            lines: {
                                show: !0
                            }
                        },
                        yaxis: {
                            lines: {
                                show: !1
                            }
                        }
                    },
                  
                    fill: {
                        type: "gradient",
                        gradient: {
                            type: "vertical",
                            shadeIntensity: 1,
                            inverseColors: !1,
                            opacityFrom: .28,
                            opacityTo: .05,
                            stops: [45, 100]
                        }
                    }
                },

                chart = (new ApexCharts(document.querySelector("#grants_and_projects"), options)).render(),

                donut_options = ({
                    chart: {
                        height: 240,
                        type: "donut"
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: "85%"
                            }
                        }
                    },
                    dataLabels: {
                        enabled: 1
                    },
                    stroke: {
                        show: !0,
                        width: 2,
                        colors: ["transparent"]
                    },
                    series: @json($projectStatus),
                    legend: {
                        show: !1,
                        position: "bottom",
                        horizontalAlign: "center",
                        verticalAlign: "middle",
                        floating: !1,
                        fontSize: "14px",
                        offsetX: 0,
                        offsetY: -13
                    },
                    labels: ["Eminent", "Running", "Completed"],
                    colors: ["#67C2FE", "#41CBD8", "#22B783", ],
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            plotOptions: {
                                donut: {
                                    customScale: .2
                                }
                            },
                            chart: {
                                height: 240
                            },
                            legend: {
                                show: 1
                            }
                        }
                    }],
                    tooltip: {
                        y: {
                            formatter: function(e) {
                                return e + " Project(s)"
                            }
                        }
                    }
                });

            (chart = new ApexCharts(document.querySelector("#projects_status"), donut_options)).render();
            
        </script>
    @endpush

</div>
