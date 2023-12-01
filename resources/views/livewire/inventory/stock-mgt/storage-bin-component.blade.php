{{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
<div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">
          <div class="row mb-2">
            <div class="col-sm-12 mt-3">

              <div class="d-sm-flex align-items-center">
                <h5 class="mb-2 mb-sm-0">
                  {{ __('logistics.storage_bins') }}
                </h5>
                <div class="ms-auto">
                  <div class="ms-auto">
                    <a type="button" class="btn btn-outline-success me-2" wire:click="refresh()"><i class="bx bx-revision"></i></a>
                    <a type="button" class="btn me-2 btn-success" data-bs-toggle="modal" data-bs-target="#addBin">
                      <i class="bx bx-plus"></i>{{__('New')}}
                    </a>
                  </div>
                </div>
                </div>

              </div>
            </div>

          <div class="card-body">

            <x-table-utilities>
              <div class="mb-1 col-md-2">
                <label for="orderBy" class="form-label">OrderBy</label>
                <select wire:model="orderBy" class="form-control">
                  <option value="bin_name">Storage Bin</option>
                  <option value="id">Latest</option>
                </select>
              </div>
            </x-table-utilities>

            <div class="tab-content">
              <div class="table-responsive">
                <table id="datableButton" class="table table-striped table-bordered mb-0 w-100 sortable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('logistics.storage_bin') }}</th>
                      <th>{{ __('logistics.storage_section') }} </th>
                      <th>{{ __('logistics.storage_type') }} </th>
                      <th>{{ __('logistics.Description') }} </th>
                      <th>{{ __('logistics.action') }} </th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($storage_bins as $key => $value)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $value->bin_name }}</td>
                      <td>{{ $value->StorageSection->name }}</td>
                      <td>{{ $value->StorageType->name }}</td>
                      <td>{{ $value->description }}</td>

                      <td>
                        <div class="d-flex table-actions">
                          <a href="javascript: void(0);"
                          class="action-ico btn-outline-primary text-primary mx-1 bx bx-edit-alt"
                          wire:click="editData({{ $value->id }})"   data-bs-target="#editBin"  title="{{__('public.edit')}}"></a>
                        </div>
                        <!--
                        <a href="javascript: void(0);"
                        wire:click="deleteConfirmation({{ $value->id }})"
                        class="action-ico btn btn-outline-danger">
                        <i class="bx bx-trash"></i></a> -->

                      </td>

                    </tr>
                    @endforeach

                  </tbody>
                </table>
              </div> <!-- end preview-->
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="btn-group float-end">
                    {{ $storage_bins->links('vendor.livewire.bootstrap') }}
                  </div>
                </div>
              </div>
            </div> <!-- end tab-content-->

          </div> <!-- end card body-->
        </div> <!-- end card -->
      </div><!-- end col-->

      {{-- ADD COMMODITY --}}
      <div wire:ignore.self class="modal fade" id="addBin" data-bs-backdrop="static" data-bs-keyboard="false"
      tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">{{ __('logistics.storage_bin') }} </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"
            wire:click="close()"></button>
          </div> <!-- end modal header -->
          <div class="modal-body">
            <form wire:submit.prevent="store">

              <div class="row">

                <div class="mb-3 col-md-6">
                  <label for="bin_name"
                  class="form-label required">{{ __('logistics.storage_bin') }} </label>
                  <input type="text" id="bin_name" class="form-control" wire:model.defer="bin_name">
                  @error('bin_name')
                  <div class="text-danger text-small">{{ __($message) }}</div>
                  @enderror
                </div>

                <div class="mb-3 col-md-6">
                  <label for="storage_type_id" class="form-label required">{{ __('logistics.storage_type') }} </label>
                  <select class="form-control" wire:model.defer="storage_type_id">
                    <option value="" selected>{{ __('logistics.select') }}...</option>
                    @foreach ($storage_types as $data)
                    <option value="{{ $data->id }}">
                      {{ $data->name }}
                    </option>
                    @endforeach
                  </select>

                  @error('storage_type_id')
                  <div class="text-danger text-small">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3 col-md-6">
                  <label for="storage_section_id" class="form-label required">{{ __('logistics.storage_section') }} </label>
                  <select class="form-control" wire:model.defer="storage_section_id">
                    <option value="" selected>{{ __('logistics.select') }}...</option>
                    @foreach ($storage_sections as $data)
                    <option value="{{ $data->id }}">
                      {{ $data->name }}
                    </option>
                    @endforeach
                  </select>

                  @error('storage_section_id')
                  <div class="text-danger text-small">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3 col-md-6">
                  <label for="description"
                  class="form-label">{{ __('logistics.description') }}</label>
                  <textarea class="form-control" wire:model.defer="description"></textarea>

                </div>
              </div>
              <!-- end row-->
              <div class="modal-footer">
                <x-button class="btn-success">{{ __('logistics.save') }}</x-button>
                <x-button type="button" class="btn btn-danger" wire:click="close()"
                data-bs-dismiss="modal">{{ __('logistics.close') }}</x-button>
              </div>
            </form>
          </div>
        </div> <!-- end modal content-->
      </div> <!-- end modal dialog-->
    </div> <!-- end modal-->


    <!-- update storage_bin Modal -->
    <div wire:ignore.self class="modal fade" id="editBin" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">{{ __('logistics.update_storage_bin') }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"
          wire:click="close()"></button>
        </div> <!-- end modal header -->
        <div class="modal-body">
          <form wire:submit.prevent="updateData">
            <div class="row">

              <div class="mb-3 col-md-6">
                <label for="bin_name" class="form-label required">{{ __('logistics.storage_bin') }}
                </label>
                <input type="text" class="form-control" wire:model="bin_name">
                @error('bin_name')
                <div class="text-danger text-small">{{ __($message) }}</div>
                @enderror
              </div>


              <div class="mb-3 col-md-6">
                <label for="storage_type_id" class="form-label required">{{ __('logistics.storage_type') }}</label>
                <select class="form-control" wire:model="storage_type_id">
                  <option value="" selected>{{ __('logistics.select') }}...</option>
                  @foreach ($storage_types as $data)
                  <option value="{{ $data->id }}">
                    {{ $data->name }}
                  </option>
                  @endforeach
                </select>

                @error('storage_type_id')
                <div class="text-danger text-small">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3 col-md-6">
                <label for="storage_section_id" class="form-label required">{{ __('logistics.storage_section') }}</label>
                <select class="form-control" wire:model="storage_section_id">
                  <option value="" selected>{{ __('logistics.select') }}...</option>
                  @foreach ($storage_sections as $data)
                  <option value="{{ $data->id }}">
                    {{ $data->name }}
                  </option>
                  @endforeach
                </select>

                @error('storage_section_id')
                <div class="text-danger text-small">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3 col-md-6">
                <label for="description"
                class="form-label">{{ __('logistics.description') }}</label>
                <textarea name="description" class="form-control" wire:model="description"></textarea>

              </div>
            </div>
            <!-- end row-->
            <div class="modal-footer">
              <x-button class="btn btn-success">{{ __('logistics.update') }}</x-button>
              <x-button type="button" class="btn btn-danger" wire:click="close()"
              data-bs-dismiss="modal">{{ __('logistics.close') }}</x-button>
            </div>
          </form>
        </div>

      </div> <!-- end modal content-->
    </div> <!-- end modal dialog-->
  </div> <!-- end modal-->
</div>
@push('scripts')
<script>
  window.addEventListener('close-modal', event => {
    $('#addBin').modal('hide');
    $('#editBin').modal('hide');
    $('#delete_modal').modal('hide');
    $('#show-delete-confirmation-modal').modal('hide');
  });

  window.addEventListener('edit-modal', event => {
    $('#editBin').modal('show');
  });
  window.addEventListener('delete-modal', event => {
    $('#delete_modal').modal('show');
  });
</script>
@endpush
</div>
