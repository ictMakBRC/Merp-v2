<div wire:ignore.self class="modal" id="selectDepartmentModal" data-bs-backdrop="static"
data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title" id="staticBackdropLabel">{{ __('Select Project / Department') }}</h5>
      <button type="button" class="btn-close" wire:click="close()" data-bs-dismiss="modal"
      aria-hidden="true"></button>
    </div>
    <div class="modal-body">
      <h1 class="bx bx-error-alt"></h1>
      <form  class="form-horizontal" wire:submit.prevent='selectDepartment'>
              @csrf
          <div class="row">
            <div class="mb-12 col-md-12">
                <label for="subCategory" class="form-label">Project / Department</label>
                <select class="form-select" wire:model.lazy="dept"
                    class="form-control">
                    <?php
                    $user_dept = App\Models\HumanResource\Settings\Department::get();
                    ?>
                    <option value="">Select...</option>
                    <?php foreach ($user_dept as $key => $value): ?>

                      <option value="{{$value->id}}">{{$value->name}}</option>
                    <?php endforeach; ?>
                </select>
            </div>
          </div> <!-- end row -->
      </form>

    </div>
    <!-- end row-->
    <div class="modal-footer">
      <button type="button" wire:click='selectDepartment()'
      class="btn btn-success close-modal fas fa-tick-circle">{{ __('Proceed') }}</button>
      <!-- <x-button type="button" class="btn btn-danger bx bx-x-circle" wire:click="close()"
      data-bs-dismiss="modal">{{ __('Close') }}</x-button> -->
    </div>
  </div>
</div> <!-- end modal content-->
</div> <!-- end modal dialog-->
