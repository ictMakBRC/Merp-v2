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
                    <div class="row">
                        {{ $slot }}
                    </div>
                </div>
            </div><!--end card-->
            <div class="row d-flex justify-content-center">
                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0">
                        <a href="javascript:window.print()" class="btn btn-de-info btn-sm">Print</a>                       
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#actionModal"  class="btn btn-de-success btn-sm">Action</a>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end col-->
    </div><!--end row-->
</div>