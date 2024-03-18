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
                                    {{$invoice_data->requestable->name??'MAKERERE UNIVERSITY BIOMEDICAL RESEARCH CENTRE'}}<br>
                                    {{$invoice_data->requestable->description??''}}
                                </address>
                            </div>
                        </div><!--end col--> 
                        <div class="col-md-3 d-print-flex">
                            
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Billed To:</strong><br>
                                    @if ($invoice_data == 'Opening Balance')                                        
                                    {{'MAKERERE UNIVERSITY BIOMEDICAL RESEARCH CENTRE'}}<br>
                                    {{'P.O BOX 75018 || Clock Tower Kampala, Uganda'}},
                                    @else
                                    {{$invoice_data->billtable->name??'N/A'}}<br>
                                    {{$billed->billtable->prefix??'N/A'}},
                                    {{$billed->billtable->description??''}}<br> 
                                    @if ($invoice_data->customer_id!=null) 
                                        <abbr title="Phone">P:</abbr> {{$invoice_data?->billtable->contact??'N/A'}}<br>
                                        <abbr title="Phone">Proj:</abbr> {{$invoice_data->project->name??'N/A'}} 
                                    @endif   
                                    @endif                              
                                </address>
                            </div>
                        </div> <!--end col-->                       
                    </div><!--end row-->