<div>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-body invoice-head"> 
                    <div class="row">
                        <div class="col-md-12 d-print-flex">
                            @include('livewire.partials.brc-header') 
                            </div>  
                    </div><!--end row-->     
                </div><!--end card-body-->
                <div class="card-body">
                    <div class="row row-cols-3 d-flex justify-content-md-between">
                        <div class="col-md-3 d-print-flex">
                            <div class="">
                                <a class="btn btn-outline-primary">INVOICE</a>
                                <h6 class="mb-0"><b>Due Date :</b> {{$invoice_data->invoice_date}}</h6>
                                <h6><b>Invoice ID :</b> # {{$invoice_data->invoice_no}}</h6>
                            </div>
                        </div><!--end col--> 
                        <div class="col-md-3 d-print-flex">                                            
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Billed Trom :</strong><br>
                                    {{$invoice_data->biller->name??'N/A'}}<br>
                                    {{$invoice_data->biller->prefix??'N/A'}},
                                    {{$invoice_data->biller->description??'N/A'}}<br> 
                                </address>
                            </div>
                        </div><!--end col--> 
                        <div class="col-md-3 d-print-flex">
                            @if ($invoice_data->customer_id!=null)                                    
                                <div class="">
                                    <address class="font-13">
                                        <strong class="font-14">Billed To:</strong><br>
                                        {{$invoice_data->customer->name??'N/A'}}<br>
                                        {{$invoice_data->customer->address??'N/A'}},
                                        {{$invoice_data->customer->nationality??'N/A'}}<br>
                                        <abbr title="Phone">P:</abbr> {{$invoice_data->customer->contact??'N/A'}}<br>
                                        <abbr title="Phone">Proj:</abbr> {{$invoice_data->project->name??'N/A'}}
                                    </address>
                                </div>
                            @else
                            
                            <div class="">
                                <address class="font-13">
                                    <strong class="font-14">Billed To:</strong><br>
                                    {{$invoice_data->department->name??'N/A'}}<br>
                                    {{$invoice_data->department->prefix??'N/A'}},
                                    {{$invoice_data->department->description??'N/A'}}<br>                                   
                                </address>
                            </div>
                                
                            @endif
                        </div> <!--end col-->                       
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive project-invoice">
                                <table class="table table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Project Breakdown</th>
                                            <th>Rate({{$invoice_data->currency->code??'UG'}})</th>
                                            <th>Qty</th> 
                                            <th>Subtotal({{$currency}})</th>
                                            <th>Action</th>
                                        </tr><!--end tr-->
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <form wire:submit.prevent='saveItem({{$invoice_data->id}})'>
                                                        
                                            <td>
                                                <select  id="item_id" wire:model='item_id' class="form-control-sm form-select">
                                                    <option value="">Select</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{$service->id}}">{{$service->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('item_id')<div class="text-danger text-small">{{ $message }}</div>@enderror
                                            </td>
                                            <td>
                                                <input type="number" step="any" id="unit_price" class="form-control" required readonly wire:model="unit_price">
                                                @error('unit_price')<div class="text-danger text-small">{{ $message }}</div> @enderror
                                            </td>
                                            <td> 
                                                <input type="number" min="1" id="quantity" class="form-control" required wire:model="quantity">
                                                @error('quantity')<div class="text-danger text-small">{{ $message }}</div> @enderror
                                            </td>
                                            <td>@moneyFormat($line_total)</td>
                                            <td><button type="submit" class="btn btn-success btn-sm">Add</button></td>
                                            </form>
                                        </tr><!--end tr-->
                                        @foreach ($items as $item)
                                            
                                        <tr>
                                            <td>
                                                <h5 class="mt-0 mb-1 font-14">{{$item->service->name??'N/A'}}</h5>
                                                <p class="mb-0 text-muted">{{$item->service->description??''}}</p>
                                            </td>
                                            <td>@moneyFormat($item->unit_price??0)</td>
                                            <td>{{$item->quantity??'N/A'}}</td>
                                            <td>@moneyFormat($item->line_total??0)</td>
                                            <td>                                                
                                                <a href="javascript:void(0)"  wire:click="confirmDelete('{{ $item->id }}')" class="text-danger">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr><!--end tr-->
                                        @endforeach
                                        <tr>                                                        
                                            <td colspan="2" class="border-0"></td>
                                            <td class="border-0 font-14 text-dark"><b>Sub Total</b></td>
                                            <td class="border-0 font-14 text-dark"><b></b>{{$currency}}@moneyFormat($totalAmount)</td>
                                            <td></td>
                                        </tr><!--end tr-->
                                        <tr>
                                            <th colspan="2" class="border-0"></th>                                                        
                                            <td class="border-0 font-14 text-dark"><b>Tax Rate ({{$currency}})</b></td>
                                            <td class="border-0 font-14 text-dark"><b>0.00%</b></td>
                                            <td></td>
                                        </tr><!--end tr-->
                                        <tr class="bg-black text-white">
                                            <th colspan="2" class="border-0"></th>                                                        
                                            <td class="border-0 font-14"><b>Total ({{$currency}})</b></td>
                                            <td class="border-0 font-14"><b>@moneyFormat($totalAmount)</b></td>
                                            <td>
                                            </td>
                                        </tr><!--end tr-->
                                    </tbody>
                                </table><!--end table-->
                            </div>  <!--end /div-->                                          
                        </div>  <!--end col-->                                      
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mt-4">Terms And Condition :</h5>
                            <ul class="ps-3">
                                <li><small class="font-12">All accounts are to be paid within 7 days from receipt of invoice. </small></li>
                                <li><small class="font-12">To be paid by cheque or credit card or direct payment online.</small ></li>
                                <li><small class="font-12"> If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</small></li>                                            
                            </ul>
                        </div> <!--end col-->                                       
                        <div class="col-lg-6 align-self-center">
                            <div class="float-none float-md-end" style="width: 30%;">
                                <small>Account Manager</small>
                                <img src="assets/images/signature.png" alt="" class="mt-2 mb-1" height="20">
                                <p class="border-top">Signature</p>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    <hr>
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 col-xl-4 ms-auto align-self-center">
                            <div class="text-center"><small class="font-12">Thank you very much for doing business with us.</small></div>
                        </div><!--end col-->
                        <div class="col-lg-12 col-xl-4">
                            <div class="float-end d-print-none mt-2 mt-md-0">
                                <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>
                                <a href="javascript:voide(0)" wire:click="submitInvoice({{$invoice_data->id}})" class="btn btn-de-primary btn-sm">Submit</a>
                                <a href="{{route('finance-invoices')}}" class="btn btn-de-danger btn-sm">Cancel</a>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div><!--end col-->
    </div><!--end row-->
    @include('livewire.partials.delete')
</div>
