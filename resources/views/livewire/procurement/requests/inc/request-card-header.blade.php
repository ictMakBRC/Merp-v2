<div class="card-header">
    <div class="row align-items-center">
        <div class="col">
            <h5 class="mb-2 mb-sm-0">
                {{ __('Procurements Request') }} <span class="badge bg-{{ getProcurementRequestStatusColor($request->status) }}">{{$request->reference_no}}</span> 
            </h5>
        </div><!--end col-->
        <div class="col-auto">
            <span class="badge rounded-pill badge-outline-primary">{{$request->requestable->name}}</span> 
        </div><!--end col-->
    </div> <!--end row-->
</div>