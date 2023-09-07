<div>
  {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">

          <div class="row mb-2">
            <div class="col-sm-12 mt-3">
              <div class="d-sm-flex align-items-center">
                <h5 class="mb-2 mb-sm-0">
                  Department Item List (<span class="text-danger fw-bold">{{ $dept_items->total() }}</span>)
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
                <select wire:model="department_id" class="form-select">
                  <option value="">All Departments</option>
                  @foreach($departments as $key => $value)
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
                  <th>Department / Lab</th>
                  <th>Date added</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($dept_items as $key => $value)
                <tr>
                  <td>{{$key+1}}</td>
                  <td>{{$value->item?->name }}</td>
                  <td>{{ $value->item?->description }}</td>
                  <td>{{ $value->brand }}</td>
                  <td>{{ $value->department?->name }}</td>
                  <td>{{ $value->created_at }}</td>

                  <td class="table-action">
                    @if($value->is_active==1)
                    <span class="badge bg-success">Active</span>
                    @elseif($value->is_active==0)
                    <span class="badge bg-danger">InActive</span>
                    @endif
                  </td>
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
                    {{ $dept_items->links('vendor.livewire.bootstrap') }}
                  </div>
                </div>
              </div>
            </div> <!-- end tab-content-->
          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->

      @include('livewire.inventory.item.inc.deptItemupdateCreateModal')
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
