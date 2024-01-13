<div class="row">
    <div class="col-12 col-md-4 col-lg-3"> 
        <div class="card overflow-hidden">                                
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">                                                                        
                        <span class="h4 fw-bold">{{ $requests->total() }}</span>      
                        <h6 class="text-uppercase text-muted mt-2 m-0 font-11">Total Reuests</h6>                
                    </div><!--end col-->
                    <div class="col-auto">
                        <i class="lab la-accessible-icon display-3 text-secondary position-absolute o-1 translate-middle"></i>
                    </div><!--end col-->
                </div> <!-- end row -->
            </div><!--end card-body-->                                                               
        </div> <!--end card-->                     
    </div><!--end col-->
    <div class="col-12 col-md-4 col-lg-3"> 
        <div class="card overflow-hidden">                                
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">                                                                        
                        <span class="h4 fw-bold">{{ $requests->where('status','Submitted')->count() }}</span>      
                        <h6 class="text-uppercase text-muted mt-2 m-0 font-11">Pending Requests </h6>                
                    </div><!--end col-->
                    <div class="col-auto position-reletive">
                        <i class="las la-bed display-3 text-secondary position-absolute o-1 translate-middle"></i>
                    </div><!--end col-->
                </div> <!-- end row -->
            </div><!--end card-body-->                                                               
        </div> <!--end card-->                     
    </div><!--end col-->
    <div class="col-12 col-md-4 col-lg-3"> 
        <div class="card overflow-hidden">                                
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">                                                                        
                        <span class="h4 fw-bold">{{ $requests->where('status','Approved')->count() }}</span>      
                        <h6 class="text-uppercase text-muted mt-2 m-0 font-11">Approved Requests</h6>                
                    </div><!--end col-->
                    <div class="col-auto">
                        <i class="las la-cut  display-3 text-secondary position-absolute o-1 translate-middle"></i>
                    </div><!--end col-->
                </div> <!-- end row -->
            </div><!--end card-body-->                                                               
        </div> <!--end card-->                     
    </div><!--end col-->
    <div class="col-12 col-md-4 col-lg-3"> 
        <div class="card overflow-hidden">                                
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">                                                                        
                        <span class="h4 fw-bold">{{ $requests->where('status','Completed')->count() }}</span>      
                        <h6 class="text-uppercase text-muted mt-2 m-0 font-11">Paid Requests</h6>                
                    </div><!--end col-->
                    <div class="col-auto">
                        <i class="las la-stethoscope  display-3 text-secondary position-absolute o-1 translate-middle"></i>
                    </div><!--end col-->
                </div> <!-- end row -->
            </div><!--end card-body-->                                                               
        </div> <!--end card-->                     
    </div><!--end col-->                   
</div><!--end row-->