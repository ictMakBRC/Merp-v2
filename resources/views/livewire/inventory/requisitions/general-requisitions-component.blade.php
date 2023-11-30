<div>
  {{-- Stop trying to control. --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">

          <div class="row mb-2">
            <div class="col-sm-12 mt-3">
              <div class="d-sm-flex align-items-center">
                <h5 class="mb-2 mb-sm-0">
                  General Requests
                </h5>
                <!-- @include('livewire.layouts.partials.inc.create-resource') -->

                <div class="ms-auto">
                  <a type="button" class="btn btn-sm btn-outline-success me-2" wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                  <a type="button" wire:click="newRequest" class="btn btn-sm me-2 btn-success">
                    <i class="fa fa-plus"></i>New
                  </a>
                </div>

              </div>
            </div>
          </div>

          <div class="table-responsive">
            <x-table-utilities>
              <div class="mb-1 col-md-2">
                <label for="orderBy" class="form-label">OrderBy</label>
                <select wire:model="orderBy" class="form-select">
                  <option value="request_code">Request Code</option>
                  <option value="id">Latest</option>
                </select>
              </div>

              <div class="mb-1 col-md-2">
                <label for="request_status" class="form-label">Status</label>
                <select wire:model="request_status" class="form-select">
                  <option value="">View all</option>
                  <option value=0>Pending HoD Approval</option>
                  <option value=1>Approved by HoD</option>
                  <option value=2>Declined by HoD</option>
                  <option value=3>Approved by Stores</option>
                  <option value=4>Rejected by Stores</option>
                  <option value=5>Issued & Dispatched</option>
                  <option value=6>Received by Dept</option>
                  <option value=7>Canceled</option>
                </select>
              </div>

              <div class="mb-1 col-md-2">
                <label for="department" class="form-label">Deparment</label>
                <select wire:model="department" class="form-select">
                  <option value="">select</option>
                  @foreach ($departments as $key => $value)
                  <option value="{{$value->id}}">{{$value->name}}</option>
                  @endforeach
                </select>
              </div>

            </x-table-utilities>
            <table id="datableButton" class="table table-bordered table-striped mb-0 w-100 sortable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Request Code</th>
                  <th>Request Type</th>
                  <th>Item</th>
                  <th>Quantity Requested</th>
                  <th>Requested By</th>
                  <th>Department</th>
                  <th>Request Date</th>
                  <th>Dept. Approver</th>
                  <th>Status</th>

                  @if($request_status == 5)
                  <th>Issued By</th>
                  <th>Quantity Issued</th>
                  <th>Date Issued</th>
                  @endif

                  @if($request_status == 6)
                  <th>Received By</th>
                  <th>Quantity Received</th>
                  <th>Date Received</th>
                  <th>Reception Comment</th>
                  @endif

                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($requests as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->request_code}}</td>
                  <td>
                    @if($value->order_type == 0)
                    <span class="badge bg-warning rounded-pill">Consumption Based</span>
                    @elseif($value->order_type == 1)
                    <span class="badge bg-info rounded-pill">General Request</span>
                    @endif
                  </td>
                  <td>{{ $value->item?->name}}</td>
                  <td>{{ $value->quantity_required}}</td>
                  <td>{{ $value->orderedBy?->employee?->fullName }}</td>
                  <td>{{ $value->department?->name}}</td>
                  <td>{{ $value->created_at}}</td>
                  <td>{{ $value->approver?->surname }} {{ $value->approver?->first_name }}</td>
                  <td>
                    @if($value->status == 0)
                    <span class="badge bg-secondary rounded-pill">Pending HoD Approval</span>
                    @elseif($value->status == 1)
                    <span class="badge bg-info rounded-pill">Approved by HoD</span>
                    @elseif($value->status == 2)
                    <span class="badge bg-danger rounded-pill">Declined by HoD</span>
                    @elseif($value->status == 3)
                    <span class="badge bg-info rounded-pill">Approved by Stores</span>
                    @elseif($value->status == 4)
                    <span class="badge bg-danger rounded-pill">Rejected by Stores</span>
                    @elseif($value->status == 5)
                    <span class="badge bg-warning rounded-pill">Issued & Dispatched</span>
                    @elseif($value->status == 6)
                    <span class="badge bg-success rounded-pill">Received by Dept</span>
                    @elseif($value->status == 7)
                    <span class="badge bg-danger rounded-pill">Canceled</span>
                    @endif
                  </td>
                  @if($request_status == 5)
                  <td>{{ $value->dispatchedBy?->employee?->fullName }}</td>
                  <td>{{ $value->quantity_dispatched}}</td>
                  <td>{{ $value->dispatch_date}}</td>
                  @endif

                  @if($request_status == 6)
                  <td>{{ $value->receivedBy?->employee?->fullName }}</td>
                  <td>{{ $value->quantity_received_at_lab}}</td>
                  <td>{{ $value->date_received}}</td>
                  <td>{{ $value->reception_comment}}</td>
                  @endif

                  <td class="table-action">
                    @if($value->status == 0) <!--if request is pending approval or rejection by HoD  -->
                    <button wire:click="editData({{ $value->id }})"  title="Update"
                      class="action-ico btn-sm btn btn-outline-success mx-1">
                      <i class="fa fa-edit"></i></button>

                      <button wire:click="HodApproveRequest({{ $value->id }})" title="Approve"
                        class="action-ico btn-sm btn btn-outline-info mx-1">
                        <i class="fa fa-check-double"></i></button>

                        <button wire:click="rejectRequest({{ $value->id }})" title="Decline"
                          class="action-ico btn-sm btn btn-outline-danger mx-1">
                          <i class="fa fa-thumbs-down"></i></button>
                          @endif

                          @if($value->status == 1)
                          <button wire:click="storeApproveRequest({{ $value->id }})" title="Approve"
                            class="action-ico btn-sm btn btn-outline-success mx-1">
                            <i class="fa fa-thumbs-up"></i></button>

                            <button wire:click="rejectRequest({{ $value->id }})" title="Decline"
                              class="action-ico btn-sm btn btn-outline-danger mx-1">
                              <i class="fa fa-thumbs-down"></i></button>
                              @endif

                              @if($value->status == 3)
                              <button wire:click="issueStock({{ $value->id }})" title="Issue out"
                                class="action-ico btn-sm btn btn-outline-success mx-1">
                                <i class="fa fa-share-square"></i></button>
                                @endif

                              @if($value->status == 5)
                              <button wire:click="receiveAllocatedStock({{ $value->id }})" title="Receive"
                                class="action-ico btn-sm btn btn-outline-success mx-1">
                                <i class="fas fa-flag-checkered"></i></button>

                              <button wire:click="issueStock({{ $value->id }})" title="Decline"
                                class="action-ico btn-sm btn btn-danger mx-1">
                                <i class="fas fa-thumbs-down"></i></button>
                                @endif

                                @if($value->status == 0 && $value->ordered_by == \Auth::user()->id)
                                <button wire:click="cancelRequest( {{$value->id}} )" title="Cancel"
                                  class="action-ico btn-sm btn btn-outline-danger mx-1">
                                  <i class="fa fa-ban"></i></button>
                                  @endif
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div> <!-- end preview-->
                        <div class="row mt-4">
                          <div class="col-md-12">
                            <div class="btn-group float-end">
                              {{ $requests->links('vendor.livewire.bootstrap') }}
                            </div>
                          </div>
                        </div>
                      </div> <!-- end tab-content-->
                    </div> <!-- end card body-->
                  </div> <!-- end card -->
                </div><!-- end col-->

                @include('livewire.inventory.inc.confirm-cancel')
                @include('livewire.inventory.requisitions.inc.reject-request')
                @include('livewire.inventory.requisitions.inc.issue-item-modal')
                @include('livewire.inventory.requisitions.inc.new-general-request-modal')

                @push('scripts')
                <script>
                  window.addEventListener('close-modal', event => {
                    $('#confirmCancel').modal('hide');
                    $('#issueItemModal').modal('hide');
                    $('#newgeneralRequest').modal('hide');
                    $('#rejectRequestModal').modal('hide');
                  });
                  window.addEventListener('show-modal', event => {
                    $('#newgeneralRequest').modal('show');
                  });
                  window.addEventListener('new-request-modal', event => {
                    $('#newgeneralRequest').modal('show');
                  });
                  window.addEventListener('reject-request-modal', event => {
                    $('#rejectRequestModal').modal('show');
                  });
                  window.addEventListener('confirm-cancel-modal', event => {
                    $('#confirmCancel').modal('show');
                  });
                  window.addEventListener('issue-item-modal', event => {
                    $('#issueItemModal').modal('show');
                  });
                </script>
                @endpush
              </div>
