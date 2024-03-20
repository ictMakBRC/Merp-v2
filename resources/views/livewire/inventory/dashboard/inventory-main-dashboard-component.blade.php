<div>
    <div class="container-fluid">

        <!-- start quote -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-light" id="dash-daterange">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <i class="mdi mdi-calendar-range font-13"></i>
                                </span>
                            </div>
                            <a href="{{ url('inventory/dashboard') }}" class="btn btn-primary ms-2">
                                <i class="mdi mdi-autorenew"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Dashboard</h4>
                </div>
            </div>
        </div>
        <!-- end quote -->

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='uil uil-window-restore float-end'></i>
                        <h6 class="text-uppercase mt-0">Item count</h6>
                        <h2 class="my-2">{{ $items->count() }}</h2>
                        <p class="mb-0 text-muted">
                            <a href="{{ url('inventory/Items') }}" class="text-nowrap">View all</a>
                        </p>
                    </div> <!-- end card-body-->
                </div>

                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='uil uil-users-alt float-end'></i>
                        <h6 class="text-uppercase mt-0">All Requests</h6>
                        <h2 class="my-2">{{ $requests->count() }}</h2>
                        <p class="mb-0 text-muted">

                            <a href="{{ url('inventory/inv/requests') }}" class="text-nowrap">view all</a>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->

                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='uil uil-users-alt float-end'></i>
                        <h6 class="text-uppercase mt-0">Pending Requests</h6>
                        <h2 class="my-2">{{ $requests->whereIn('status',['Submitted','Approved'])->count() }}</h2>
                        <p class="mb-0 text-muted">

                            <a href="{{ url('inventory/inv/requests') }}" class="text-nowrap">view all</a>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->
                <div class="card tilebox-one">
                    <div class="card-body">
                        <i class='uil uil-users-alt float-end'></i>
                        <h6 class="text-uppercase mt-0">Approved Requests</h6>
                        <h2 class="my-2">{{ $requests->whereIn('status',['Declined','Processed','Acknowledged','Received','Approved'])->count() }}</h2>
                        <p class="mb-0 text-muted">

                            <a href="{{ url('inventory/inv/requests') }}" class="text-nowrap">view all</a>
                        </p>
                    </div> <!-- end card-body-->
                </div>
                <!--end card-->



            </div> <!-- end col -->

            <div class="col-xl-9 col-lg-8">
                <div class="card card-h-100">
                    <div class="card-body">

                        <a href="{{ url('inventory/inv/requests') }}" class="p-0 float-end">View All <i
                                class="mdi mdi-download ms-1"></i></a>
                        <h4 class="header-title mb-3">Pending Requests</h4>

                        <div dir="ltr">
                            <div class="table-responsive">
                                <table class="table table-sm table-centered mb-0 font-14">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Request code</th>
                                            <th>Type</th>
                                            <th>Department/Project</th>
                                            <th>Approver</th>
                                            <th>Date added</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($requests) > 0)
                                            @php($i = 1)
                                            @foreach ($requests->whereIn('status',['Submitted','Approved','Acknowledged']) as $value)
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $value->request_code }}</td>
                                                    <td>{{ $value->request_type }}</td>
                                                    <td>{{ $value->unitable->name??'N/A' }}</td>
                                                    <td>{{ $value->createdBy->name??'N/A' }}</td>

                                                    <td>{{ $value->requestdate }}</td>

                                                    <td class="table-action">
                                                        <a href="{{ url('inventory/request/inv/view/' . $value->request_code) }}"
                                                            class="action-icon"> <i class="mdi mdi-eye"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif


                                    </tbody>
                                </table>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class = 'card-body'>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="" class="p-0 float-end">View All <i
                                                class="mdi mdi-download ms-1"></i></a>
                                        <h4 class="header-title mt-1 mb-3">Stock warning</h4>

                                        <div class="table-responsive">
                                            <table class="table table-sm table-centered mb-0 font-14">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Item name</th>
                                                        <th>Belongs to</th>
                                                        <th>Description</th>
                                                        <th>UOM</th>
                                                        <th>Quantity left</th>

                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php($i = 1)
                                                    @foreach ($stockwarning as $warning)
                                                        <tr>
                                                            <td>{{ $i++ }}</td>
                                                            <td>{{ $warning->item_name }}</td>
                                                            <td>{{ $warning->department_name }}</td>
                                                            <td>{{ $warning->description }}</td>
                                                            <td>{{ $warning->uom_name }}</td>
                                                            <td>{{ $warning->qty_left }}</td>
                                                            <td><button class="btn btn-info" type=""></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
        </div>
    </div>
</div>
