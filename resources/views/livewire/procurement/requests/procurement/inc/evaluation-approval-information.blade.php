<?php
use App\Enums\ProcurementRequestEnum;
?>
<div>
    <div class="tab-content">
        <div class="table-responsive">
            <table class="table table-striped mb-0 w-100 sortable border">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>{{ __('Handler') }}</th>
                        <th>{{ __('Step') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Comment') }}</th>
                        <th>{{ __('Date') }}</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($request->decisions->where('step', ProcurementRequestEnum::ER_APPROVAL) as $key => $decision)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $decision->decision_maker }}</td>
                            <td>{{ $decision->step }}</td>
                            <td><span
                                    class="badge bg-{{ getProcurementRequestStatusColor($decision->decision) }}">{{ $decision->decision }}</span>
                            </td>
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
            <h6>Approved Best Bidder</h6>
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
                        <th>{{ __('Contract Price') }}</th>
                        {{-- <th>{{ __('Revised Price') }}</th> --}}
                        <th>{{ __('Delivery Deadline') }}</th>
                        <th>{{ __('Payment') }}</th>
                        <th>{{ __('Date Paid') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($request->providers->where('pivot.is_best_bidder', true) as $key=>$provider)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                {{ $provider->name }}
                            </td>
                            <td>{{ $provider->phone_number }}</td>
                            <td>{{ $provider->email }}</td>
                            <td>{{ $provider->country }}</td>
                            <td>{{ $provider->full_address }}</td>
                            <td>@moneyFormat($request->contract_value)</td>
                            {{-- <td>{{ $provider->pivot->bidder_revised_price ?? 'N/A' }}</td> --}}
                            <td>{{ $request->delivery_deadline ?? 'N/A' }}</td>
                            @if ($provider->pivot->payment_status)
                                <td><span class="badge bg-success">Paid</span></td>
                            @else
                                <td><span class="badge bg-danger">Not Paid</span></td>
                            @endif
                            <td>@formatDate($provider->pivot->date_paid??now())</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
