<div>
    <div class="row">
        <h5 class="mb-2">
            {{ __('Selected Providers') }}
        </h5>
        <hr>
        <div class="row col-md-5">
            <div class="mb-3 col-md-12">
                <input class="form-control" id="search" wire:model.lazy="search" placeholder="Search provider/supplier"/>
            </div>

            <div class="mb-3 col-md-12 scrollable-div">
                <div class="list-group list-group-flush">
                    @forelse ($providers as $provider)
                        <div class="form-check list-group-item py-1 ms-2">
                            <input class="form-check-input" type="checkbox" value="{{ $provider->id }}"
                                id="provider{{ $provider->id }}" wire:model="providerIds">
                            <label class="form-check-label"
                                for="provider{{ $provider->id }}">{{ $provider->name }}</label>
                        </div>
                    @empty
                    <div>
                        {{ __('public.not_found') }}
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="row col-md-7">
            <div class="col-12">
                @if (!$selectedProviders->isEmpty())
                    <div class="table-responsive scrollabe-content scrollable">
                        <table class="table mb-0 w-100 sortable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>{{ __('public.name') }}</th>
                                    <th>{{ __('public.contact') }}</th>
                                    <th>{{ __('public.email') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($selectedProviders as $key=>$provider)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            {{ $provider->name }}
                                        </td>
                                        <td>{{ $provider->phone_number }}</td>
                                        <td>{{ $provider->email }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <button wire:click='detachProvider({{ $provider->id }})'
                                                    class="btn-outline-danger btn btn-sm"
                                                    title="{{ __('public.cancel') }}"><i class="ti ti-x"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert border-0 border-start border-5 border-warning alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-warning"><i class='bx bx-primary-circle'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-warning">{{ __('Providers') }}</h6>
                                <div>{{ __('public.not_found') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @if (count($providerIds))
                    <hr>
                    <div class="modal-footer">
                        <button class="btn btn-outline-success btn-sm"
                            wire:click='attachProviders'>{{ __('public.submit') }}</button>
                    </div>
                @endif --}}
            </div>

        </div>

    </div>

</div>
