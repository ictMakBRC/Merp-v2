<div>
    @include('livewire.human-resource.performance.exit-interviews.breadcrumps', [
    'heading' => '',
    ])
    <div class="container-fluid">
        <div class="row">
            <div class="col-5 row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <!--end col-->
                                <div class="col-lg-12 ms-auto">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4">Submission Date:</dt>
                                        <dd class="col-sm-8">
                                            @formatDate($exitInterview->created_at)
                                        </dd>
                                        <dt class="col-sm-4">Is Acknowledged:</dt>
                                        <dd class="col-sm-8">
                                            @if($exitInterview->acknowledged_at != null)
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
                </div>
                <!--end card-->
            </div>
            <!--end col-->
            <div class="col-7 row">
                @if($exitInterview->acknowledged_at == null)
                <div class="col-lg-12">
                    <div class="card">
                        <!--end card-header-->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12  align-self-center">
                                    <div class="row bg-light p-3">
                                        <div class="col-11 toast mb-2 fade show" role="alert" aria-live="assertive"
                                            aria-atomic="true">
                                            <div class="toast-body">
                                                Please acknowledge receipt of this exitInterviews.
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
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card" id="tourFaq">
                    <div class="card-header">
                        <h4 class="card-title">Most Commonly Asked Questions</h4>
                        <p class="text-muted mb-0">
                            The employee exit interview provides an opportunity for you to comment on your experience
                            as you leave MUK-BRC and allows us to learn from the positive and negative elements of your
                            experience and
                            refine areas requiring improvement. The following are the responses from the exit intervicew
                            tha was submitted
                        </p>
                    </div>
                    <!--end card-header-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <ul class="list-unstyled faq-qa">
                                    <li class="mb-5">
                                        <h6 class="">1. Why are you leaving the company?</h6>
                                        <p class="font-14 text-muted ms-3">
                                            {{$exitInterview->reason_for_exit ?? 'N/A'}}
                                        </p>
                                    </li>
                                    <li class="mb-5">
                                        <h6 class="">3. What has been good/enjoyable/satisfying in your time with us?
                                        </h6>
                                        <p class="font-14 text-muted ms-3">
                                            {{$exitInterview->experiences ?? 'N/A'}}
                                        </p>
                                    </li>

                                    <li class="mb-5">
                                        <h6 class="">5. Would you recommend this company to others as a good place to
                                            work? </h6>
                                        <p class="font-14 text-muted ms-3">
                                            {{$exitInterview->can_recommend_us == 1 ?
                                            'Yes' : 'No' }}
                                        </p>
                                    </li>
                                    @if($exitInterview->can_recommend_us == 0)
                                    <li class="mb-5">
                                        <h6 class="">7.If No to your answer in (6) please provide reasons</h6>
                                        <p class="font-14 text-muted ms-3">{{$exitInterview->reason_for_recommendation
                                            ?? 'N/A'
                                            }}
                                        </p>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="col-lg-6">
                                <ul class="list-unstyled faq-qa">
                                    <li class="mb-5">
                                        <h6 class="">2. What factors were important in your decision to move to a new
                                            company?</h6>
                                        <p class="font-14 text-muted  ms-3"> {{$exitInterview->factors_for_exit ??
                                            'N/A'}}
                                        </p>
                                    </li>
                                    <li class="mb-5">
                                        <h6 class="">4. What can you say about the processes, procedures or systems that
                                            have contributed to your decision to leave?</h6>
                                        <p class="font-14 text-muted ms-3">
                                            {{$exitInterview->processes_procedures_systems_for_exit ?? 'N/A'}}
                                        </p>
                                    </li>
                                    <li class="mb-5">
                                        <h6 class="">6.What improvements do you think can be made to the company as a
                                            whole?</h6>
                                        <p class="font-14 text-muted ms-3"> {{$exitInterview->improvements ?? 'N/A'}}
                                        </p>
                                    </li>

                                </ul>
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
            @include('livewire.human-resource.performance.exit-interviews.comments')
        </div>
        <!--end row-->

    </div>

    <!-- confirm acknowledgement modal -->
    @include('livewire.human-resource.performance.exit-interviews.acknowledgement-modal')
    <!--end modal-->
</div>