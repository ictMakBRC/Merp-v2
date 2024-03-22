<div>
    @include('livewire.human-resource.employee-data.inc.loading-info')

    <form
        @if (!$toggleForm) wire:submit.prevent="storeOfficialContractInformation"
                        @else
                        wire:submit.prevent="updateOfficialContractInformation" @endif>
        <div class="row">
            <div class="mb-3 col-md-4">
                <label for="contract_summary" class="form-label required">Contract summary</label>
                <textarea type="text" id="contract_summary" class="form-control" wire:model.defer="contract_summary"></textarea>
                @error('contract_summary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="salary" class="form-label required">Gross Salary</label>
                <input type="number" id="gsalary" class="form-control" wire:model.defer="gross_salary">
                @error('gross_salary')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="currency_id" class="form-label required">Currency</label>
                <select class="form-select select2" id="currency_id" wire:model.defer="currency_id">
                    <option selected value="">Select</option>
                    @include('layouts.currencies')
                </select>
                @error('currency_id')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="end_date" class="form-label required">From</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="start_date">
                @error('start_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-2">
                <label for="end_date" class="form-label required">To</label>
                <input type="date" id="end_date" class="form-control" wire:model.defer="end_date">
                @error('end_date')
                    <div class="text-danger text-small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 col-md-4">
                <label for="contract_file1{{ $employee_id }}" class="form-label">Contract</label>
                <input type="file" id="contract_file1{{ $employee_id }}" class="form-control"
                    wire:model.lazy="contract_file" accept=".pdf">
                <div class="text-success text-small" wire:loading wire:target="contract_file">Uploading contract
                </div>
                @error('contract_file')
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

    <!--OFFICIAL CONTRACTS-->
    @if (!$officialContracts->isEmpty())
        <div class="row">
            <div class="col-lg-12">
                <hr>
                <div class="table-responsive">
                    <table class="table w-100 mb-0 table-striped text-center">
                        <thead>
                            <tr>
                                <th>Contract Summary</th>
                                <th>From</th>
                                <th>To</th>
                                <th>G-Pay</th>
                                <th>Contract</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach ($officialContracts as $officialContract)
                            <tr>
                                <td>
                                    {{ $officialContract->contract_summary }}
                                </td>
                                <td>
                                    @formatDate($officialContract->start_date)
                                </td>
                                <td>
                                    @formatDate($officialContract->end_date)
                                </td>
                                <td>
                                    {{$officialContract->currency->code}} @moneyFormat($officialContract->gross_salary)

                                </td>
                                <td class="table-action text-center">
                                    <a href="#"
                                        class="btn-outline-success no-print"><i
                                            class="ti ti-download"></i></a>

                                </td>
                                <td>
                                    <button class="btn btn btn-sm btn-outline-success"
                                        wire:click="editData({{ $officialContract->id }})"
                                        title="{{ __('public.edit') }}">
                                        <i class="ti ti-edit fs-18"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div> <!-- end preview-->
            </div>
        </div>
    @endif
    <!-- end OFFICIAL CONTRACTS-->

</div>
