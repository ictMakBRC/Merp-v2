<div>
  {{-- Close your eyes. Count to one. That is how long forever feels. --}}
  <div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pt-0">

            <div class="row mb-2">
              <div class="col-sm-12 mt-3">
                <div class="d-sm-flex align-items-center">
                  <h5 class="mb-2 mb-sm-0">
                    @if (!$toggleForm)
                    Commodities (<span class="text-danger fw-bold">{{ $commodities->total() }}</span>)
                    {{-- @include('livewire.layouts.partials.inc.filter-toggle') --}}
                    @else
                    Edit category
                    @endif

                  </h5>
                  <!-- @include('livewire.layouts.partials.inc.create-resource') -->

                  <div class="ms-auto">
                    <a type="button" class="btn btn-sm btn-outline-success me-2" wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                    <a type="button" wire:click="createNewInv()" class="btn btn-sm me-2 btn-success">
                      <i class="fa fa-plus"></i>New
                    </a>
                  </div>

                </div>
              </div>
            </div>

            <div class="table-responsive">
              <x-table-utilities>
                <div class="mb-1 col-md-2">
                  <label for="category_id" class="form-label">Category</label>
                  <select wire:model="category_id" class="form-select">
                    <option value="">All categories</option>
                    @foreach($categories as $key => $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-1 col-md-2">
                  <label for="orderBy" class="form-label">OrderBy</label>
                  <select wire:model="orderBy" class="form-select">
                    <option value="name">Name</option>
                    <option value="id">Latest</option>
                  </select>
                </div>

              </x-table-utilities>
              <table id="datableButton" class="table table-bordered table-striped mb-0 w-100 sortable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>item Code</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Min Stock Qty</th>
                    <th>Max Stock Qty</th>
                    <th>Date added</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($commodities as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->item_code}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{ $value->description}}</td>
                    <td>{{ $value->category?->name}}</td>
                    <td>{{ $value->min_qty}}</td>
                    <td>{{ $value->max_qty}}</td>
                    <td>{{ $value->created_at}}</td>

                    <!-- <td class="table-action">
                    @if($value->is_active==1)
                    <span class="badge badge-success-lighten float-center">Active</span>
                    @php($satate='Active' AND $Stvalue=1)
                    @elseif($value->is_active==0)
                    <span class="badge badge-danger-lighten float-center">InActive</span>
                    @php($satate='InActive' AND $Stvalue=0)
                    @endif
                  </td> -->
                  <td class="table-action">
                    <button wire:click="editdata({{ $value->id }})" data-bs-toggle="modal"
                      data-bs-target="#deptItemupdateCreateModal" title="Edit"
                      class="action-ico btn-sm btn btn-outline-success mx-1">
                      <i class="fa fa-edit"></i></button>

                      <button wire:click="confirmDelete({{ $value->id }})" data-bs-toggle="modal"
                        data-bs-target="#confirmDelete" title="Delete"
                        class="action-ico btn-sm btn btn-outline-danger mx-1">
                        <i class="fa fa-trash"></i></button>
                      </td>
                  </tr>
                  @endforeach

                </tbody>
              </table>
            </div> <!-- end preview-->
            <div class="row mt-4">
              <div class="col-md-12">
                <div class="btn-group float-end">
                  {{ $commodities->links('vendor.livewire.bootstrap') }}
                </div>
              </div>
            </div>
          </div> <!-- end tab-content-->
        </div> <!-- end card body-->
      </div> <!-- end card -->
    </div><!-- end col-->
  </div>
  @include('livewire.inventory.item.inc.updateCreateModal')
  @push('scripts')
  <script>
    window.addEventListener('close-modal', event => {
      $('#updateCreateInvCommodityModal').modal('hide');
      $('#delete_modal').modal('hide');
      $('#show-delete-confirmation-modal').modal('hide');
    });
    window.addEventListener('show-modal', event => {
      $('#updateCreateInvCommodityModal').modal('show');
    });
  </script>
  @endpush
</div>

</div>
