<div class="bg-light">
    <div class="row row-cols-3 d-flex justify-content-md-between p-2">
        <div class="col-md-3 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Code') }}:
                </strong>{{ $provider->provider_code ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Provider Type') }}:
                </strong>{{ $provider->provider_type ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Telephone Number') }}:
                </strong>{{ $provider->phone_number ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Alternative Contact') }}:
                </strong>{{ $provider->alt_phone_number ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Email') }}:
                </strong>{{ $provider->email ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Alternative Email') }}:
                </strong>{{ $provider->alt_email ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Full address') }}: </strong>
                {{ $provider->full_address }}<br>
            </div>
        </div><!--end col--> 
        <div class="col-md-3 d-print-flex">                                            
            <div>
                <strong class="text-inverse">{{ __('Contact  Person') }}:
                </strong>{{ $provider->contact_person ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Contact  Person Phone') }}:
                </strong>{{ $provider->contact_person_phone }} <br>
                <strong class="text-inverse">{{ __('Contact  Person email') }}:
                </strong>{{ $provider->contact_person_email ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Web address') }}:
                </strong>{{ $provider->website ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Country') }}:
                </strong>{{ $provider->country ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Preferred Payment Terms') }}:
                </strong>{{ $provider->payment_terms ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Preferred Payment Method') }}:
                </strong>{{ $provider->payment_method ?? 'N/A' }}<br>
            </div>
        </div><!--end col-->

        <div class="col-md-3 d-print-flex">
            <div>
                <strong class="text-inverse">{{ __('Bank Name') }}:
                </strong>{{ $provider->bank_name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Branch') }}:
                </strong>{{ $provider->branch ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Account Name') }}:
                </strong>{{ $provider->account_name ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Bank Account') }}:
                </strong>{{ $provider->bank_account ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('TIN') }}:
                </strong>{{ $provider->tin ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Tax withhold rate') }}:
                </strong>{{ $provider->tax_withholding_rate ?? 'N/A' }}<br>
                <strong class="text-inverse">{{ __('Preferred Currency') }}:
                </strong>{{ $provider->currency->code ?? 'N/A' }}<br>
            </div>
        </div> <!--end col-->                       
    </div><!--end row-->

    <table class="table">
        <tr>
            @if ($provider->notes!=null)
            <td><p>
                {{ $provider->notes ?? 'N/A' }}
            </p>
            </td>
            @endif
           
        </tr>
    </table>

    @if (!$provider->documents->isEmpty())
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h4 class="card-title">{{ __('Documents') }}</h4>
                </div><!--end col-->
            </div> <!--end row-->
        </div>

        <div class="tab-content scrollable-di">
            <div class="table-responsive">
                <table class="table table-striped mb-0 w-100 sortable border">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('File') }}</th>
                            <th>{{ __('Description') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($provider->documents as $key => $document)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $document->document_category }}</td>
                                <td>{{ $document->document_name }}</td>
                                <td>
                                    {{-- {{ $document->document_path }} --}}
                                    @if ($document->document_path != null)
                                        <button wire:click='downloadDocument({{ $document->id }})'
                                            class="btn text-success" title="{{ __('public.download') }}"><i
                                                class="ti ti-download"></i></button>
                                    @else
                                        N/A
                                    @endif

                                </td>
                                <td>{!! nl2br(e($document->description)) !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if (!$provider->procurement_requests->isEmpty())
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="card-title">{{ __('Procurement History') }}</h4>
            </div><!--end col-->
        </div> <!--end row-->
    </div>

    <div class="table-responsiv">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Reference No') }}</th>
                    <th>{{ __('Request Type') }}</th>
                    <th>{{ __('Source') }}</th>
                    <th>{{ __('Category') }}</th>
                    <th>{{ __('Contract Value') }}</th>
                    <th>{{ __('#Invoice No') }}</th>
                    <th>{{ __('#LPO No') }}</th>
                    <th>{{ __('Average Rating') }}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($provider->procurement_requests as $key => $procurementRequest)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <a href="{{ route('proc-dept-request-details', $procurementRequest->id) }}" target="__blank">{{$procurementRequest->reference_no}}</a></td>
                        <td>{{ $procurementRequest->request_type }}</td>
                        <td>{{ $procurementRequest->requestable->name }}</td>
                        <td>{{ $procurementRequest->procurement_sector ?? 'N/A' }}</td>
                        <td>{{ $procurementRequest->currency->code }} @moneyFormat($procurementRequest->contract_value)</td>
                        <td>{{ $procurementRequest->pivot->invoice_no }}</td>
                        <td>{{ $procurementRequest->lpo_no }}</td>
                        <td>
                            <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($procurementRequest->pivot->quality_rating)) }}">{{ floor($procurementRequest->pivot->quality_rating) }}
                            <i class="ti ti-star"></i>
                            {{ getQualityRatingText($procurementRequest->pivot->quality_rating) }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> <!-- end preview-->

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
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($provider->procurement_requests->avg('pivot.quality_rating'))) }}">{{ floor($provider->procurement_requests->avg('pivot.quality_rating')) }}
                            <i class="ti ti-star"></i>
                            {{ getQualityRatingText($provider->procurement_requests->avg('pivot.quality_rating')) }}</strong>
                    </td>
                    <td>
                        <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($provider->procurement_requests->avg('pivot.timeliness_rating'))) }}">{{ floor($provider->procurement_requests->avg('pivot.timeliness_rating')) }}
                            <i class="ti ti-star"></i>
                            {{ getTimelinessRatingText($provider->procurement_requests->avg('pivot.timeliness_rating')) }}</strong>
                    </td>
                    <td>
                        <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($provider->procurement_requests->avg('pivot.cost_rating'))) }}">{{ floor($provider->procurement_requests->avg('pivot.cost_rating')) }}
                            <i class="ti ti-star"></i>
                            {{ getCostRatingText($provider->procurement_requests->avg('pivot.cost_rating')) }}</strong>
                    </td>
                    <td>
                        <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($provider->procurement_requests->avg('pivot.average_rating'))) }}">{{ floor($provider->procurement_requests->avg('pivot.average_rating')) }}
                            <i class="ti ti-star"></i></strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endif

</div>