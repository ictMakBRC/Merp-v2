<div>
    @include('livewire.human-resource.performance.exit-interviews.breadcrumps', [
    'heading' => 'Create',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <form wire:submit.prevent="store">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label for="letter" class="form-label required">Why are you leaving the
                                            company?</label>
                                        <input type="text" id="reason_for_exit" rows="4" class="form-control"
                                            wire:model.defer="reason_for_exit" placeholder="" />


                                        @error('reason_for_exit')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="letter" class="form-label required">What factors were important in
                                            your decision to move to a new company?</label>
                                        <textarea type="text" id="factors_for_exit" rows="4" class="form-control"
                                            wire:model.defer="factors_for_exit" placeholder="">
                                        </textarea>

                                        @error('factors_for_exit')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="letter" class="form-label required">What can you say about the
                                            processes, procedures or systems that have contributed to your decision to
                                            leave?</label>
                                        <textarea type="text" id="processes_procedures_systems_for_exit" rows="4"
                                            class="form-control"
                                            wire:model.defer="processes_procedures_systems_for_exit" placeholder="">
                                        </textarea>

                                        @error('factors_for_exit')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="experiences" class="form-label required">What has been
                                            good/enjoyable/satisfying in your time with us?</label>
                                        <textarea type="text" id="experiences" rows="4" class="form-control"
                                            wire:model.defer="experiences" placeholder="">
                                        </textarea>

                                        @error('experiences')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label for="improvements" class="form-label required">What improvements do you
                                            think can be made to the company as a whole?</label>
                                        <textarea type="text" id="improvements" rows="4" class="form-control"
                                            wire:model.defer="improvements" placeholder="">
                                        </textarea>

                                        @error('improvements')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-md-3 my-2 form-label required control-label">Would you
                                            recommend
                                            this company to others as a good place to work? </label>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios"
                                                    id="exampleRadios1" value="yes" wire:model="can_recommend_us">
                                                <label class="form-check-label" for="exampleRadios1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="exampleRadios"
                                                    id="exampleRadios2" value="no" wire:model="can_recommend_us">
                                                <label class="form-check-label" for="exampleRadios2">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        @error('can_recommend_us')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @if($can_recommend_us == 'no')
                                    <div class="mb-3 col-md-12">
                                        <label for="reason_for_recommendation" class="form-label required">
                                            Please provide reasons.</label>
                                        <textarea type="text" id="reason_for_recommendation" rows="4"
                                            class="form-control" wire:model.defer="reason_for_recommendation"
                                            placeholder="">
                                        </textarea>

                                        @error('reason_for_recommendation')
                                        <div class="text-danger text-small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <a href="{{route('warnings')}}" class="btn btn-danger me-2">{{
                                        __('public.cancel') }}</a>
                                    <x-button class="btn-primary">{{ __('public.save') }}</x-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
</div>