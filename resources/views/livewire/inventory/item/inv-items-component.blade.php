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
                  Commodities (<span class="text-danger fw-bold">{{ $data['items']->total() }}</span>)
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
              <label for="orderBy" class="form-label">OrderBy</label>
              <select wire:model="orderBy" class="form-select">
                <option value="name">Name</option>
                <option value="id">Latest</option>
              </select>
            </div>

          </x-table-utilities>
          <table id="datableButton" class="table table-striped mb-0 w-100 sortable">
            <thead>
              <tr>
                <th>#</th>
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
              @foreach($data['items'] as $value)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$value->name}}</td>
                <td>{{ $value->description}}</td>
                <td>{{ $value->category?->name}}</td>
                <td>{{ $value->min_qty}}</td>
                <td>{{ $value->max_qty}}</td>
                <td>{{ $value->date_added}}</td>

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
                <a href="javascript: void(0);" class="action-ico text-info mx-1"> <i
                  class="mdi mdi-pencil" data-bs-toggle="modal" data-bs-target="#addData"
                  wire:click="editdata({{ $value->id}})"
                  data-bs-target="#editcourier"></i></a>
                  <a href="javascript: void(0);"
                  wire:click="deleteConfirmation({{ $value->id }})" class="action-ico text-danger  mx-1">
                  <i class="mdi mdi-delete"></i></a>

                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div> <!-- end preview-->
        <div class="row mt-4">
          <div class="col-md-12">
            <div class="btn-group float-end">
              {{ $data['items']->links('vendor.livewire.bootstrap') }}
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
