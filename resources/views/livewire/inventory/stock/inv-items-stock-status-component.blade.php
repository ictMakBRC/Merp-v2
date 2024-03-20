<div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pt-0">
  
            <div class="row mb-2">
              <div class="col-sm-12 mt-3">
                <div class="d-sm-flex align-items-center">
                  <h5 class="mb-2 mb-sm-0">
                    Unit Item List (<span class="text-danger fw-bold">{{ $inventory_items->total() }}</span>)
                  </h5>
  
                  <div class="ms-auto">
                    <a type="button" class="btn btn-sm btn-outline-success me-2" wire:click="refresh()"><i class="mdi mdi-refresh"></i></a>
                    <a type="button" wire:click="createNew()" class="btn btn-sm me-2 btn-success">
                      <i class="fa fa-plus"></i>New
                    </a>
                  </div>
  
                </div>
              </div>
            </div>
  
            <div class="table-responsive">
              <x-table-utilities>
  
                <div class="mb-1 col-md-2">
                  <label for="department_id" class="form-label">Department</label>
                  <select @if ($type!='all') disabled @endif wire:model="unit_id" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($units as $key => $value)
                    <option value="{{$value->id}}">{{$value->name}}</option>
                    @endforeach
                  </select>
                </div>
  
                <div class="mb-1 col-md-2">
                  <label for="orderBy" class="form-label">OrderBy</label>
                  <select wire:model="orderBy" class="form-select">
                    <option value="id">Latest</option>
                  </select>
                </div>
  
              </x-table-utilities>
              <table id="datableButton" class="table table-bordered table-striped mb-0 w-100 sortable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Item Category</th>
                    <th>Brand</th>
                    @if ($type=='all')                        
                    <th>Unit</th>
                    @endif
                    <th>Qunatity</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($inventory_items as $key => $value)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->item?->name }}</td>
                    <td>{{ $value->item?->description }}</td>
                    <td>{{ $value->brand }}</td>
                    @if ($type=='all') 
                    <td>{{ $value->unitable?->name }}</td>
                    @endif
                    <td>{{ $value->qty_left }}</td>
                    <td class="table-action">
                      <a href="{{ URL::signedRoute('inventory-stock_card', $value->id) }}"  title="Edit"
                        class="action-ico btn-sm btn btn-outline-success mx-1">
                        <i class="fa fa-eye"></i></a>
                      </tr>
                      @endforeach
  
                    </tbody>
                  </table>
                </div> <!-- end preview-->
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="btn-group float-end">
                      {{ $inventory_items->links('vendor.livewire.bootstrap') }}
                    </div>
                  </div>
                </div>
              </div> <!-- end tab-content-->
            </div> <!-- end card body-->
          </div> <!-- end card -->
        </div><!-- end col-->
        @include('livewire.inventory.inc.confirm-delete')
        @push('scripts')
        <script>
          window.addEventListener('close-modal', event => {
            $('#deptItemupdateCreateModal').modal('hide');
            $('#delete_modal').modal('hide');
            $('#confirmDelete').modal('hide');
          });
          window.addEventListener('show-modal', event => {
            $('#deptItemupdateCreateModal').modal('show');
          });
          window.addEventListener('delete-modal', event => {
            $('#confirmDelete').modal('show');
          });
        </script>
        @endpush
  
      </div>
  