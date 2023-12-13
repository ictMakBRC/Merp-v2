<div>
    <div class="container-fluid">
    
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Documents</a></li>
                            <li class="breadcrumb-item active">Requests</li>
                        </ol>
                    </div>
                    <h4 class="page-title">View Incoming Requests</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card widget-inline">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-sm-6 col-xl-3">
                                <div class="card shadow-none m-0">
                                    <div class="card-body text-center">
                                        <i class=" uil-envelope-check text-muted" style="font-size: 24px;"></i>
                                        <h3><span>{{$submited_requets->count()}}</span></h3>
                                        <p class="text-muted font-15 mb-0">Total Requests Received</p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 col-xl-3">
                                <div class="card shadow-none m-0 border-start">
                                    <div class="card-body text-center">
                                        <i class="uil-envelope-exclamation text-muted" style="font-size: 24px;"></i>
                                        <h3><span>{{$submited_requets->where('status', '!=', 'Completed')->count()}}</span></h3>
                                        <p class="text-muted font-15 mb-0">Requests Pending</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card shadow-none m-0 border-start">
                                    <div class="card-body text-center">
                                        <i class="uil-copy-alt text-info" style="font-size: 24px;"></i>
                                        <h3><span>{{$submited_documents->count()}}</span></h3>
                                        <p class="text-muted font-15 mb-0">Documents Received</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xl-3">
                                <div class="card shadow-none m-0 border-start">
                                    <div class="card-body text-center">
                                        <i class="uil-file-exclamation text-primary" style="font-size: 24px;"></i>
                                        <h3><span>{{$submited_documents->where('status', '!=', 'Signed')->count()}}</span> <i class="mdi mdi-arrow-up text-success"></i></h3>
                                        <p class="text-muted font-15 mb-0">Documents Pending</p>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end row -->
                    </div>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <div class="card">
            <div class="card-body">
                <h6>Recently uploaded</h6>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Name <i class='mdi mdi-up-arrow-alt ms-2'></i></th>
                                <th>Category</th>
                                <th>Created by</th>
                                <th>Created On</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($incomingRequsests as $requests)
                            <tr >
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div><i class='mdi mdis-file me-2 font-24 text-primary'></i>
                                        </div>
                                        <div class="font-weight-bold text-primary">{{$requests->title}}</div>
                                    </div>
                                </td>
                                <td>{{$requests->category->name??'N/A'}}</td>
                                <td>{{$requests->user->name??'N/A'}}</td>
                            
                                <th>{{$requests->created_at??'N/A'}}</th>
                                <th>{{$requests->status??'N/A'}}</th>
                                <td class="table-action">
                                    
                                <a href="{{route('documents-request.sign',$requests->request_code)}}" class="btn btn-sm btn-outline-secondary" ><i class='mdi mdi-eye font-20'></i></a> 
                                                             
                                            
                                </td>
                            </tr>
                            @empty                                                            
                                
                            <tr>
                            
                                <td colspan="6" class="text-center text-danger">You have no resources uploaded in the following folder</td>
                            
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
