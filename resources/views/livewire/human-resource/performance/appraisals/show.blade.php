<div>
    @include('livewire.human-resource.performance.appraisals.breadcrumps', [
    'heading' => 'Edit',
    ])
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <dl class="row mb-0">
                                    <dt class="col-sm-3">Submitted by:</dt>
                                    <dd class="col-sm-9">{{$appraisal->owner->full_name}}
                                    </dd>
                                    <dt class="col-sm-4">Submission Date:</dt>
                                    <dd class="col-sm-8">
                                        @formatDate($appraisal->created_at)
                                    </dd>
                                    <dt class="col-sm-4">Is Acknowledged:</dt>
                                    <dd class="col-sm-8">
                                        @if($appraisal->acknowledged_at != null)
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
                @include('livewire.human-resource.performance.appraisals.attachments')
            </div>
            <!--end col-->
            @if($appraisal->acknowledged_at == null)
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
                                            Please acknowledge receipt of this appraisal.
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

            @livewire('comments.index', ['commentable' => $appraisal])


        </div>
        <!--end row-->

    </div>

    <!-- confirm acknowledgement modal -->
    @include('livewire.human-resource.performance.appraisals.acknowledgement-modal')
    <!--end modal-->
</div>
