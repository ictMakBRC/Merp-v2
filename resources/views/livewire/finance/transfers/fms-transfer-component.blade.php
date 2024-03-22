<div>
    <div class="row" x-data="{ filter_data: @entangle('filter'),create_new: @entangle('createNew') }">
        <div class="col-12">
            <div class="card">
                <div class="card-header pt-0">
                    <div class="row mb-2">
                        <div class="col-sm-12 mt-3">
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 mb-sm-0">
                                    Transfers (<span class="text-danger fw-bold">{{ $transfers->total() }}</span>)
                                    @include('livewire.layouts.partials.inc.filter-toggle')
                                </h5>
                                @include('livewire.layouts.partials.inc.create-resource-alpine')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{-- @include('livewire.finance.transfers.inc.new-transfer-form') --}}
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="row mb-0" @if (!$filter) hidden @endif>
                            <h6>Filter Transfers</h6>

                            <div class="mb-3 col-md-3">
                                <label for="is_active" class="form-label">Status</label>
                                <select wire:model="is_active" class="form-select select2" id="is_active">
                                    <option value="">Select</option>
                                    <option value="1">Active</option>
                                    <option value="0">Suspended</option>
                                </select>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Ref</th>
                                        <th>Date</th>
                                        <th>From Account</th>
                                        <th>To Account</th>
                                        <th>Amount</th>
                                        <th>Currency</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transfers as $key => $transfer)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $transfer->trx_ref }}</td>
                                            <td>{{ $transfer->trx_date??'N/A' }}</td>
                                            <td>{{ $transfer->project->name??$transfer->department->name??'N/A' }}</td>
                                            <td>@moneyFormat($transfer->estimated_income)</td>
                                            <td>@moneyFormat($transfer->estimated_expenditure)</td>
                                            <td>{{ $transfer->currency->code??'N/A' }}</td>
                                            @if ($transfer->is_active == 0)
                                                <td><span class="badge bg-danger">Suspended</span></td>
                                            @else
                                                <td><span class="badge bg-success">Active</span></td>
                                            @endif
                                            <td class="table-action">                                                  
                                                    {{-- @livewire('fms.partials.status-component', ['model' => $account, 'field' => 'is_active'], key($account->id)) --}}
                                                
                                                    <a  href="{{URL::signedRoute('finance-transfer_lines',$transfer->code)}}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a  href="{{URL::signedRoute('finance-transfer_view',$transfer->code)}}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="btn-group float-end">
                                    {{ $transfers->links('vendor.livewire.bootstrap') }}
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

   

@push('scripts')
   <script>
       window.addEventListener('close-modal', event => {
           $('#updateCreateModal').modal('hide');
           $('#delete_modal').modal('hide');
           $('#show-delete-confirmation-modal').modal('hide');
       });
       window.addEventListener('delete-modal', event => {
           $('#delete_modal').modal('show');
       });
   </script>
@endpush
</div>

