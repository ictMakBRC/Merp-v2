<div wire:ignore.self class="modal fade" id="newgeneralRequest" tabindex="-1" role="dialog"
aria-labelledby="deptItemupdateCreateModalTitle" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
<div class="modal-dialog modal-dialog modal-xl" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h6 class="modal-title m-0" id="deptItemupdateCreateModalTitle">
        @if (!$toggleForm)
        New General Request
        @else
        Update General Request
        @endif

      </h6>
      <button type="button" class="btn-close text-danger" wire:click="close()" aria-label="Close"></button>
    </div><!--end modal-header-->

    <div class="modal-body">
        <div class="col-md-12">
      <!-- <form  @if (!$toggleForm) wire:submit.prevent="storeData" @else wire:submit.prevent="updateData" @endif > -->
        <div class="row">
          <div class="col-md-6">

            <label for="request_code" class="form-label">Request Code</label>
            <input type="text" id="category" class="form-control" wire:model.defer="request_code" readonly>
            @error('brand')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="department_id" class="form-label required" required>Department</label>
            <select class="form-select" wire:model="department_id" required>

              <option value="">Select...</option>
              @foreach ($departments as $key => $value)
              <option value="{{$value->id}}">{{$value->name}}</option>
              @endforeach
            </select>
            @error('department_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="approver" class="form-label required" required>Approver</label>
            <select class="form-select" wire:model="approver" required>

              <option value="">Select...</option>
              @foreach ($hod as $key => $value)
              <option value="{{$value->id}}">{{$value->surname }} {{$value->first_name}}</option>
              @endforeach
            </select>
            @error('department_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="item_id" class="form-label required">Commodity</label>
            <select class="form-select" wire:model="item_id">
              <option value="">Select...</option>
              @foreach ($items as $key => $value)
              <option value="{{$value->item?->id}}">{{$value->item?->name}}</option>
              @endforeach
            </select>
            @error('item_id')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" class="form-control" wire:model.defer="brand" readonly>
            @error('brand')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="qty_left" class="form-label">Available Quantity</label>
            <input type="text" class="form-control" wire:model.defer="qty_left" readonly>
            @error('brand')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="qty_required" class="form-label required">Quantity Required</label>
            <input type="number" class="form-control" wire:model.defer="qty_required" min='1'>
            @error('qty_required')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-3">
            <label for="stock_balance" class="form-label">Stock Balance</label>
            <input type="number" class="form-control" wire:model.defer="stock_balance" readonly>
            @error('qty_required')
            <div class="text-danger text-small">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3 col-md-6">
            <label for="comment" class="form-label">Comment</label>
            <textarea  wire:model.defer="comment" rows="2" cols="73"></textarea>
          </div>
        </div>
        <a type="button" wire:click="storeData" class="btn btn-sm me-2 btn-success">
          <i class="fa fa-plus"></i> Add to list
        </a>
        <br><br>
        </div>

          <div class="container">
            <div class="row">
          <div class="col-md-12">
            @if (!$orders->isEmpty())
            <div class="tab-content">
              <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0 w-100">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>{{ __('Request Code') }}</th>
                      <th>{{ __('Deparment') }}</th>
                      <th>{{ __('Approver') }}</th>
                      <th>{{ __('Item') }}</th>
                      <th>{{ __('Qty Required') }}</th>
                      <th>{{ __('Action') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $key => $value)
                    <tr>
                      <td>{{ $key + 1 }}</td>
                      <td>{{ $value->request_code }}</td>
                      <td>{{ $value->department?->name }}</td>
                      <td>{{ $value->approver?->surname }} {{ $value->approver?->first_name }}</td>
                      <td>{{ $value->item?->name }}</td>
                      <td>{{ $value->quantity_required }}</td>

                        <td>
                          <button wire:click="removeFromList( {{$value->id}} )" title="Remove"
                            class="action-ico btn-sm btn btn-outline-danger mx-1">
                            <i class="fa fa-trash"></i></button>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div> <!-- end preview-->
              </div> <!-- end tab-content-->
              @else
              @endif
            </div>
        </div><!--end modal-dialog-->
        </div><!--end modal-dialog-->

      </div><!--end modal-body-->
    <!-- </form> -->

        <div class="modal-footer">
          <button type="button" class="btn btn-danger btn-sm" wire:click="close()" >{{ __('public.close') }}</button>
          @if($toggleForm)
          <x-button type="submit"  class="btn-success btn-sm">{{ __('public.update') }}</x-button>
          @else
          <x-button type="submit"  class="btn-success btn-sm">{{ __('Submit') }}</x-button>
          @endif
        </div><!--end modal-footer-->

  </div><!--end modal-content-->

</div><!--end modal-dialog-->
</div><!--end modal-->
