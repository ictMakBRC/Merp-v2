<div class="tab-content">
    @include('livewire.procurement.settings.inc.providers-filter')

    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Phone Number') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Country') }}</th>
                    <th>{{ __('Procurements') }}</th>
                    <th>{{ __('Rating') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($providers as $key=>$provider)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$provider->name}}</td>
                        <td>{{$provider->provider_type}}</td>
                        <td>{{$provider->phone_number}}</td>
                        <td>{{$provider->email}}</td>
                        <td>{{$provider->country}}</td>
                        <td><span class="badge bg-success">{{$provider->procurement_requests->count()}}</span></td>
                        <td>
                            <strong
                            class="badge rounded-pill badge-outline-{{ getRatingColor(floor($provider->procurement_requests->avg('pivot.quality_rating'))) }}">{{ floor($provider->procurement_requests->avg('pivot.quality_rating')) }}
                            <i class="ti ti-star"></i>
                            {{ getQualityRatingText($provider->procurement_requests->avg('pivot.quality_rating')) }}</strong>
                        </td>
                        @if ($provider->is_active == 0)
                        <td><span class="badge bg-danger">Suspended</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        
                        <td>
                            <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-outline-success m-1"
                                        wire:click="loadProvider({{ $provider->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                <a href="{{ route('provider-profile', $provider->id) }}"
                                    class="btn btn-sm btn-outline-primary m-1"> <i class="ti ti-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- end preview-->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="btn-group float-end">
                {{-- {{ $providers->links('vendor.pagination.bootstrap-5') }} --}}
            </div>
        </div>
    </div>
</div> <!-- end tab-content-->
