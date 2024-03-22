<div>
    <form wire:submit.prevent="initiatePaymentRequest">
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="net_payment" class="form-label required">{{ __('Percentage Payment') }}</label>
                <input type="number" id="net_payment" class="form-control" wire:model.defer="net_payment" step="0.01" @if ($read_only)
                    readonly
                @endif>
                @error('net_payment')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-8">
                <label for="payment_description" class="form-label">{{ __('Payment Description/Remarks') }}</label>
                <textarea id="payment_description" class="form-control" wire:model.defer="payment_description"></textarea>
                @error('payment_description')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

        </div>
        @if ($request->net_payment_terms < 100)
            <div class="modal-footer">
                <x-button type="submit"
                    class="btn btn-success">{{ __('Initial Payment
                                    Request') }}</x-button>
            </div>
        @endif

    </form>

    <hr>
    <div class="table-responsive">
        <table class="table table-striped mb-0 w-100 sortable">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Ref</th>
                    <th>Type</th>
                    <th>%tage Payment</th>
                    <th>Date</th>
                    <th>From Unit</th>
                    <th>Trx Amount</th>
                    <th>Rate</th>
                    <th>Currency</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($request->payment_requests as $key => $request)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $request->request_code }}</td>
                        <td>{{ $request->request_type }}</td>
                        <td>{{ $request->net_payment_terms }}</td>
                        <td>@formatDate($request->created_at)</td>
                        <td>{{ $request->requestable->name }}</td>
                        <td>@moneyFormat(($request->net_payment_terms/100)*$request->total_amount)</td>
                        <td>@moneyFormat($request->rate)</td>
                        <td>{{ $request->currency->code ?? 'N/A' }}</td>
                        <td><span class="badge bg-success">{{ $request->status }}</span></td>
                        <td class="table-action">
                            <a href="{{ URL::signedRoute('finance-request_preview', $request->request_code) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div> <!-- end preview-->
</div>
