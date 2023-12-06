  <div class="row row-cols-3 d-flex justify-content-md-between">
                        <div class="col-md-3 d-print-flex">
                            <div class="">
                                <h6 class="mb-0"><b>Invoice Date :</b> {{$invoice_data->due_date}}</h6>
                                <h6 class="mb-0"><b>Due Date :</b> {{$invoice_data->invoice_date}}</h6>
                                <h6><b>Invoice ID :</b> # {{$invoice_data->invoice_no}}</h6>
                            </div>
                        </div><!--end col--> 
                        <div class="col-md-3 d-print-flex">                                   
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Billed By :</strong><br>
                                    {{$biller->name??'N/A'}}<br>
                                    {{$biller->prefix??'N/A'}},
                                    {{$biller->description??'N/A'}}<br> 
                                </address>
                            </div>
                        </div><!--end col--> 
                        <div class="col-md-3 d-print-flex">
                            @if ($invoice_data->customer_id!=null)                                    
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14">Billed To:</strong><br>
                                        {{$billed->name??'N/A'}}<br>
                                        {{$billed->address??'N/A'}},
                                        {{$billed->nationality??'N/A'}}<br>
                                        <abbr title="Phone">P:</abbr> {{$billed->contact??'N/A'}}<br>
                                        <abbr title="Phone">Proj:</abbr> {{$invoice_data->project->name??'N/A'}}
                                    </address>
                                </div>
                            @else
                            
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Billed To:</strong><br>
                                    {{$billed->name??'N/A'}}<br>
                                    {{$billed->prefix??'N/A'}},
                                    {{$billed->description??'N/A'}}<br>                                   
                                </address>
                            </div>
                                
                            @endif
                        </div> <!--end col-->                       
                    </div><!--end row-->