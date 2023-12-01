<div wire:ignore.self class="modal fade" id="batchDiscrepancy" data-bs-backdrop="static"
data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">

      <h5 class="modal-title" id="staticBackdropLabel">{{ __('logistics.discrepancy') }}</h5>
      <button type="button" class="btn-close" wire:click="close()" data-bs-dismiss="modal"
      aria-hidden="true"></button>
    </div>
    <div class="modal-body">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>
              <input class="form-check-input" type="radio" name="flexRadioDefault"
              wire:click="$set('stockcard_id',null)">

            </th>
            <th>{{ __('logistics.commodity') }}</th>
            <th>{{ __('logistics.batch_number') }}</th>
            <th>{{ __('logistics.expiry_date') }}</th>
            <th>{{ __('logistics.expected_quantity') }}</th>
            <th>{{ __('logistics.quantity_confirmed') }}</th>
            <th>{{ __('logistics.discrepancy') }}</th>
            <th>{{ __('logistics.comment') }}</th>
            <th>{{ __('logistics.action') }} </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($resolve_batch as $key => $stockcard)
          <tr>
            <td>
              <input class="form-check-input" type="radio" name="flexRadioDefault"
              id="flexRadioDefault{{ $key + 1 }}"
              wire:click="$set('stockcard_id',{{ $stockcard->id }})">
              {{ $key + 1 }}
            </td>
            <td style="white-space:">{{ $stockcard->commodity->name }}</td>
            <td style="white-space:">
              @if ($stockcard_id == $stockcard->id)
              <input type="text" class="form-control" wire:model.deferred="batch_number" placeholder="{{$stockcard->batch_number}}">
              @else
              {{ $stockcard->batch_number }}
              @endif
            </td>
            <td style="white-space:">
              @if ($stockcard_id == $stockcard->id)
              <input type="date" wire:model.deferred="expiry_date" class="form-control"  min="{{ date('Y-m-d') }}" placeholder="{{$stockcard->expiry_date}}">
              @else
              {{ $stockcard->expiry_date }}
              @endif
            </td>
            <td>
              {{ $stockcard->batch_balance }}
            </td>
            <td>
              @if ($stockcard_id == $stockcard->id)
              <input type="number" class="form-control" wire:model.lazy="quantity_confirmed" placeholder="{{$stockcard->batch_balance}}">
              <!-- <input type="number" class="form-control" wire:model.deferred="entry_id" placeholder="{{$stockcard->id}}" hidden> -->

              @else
              {{ $stockcard->batch_balance }}
              @endif
            </td>
            <td>
              @if ($stockcard_id == $stockcard->id)
              <input type="number" class="form-control" wire:model.deferred="batch_discrepancy" placeholder="{{$stockcard->discrepancy}}" readonly='true'>
              @else
              {{ $stockcard->discrepancy }}
              @endif
            </td>

            <td>@if ($stockcard_id == $stockcard->id)
              <textarea class="form-control" wire:model.deferred="comment" placeholder="{{$stockcard->comment}}" rows="2" cols="80"></textarea>
              @else
              {{ $stockcard->comment }}
              @endif
            </td>

            <td>
              @if ($stockcard_id == $stockcard->id)
              <div class="d-flex table-actions">
              <a href="javascript: void(0);"
              class="action-ico btn btn-success mx-1 bx bx-save"
              wire:click="saveResolvedDiscrepancy" title="{{__('public.save')}}"></a>
            </div>
              @else

              @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>

      @if ($addNew)
      <hr>

      <div class="row">
        <div class="col-md-12">
          <form wire:submit.prevent="updateBatchQuantity">
            <div class="row">
              <div class="mb-3 col-md-3">
                <div class="form-group">
                  <label for="batch_number" class="form-label">{{ __('logistics.batch_number') }}</label>
                  <input type="text" wire:model="batch_number" class="form-control"  placeholder="Batch Number">

                </div>
              </div>

              <div class="mb-3 col-md-3">
                <div class="form-group">
                  <label for="expiry_date" class="form-label">{{ __('logistics.expiry_date') }}</label>
                  <input type="date" wire:model="expiry_date" class="form-control"  min="{{ date('Y-m-d') }}">
                </div>
              </div>

              <div class="mb-3 col-md-3">
                <div class="form-group">
                  <label for="batch_quantity" class="form-label">{{ __('logistics.quantity') }}</label>
                  <input type="number" wire:model="batch_quantity" class="form-control">
                </div>
              </div>

              <div class="mb-3 col-md-3">
                <div class="form-group">
                  <label for="comment" class="form-label">{{ __('logistics.comment') }}</label>
                  <textarea wire:model.lazy="comment" class="form-control"></textarea>
                </div>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endif
  <!-- end row-->
  <div class="modal-footer">
    <!-- <a type="button" class="btn me-2
    @if (!$addNew) btn-info
    @else
    btn-outline-danger @endif"
    wire:click="$set('addNew',{{ !$addNew }})">
    @if (!$addNew)
    <i class="bx bx-plus"></i>{{__('New')}}
    @else
    <i class="bx bx-caret-up"></i>
    @endif
  </a>

  <button type="button" wire:click.prevent="updateBatchQuantity()"
  class="btn btn-success close-modal"
  data-dismiss="modal">{{ __('logistics.update') }}</button> -->
  <x-button type="button" class="btn btn-danger" wire:click="close()"
  data-bs-dismiss="modal">{{ __('logistics.close') }}</x-button>
</div>
</div>
</div>
</div>
