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
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('public.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($providers as $key=>$provider)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$provider->name}}</td>
                        <td>{{$provider->phone_number}}</td>
                        <td>{{$provider->provider_type}}</td>
                        <td>{{$provider->email}}</td>
                        <td>{{$provider->country}}</td>
                        @if ($provider->is_active == 0)
                        <td><span class="badge bg-danger">Suspended</span></td>
                        @else
                            <td><span class="badge bg-success">Active</span></td>
                        @endif
                        
                        <td></td>
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
