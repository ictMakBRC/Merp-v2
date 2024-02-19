<div>
    {{-- The Master doesn't talk, he acts. --}}

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header pt-0">

              <div class="row mb-2">
                <div class="col-sm-12 mt-3">
                  <div class="d-sm-flex align-items-center">
                    <h5 class="mb-2 mb-sm-0">
                      @if (!$toggleForm)
                      Forecasts (<span class="text-danger fw-bold">  </span>)
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
                <table id="datableButton" class="table table-bordered table-striped mb-0 w-100 sortable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Forecast Code</th>
                      <th>Test Type</th>
                      <th>Item</th>
                      <th>Batch Size</th>
                      <th>Samples</th>
                      <th>Items Required</th>
                      <th>Forecast Date</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>


                  </tbody>
                </table>
              </div> <!-- end preview-->
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="btn-group float-end">

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
        $('#updateCreateInvCommodityModal').modal('hide');
        $('#delete_modal').modal('hide');
        $('#show-delete-confirmation-modal').modal('hide');
      });
      window.addEventListener('show-modal', event => {
        $('#updateCreateInvCommodityModal').modal('show');
      });
    </script>
    @endpush
