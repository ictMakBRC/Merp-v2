 <div class="row justify-content-center">
        <div class="col-12">
            <div class="card overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-6 col-lg-3 border-b border-e border-bo">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-info">
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="package" class="align-self-center  icon-sm"></i>  
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                            
                                            <p class="mb-0 text-truncate ">Estimates</p>                                                                                   
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->where('status','!=','Canceled')->sum('total_amount'))</h5>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3 border-b border-e border-bo">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-primary">                                                
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i class="align-self-center  icon-sm fas fa-money-bill-wave"></i>  
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                            
                                            <p class="mb-0 text-truncate ">Paid</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h4 class="my-1">  <h5 class="my-1">@moneyFormat($invoices->where('status','Fully Paid')->sum('total_amount'))</h5></h4>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col-->                         
                    <div class="col-md-6 col-lg-3 border-b border-e">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-warning">
                                <div class="col">  
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="alert-octagon" class="align-self-center  icon-sm"></i>
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                             
                                            <p class="mb-0 text-truncate ">Unpaid</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                    
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->whereIn('status',['Partially Paid','Approved'])->sum('total_amount'))</h5>                                                     
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col--> 
                    <div class="col-md-6 col-lg-3 ps-lg-0">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center text-danger">                                                
                                <div class="col">
                                    <div class="media">
                                        <div class="bg-light-alt d-flex justify-content-center align-items-center thumb-md  rounded-circle">
                                            <i data-feather="alert-triangle" class="align-self-center  icon-sm"></i> 
                                        </div>
                                        <div class="media-body align-self-center ms-2"> 
                                            <p class=" mb-1 fw-semibold">Total</p>                                                      
                                            <p class="mb-0 text-truncate ">Overdue</p>
                                        </div><!--end media body-->
                                    </div><!--end media-->                                                     
                                </div><!--end col-->
                                <div class="col-auto align-self-center">
                                    <h5 class="my-1">@moneyFormat($invoices->whereIn('status',['Partially Paid','Approved'])->where('as_of','>=',date('Y-m-d'))->sum('total_amount'))</h5>                       
                                </div><!--end col-->
                            </div><!--end row-->
                        </div><!--end card-body-->                                            
                    </div> <!--end col-->
                </div><!--end row--> 
            </div><!--end card-->
        </div><!--end col-->           
    </div><!--end row-->