<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeBankingInformation"
                        @else
                        wire:submit.prevent="updateBankingInformation" @endif>
        <div class="row">

            <div class="mb-3 col-md-4">
                <label for="bank_id" class="form-label required">Bank Name</label>
                <select class="form-select select2" id="bank_id" wire:model.lazy='bank_id'>
                    <option selected value="">Select</option>
                    @forelse ($banks as $bank)
                    <option value="{{$bank->id}}" >{{$bank->code}}</option>
                    @empty

                    @endforelse
                </select>
                @error('bank_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="branch" class="form-label required">Branch</label>
                <input type="text" id="branch" class="form-control" wire:model.defer='branch'>
                @error('branch')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_name" class="form-label required">Account Name</label>
                <input type="text" id="account_name" class="form-control" wire:model.defer='account_name'>
                @error('account_name')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="account_number" class="form-label required">Account Number</label>
                <input type="text" id="account_number" class="form-control" wire:model.defer='account_number'>
                @error('account_number')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency_id" wire:model.lazy='currency_id'>
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="is_default" class="form-label required">Is default account?</label>
                <select class="form-select select2" id="is_default" wire:model.lazy='is_default'>
                    <option value="" selected>Select</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error('is_default')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="modal-footer">

            <x-button class="btn btn-success">
                @if (!$toggleForm)
                    {{ __('public.save') }}
                @else
                    {{ __('public.update') }}
                @endif
            </x-button>
        </div>
    </form>

    <!--BANKING INFORMATION-->
    @if (!$bankingInformation->isEmpty())
        <div class="row">
            <div class="col-lg-12">
                <hr>
                {{-- <div class="text-sm-end mt-3">
                    <h4 class="header-title mb-3  text-center">BANKING INFORMATION</h4>
                </div> --}}
                <div class="table-responsive">
                    <table class="table table-striped w-100 mb-0  text-center">
                        <thead>
                            <tr>
                                <th>Bank Name</th>
                                <th>Branch</th>
                                <th>Account Name</th>
                                <th>Currency</th>
                                <th>Acct Number</th>
                                <th>State</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($bankingInformation as $bankingInfo)
                            <tr>
                                <td>
                                    {{ $bankingInfo->bank->name }}

                                </td>
                                <td>
                                    {{ $bankingInfo->branch ?? 'N/A' }}

                                </td>
                                <td>
                                    {{ $bankingInfo->account_name }}
                                </td>
                                <td>
                                    {{ $bankingInfo->currency->code }}
                                </td>
                                <td>
                                    {{ $bankingInfo->account_number }}
                                </td>
                                @if ($bankingInfo->is_default)
                                    <td><span class="badge bg-success">Primary</span></td>
                                @else
                                    <td><span class="badge bg-info">Secondary</span></td>
                                @endif

                                <td>
                                    <button class="btn btn btn-sm btn-outline-success"
                                        wire:click="editData({{ $bankingInfo->id }})" title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- end preview-->
            </div>
        </div>
    @endif
    <!-- end BANKING INFORMATION-->

</div>
