<?php
use App\Enums\ProcurementRequestEnum;
?>
<div>
    @if ($request->bestBidders->first()->pivot->average_rating)
        @include('livewire.procurement.requests.contracts-manager.inc.provider-rating')
    @else
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Quality Rating <strong
                                class="badge rounded-pill badge-outline-success">{{ $quality_rating }}</strong></h4>
                        <p class="text-muted mb-0">Assess the quality and consistency of the products or services
                            provided by
                            the supplier. This may involve measuring defects, product specifications, or service
                            standards.
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <form>
                            <div class="starability-fade">
                                <input type="radio" id="fading-rate5" name="quality_rating" wire:model="quality_rating"
                                    value="1" />
                                <label for="fading-rate5" title="{{ ProcurementRequestEnum::POOR }}">1 star</label>

                                <input type="radio" id="fading-rate4" name="quality_rating"
                                    wire:model="quality_rating" value="2" />
                                <label for="fading-rate4" title="{{ ProcurementRequestEnum::FAIR }}">2 stars</label>

                                <input type="radio" id="fading-rate3" name="quality_rating"
                                    wire:model="quality_rating" value="3" />
                                <label for="fading-rate3" title="{{ ProcurementRequestEnum::GOOD }}">3 stars</label>

                                <input type="radio" id="fading-rate2" name="quality_rating"
                                    wire:model="quality_rating" value="4" />
                                <label for="fading-rate2" title="{{ ProcurementRequestEnum::VERY_GOOD }}">4
                                    stars</label>

                                <input type="radio" id="fading-rate1" name="quality_rating"
                                    wire:model="quality_rating" value="5" />
                                <label for="fading-rate1" title="{{ ProcurementRequestEnum::EXCELLENT }}">5
                                    star</label>
                            </div>
                        </form>
                    </div><!---end card-body-->
                </div><!--end card-->
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Timeliness Rating <span
                                class="badge rounded-pill badge-outline-success">{{ $timeliness_rating }}</span></h4>
                        <p class="text-muted mb-0">Evaluate the supplier's ability to meet agreed-upon delivery
                            schedules
                            and deadlines. Late deliveries can disrupt your supply chain
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <form>
                            <div class="starability-fade">

                                <input type="radio" id="fading-rate6" name="timeliness_rating"
                                    wire:model="timeliness_rating" value="1" />
                                <label for="fading-rate6" title="{{ ProcurementRequestEnum::VERY_LATE }}">1
                                    star</label>

                                <input type="radio" id="fading-rate7" name="timeliness_rating"
                                    wire:model="timeliness_rating" value="2" />
                                <label for="fading-rate7" title="{{ ProcurementRequestEnum::LATE }}">2 stars</label>

                                <input type="radio" id="fading-rate8" name="timeliness_rating"
                                    wire:model="timeliness_rating" value="3" />
                                <label for="fading-rate8" title="{{ ProcurementRequestEnum::ON_TIME }}">3 stars</label>

                                <input type="radio" id="fading-rate9" name="timeliness_rating"
                                    wire:model="timeliness_rating" value="4" />
                                <label for="fading-rate9" title="{{ ProcurementRequestEnum::EARLY }}">4 stars</label>

                                <input type="radio" id="fading-rate10" name="timeliness_rating"
                                    wire:model="timeliness_rating" value="5" />
                                <label for="fading-rate10" title="{{ ProcurementRequestEnum::VERY_EARLY }}">5
                                    star</label>
                            </div>
                        </form>
                    </div><!---end card-body-->
                </div><!--end card-->
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cost Rating <span
                                class="badge rounded-pill badge-outline-success">{{ $cost_rating }}</span></h4>
                        <p class="text-muted mb-0">Compare the supplier's prices and overall costs to industry standards
                            and
                            competitors. Ensure that you are getting value for your money.
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <form>
                            <div class="starability-fade">
                                <input type="radio" id="fading-rate11" name="cost_rating" wire:model="cost_rating"
                                    value="1" />
                                <label for="fading-rate11" title="{{ ProcurementRequestEnum::VERY_EXPENSIVE }}">1
                                    star</label>

                                <input type="radio" id="fading-rate12" name="cost_rating" wire:model="cost_rating"
                                    value="2" />
                                <label for="fading-rate12" title="{{ ProcurementRequestEnum::EXPENSIVE }}">2
                                    stars</label>

                                <input type="radio" id="fading-rate13" name="cost_rating" wire:model="cost_rating"
                                    value="3" />
                                <label for="fading-rate13" title="{{ ProcurementRequestEnum::MODERATE }}">3
                                    stars</label>

                                <input type="radio" id="fading-rate14" name="cost_rating" wire:model="cost_rating"
                                    value="4" />
                                <label for="fading-rate14" title="{{ ProcurementRequestEnum::CHEAP }}">4
                                    stars</label>

                                <input type="radio" id="fading-rate15" name="cost_rating" wire:model="cost_rating"
                                    value="5" />
                                <label for="fading-rate15" title="{{ ProcurementRequestEnum::VERY_CHEAP }}">5
                                    star</label>
                            </div>
                        </form>
                    </div><!---end card-body-->
                </div><!--end card-->
            </div>
            <div class=" col-md-6 row d-flex justify-content-center d-print-none">
                <div class="col-lg-12 col-xl-12 mb-2 ms-auto float-start">
                    <div class="text-center">
                        <textarea type="text" id="comment" class="form-control" wire:model.defer="comment" placeholder="Enter comment"
                            rows="6"></textarea>
                        @error('comment')
                            <div class="text-danger text-small">{{ $message }}</div>
                        @enderror
                    </div>
                </div><!--end col-->

                <div class="col-lg-12 col-xl-12">
                    <div class="float-end d-print-none mt-2 mt-md-0 mb-2">
                        <button class="btn btn-success" wire:click='storeRatings({{ $request_id }})'
                            onclick="return confirm('Are you sure you want to proceed?');">Save</button>

                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    @endif
</div>
