<div class="card-header">
    <div class="row align-items-center">
        <div class="col">
            <h4 class="card-title">{{ __('Provider Rating') }}</h4>
        </div><!--end col-->
    </div> <!--end row-->
</div>

<div class="table-responsive">
    <table class="table table-striped mb-0 w-100 sortable border">
        <thead>
            <tr>
                <th>{{ __('Quality Rating / 5') }}</th>
                <th>{{ __('Timeliness Rating / 5') }}</th>
                <th>{{ __('Cost Rating / 5') }}</th>
                <th>{{ __('Average Rating / 5') }}</th>
                <th>{{ __('Comment') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong
                        class="badge rounded-pill badge-outline-{{ getRatingColor($request->bestBidders->first()->pivot->quality_rating) }}">{{ round($request->bestBidders->first()->pivot->quality_rating) }}
                        <i class="ti ti-star"></i>
                        {{ getQualityRatingText($request->bestBidders->first()->pivot->quality_rating) }}</strong>
                </td>
                <td>
                    <strong
                        class="badge rounded-pill badge-outline-{{ getRatingColor($request->bestBidders->first()->pivot->timeliness_rating) }}">{{ round($request->bestBidders->first()->pivot->timeliness_rating) }}
                        <i class="ti ti-star"></i>
                        {{ getTimelinessRatingText($request->bestBidders->first()->pivot->timeliness_rating) }}</strong>
                </td>
                <td>
                    <strong
                        class="badge rounded-pill badge-outline-{{ getRatingColor($request->bestBidders->first()->pivot->cost_rating) }}">{{ round($request->bestBidders->first()->pivot->cost_rating) }}
                        <i class="ti ti-star"></i>
                        {{ getCostRatingText($request->bestBidders->first()->pivot->cost_rating) }}</strong>
                </td>
                <td>
                    <strong
                        class="badge rounded-pill badge-outline-{{ getRatingColor($request->bestBidders->first()->pivot->average_rating) }}">{{ round($request->bestBidders->first()->pivot->average_rating) }}
                        <i class="ti ti-star"></i></strong>
                </td>
                <td>
                    {{ $request->bestBidders->first()->pivot->contracts_manager_comment }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
