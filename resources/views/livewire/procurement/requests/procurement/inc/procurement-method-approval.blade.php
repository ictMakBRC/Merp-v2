<?php
use App\Enums\ProcurementRequestEnum;
?>

@if (!$request->decisions->isEmpty())
    <div class="tab-content">
        <div class="table-responsive">
            <table class="table table-striped mb-0 w-100 sortable border">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('Handler') }}</th>
                        <th>{{ __('Step') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Procurement Method') }}</th>
                        <th>{{ __('Bid Return Deadline') }}</th>
                        <th>{{ __('Comment') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->decisions->where('step', ProcurementRequestEnum::PM_APPROVAL) as $key => $decision)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $decision->decision_maker }}</td>
                            <td>{{ $decision->step }}</td>
                            <td><span
                                    class="badge bg-{{ getProcurementRequestStatusColor($decision->decision) }}">{{ $decision->decision }}</span>
                            </td>
                            <td>{{ $request->procurement_method->method }}</td>
                            <td>@formatDate($request->bid_return_deadline)</td>
                            <td>{!! nl2br(e($decision->comment ?? 'N/A')) !!}</td>
                            <td>@formatDate($decision->decision_date)</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="tab-content">
        <div class="p-2">
            <h6>Selected Providers</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mb-0 w-100 sortable border">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('public.name') }}</th>
                        <th>{{ __('public.contact') }}</th>
                        <th>{{ __('public.email') }}</th>
                        <th>{{ __('Country') }}</th>
                        <th>{{ __('public.address') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($request->providers as $key=>$provider)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $provider->name }}
                            </td>
                            <td>{{ $provider->phone_number }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->country }}</td>
                            <td>{{ $provider->full_address }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endif
