<div>
    @include('livewire.human-resource.grievances.breadcrumps', [
    'heading' => 'Edit',
    ])
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5 align-self-center">
                                <div class="media">

                                    <div class="media-body align-self-center">
                                        <h4 class="mt-0">{{$grievance->type->name}}</h4>
                                        <p class="mb-0 text-muted">
                                            {{$grievance->comment}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                            <div class="col-lg-5 ms-auto">
                                <dl class="row mb-0">
                                    <dt class="col-sm-3">Addressee:</dt>
                                    <dd class="col-sm-9">Rosa Dodson
                                    </dd>
                                    <dt class="col-sm-4">Submission Date:</dt>
                                    <dd class="col-sm-8">
                                        @formatDate($grievance->created_at)
                                    </dd>
                                    <dt class="col-sm-4">Is Acknowledged:</dt>
                                    <dd class="col-sm-8">
                                        @if($grievance->acknowledged_at != null)
                                        <span>Yes</span>
                                        @else
                                        <span>No</span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->

                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        <div class="row">
            <div class="col-lg-6">
                @include('livewire.human-resource.grievances.attachments')
            </div>
            <!--end col-->
            @if($grievance->acknowledged_at == null)
            <div class="col-lg-6">
                <div class="card">
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12  align-self-center">
                                <div class="row bg-light p-3">
                                    <div class="col-11 toast mb-2 fade show" role="alert" aria-live="assertive"
                                        aria-atomic="true">
                                        <div class="toast-body">
                                            Please acknowledge receipt of this grievance.
                                            <div class="mt-2 pt-2 border-top">
                                                <button type="button" wire:click="" data-bs-toggle="modal"
                                                    data-bs-target="#acknowledge_modal"
                                                    class="btn btn-de-primary btn-sm">Take
                                                    action</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            @endif

            @include('livewire.human-resource.grievances.comments')

        </div>
        <!--end row-->

    </div>

    <!-- confirm acknowledgement modal -->
    @include('livewire.human-resource.grievances.acknowledgement-modal')
    <!--end modal-->
</div>