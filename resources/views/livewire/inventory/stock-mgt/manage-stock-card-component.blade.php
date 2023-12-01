<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header pt-0">
        <div class="row mb-2">
          <div class="col-sm-12 mt-3">
            <div class="d-sm-flex align-items-center">
              <h5 class="mb-2 mb-sm-0">
                {{ __('logistics.received_stock') }}
                <!-- @if (!$toggleForm)
                @else
              --><div class="col-md-12">
              <form
              @if (!$toggleForm) wire:submit.prevent="receiveStock"
              @else
              wire:submit.prevent="updateStock" @endif>
              <div class="row">

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="transaction_date"
                    class="form-label required">{{ __('logistics.transaction_date') }}</label>
                    <input type="date" wire:model.defer="transaction_date" class="form-control"
                    max="{{ date('Y-m-d') }}">
                    @error('transaction_date')
                    <span class="text-danger error">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3 col-md-4">
                  <div class="form-group">
                    <label for="source_or_destination"
                    class="form-label required">{{ __('logistics.source_or_destination') }} </label>
                    <select class="form-control" wire:model.defer='supplier_id'>
                      <option value="">{{ __('logistics.select') }}...</option>
                      <!-- <option value="Other">Other</option> -->
                      @foreach ($distributors as $value)
                      <option value="{{ $value->name }}">{{ $value->name }}
                      </option>
                      @endforeach
                    </select>
                    @error('supplier_id')
                    <span class="text-danger error">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3 col-md-4">
                  <div class="form-group">
                    <label for="commodity_id" class="form-label required">{{ __('logistics.commodity') }} </label>
                    <select class="form-control" wire:model.lazy='commodity_id'>
                      <option value="">{{ __('logistics.select') }}... </option>
                      @foreach ($items as $value)
                      <option value={{ $value->id }}>{{ $value->name }}</option>
                      @endforeach
                    </select>
                    @error('commodity_id')
                    <span class="text-danger error">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="batch_number" class="form-label required">{{ __('logistics.batch_number') }} </label>
                    <input type="text" wire:model.lazy="stock_batch_number" id="batch_number" class="form-control">

                    @error('stock_batch_number')
                    <span class="text-danger error">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="expiry_date" class="form-label">{{ __('logistics.expiry_date') }}</label>
                    <input type="date" wire:model.defer="stock_expiry_date" class="form-control"
                    min="{{ date('Y-m-d') }}">
                  </div>
                  @error('stock_expiry_date')
                  <span class="text-danger error">{{ $message }}</span>
                  @enderror
                </div>
                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="quantity" class="form-label required">
                      {{ __('logistics.quantity_received') }}
                    </label>
                    <input type="number" wire:model="quantity" id="quantity" class="form-control">
                    @error('quantity')
                    <span class="text-danger error">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="batch_balance" class="form-label">{{ __('logistics.batch_balance') }}</label>
                    <input type="number" wire:model="batch_balance" class="form-control" readonly="true">
                  </div>
                </div>
                <div class="mb-3 col-md-2">
                  <div class="form-group">

                    <label for="balance_on_hand" class="form-label">
                      {{ __('logistics.balance_on_hand') }}
                    </label>
                    <input type="number" wire:model.lazy="balance_on_hand" class="form-control" readonly="true">
                  </div>
                </div>

                <div class="mb-3 col-md-4">
                  <div class="form-group">
                    <label for="comment" class="form-label">{{ __('logistics.comment') }}</label>
                    <textarea class="form-control" wire:model.defer="comment"></textarea>
                  </div>
                </div>

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="storage_bin" style="color:red"
                    class="form-label">{{ __('logistics.storage_bin') }}</label>
                    <select class="form-control" wire.model.lazy="storage_bins">
                      <option value="">{{__('logistics.select')}}</option>
                      @foreach ($storage_bins as $key => $value)
                      <option value="{{$value->id}}">{{$value->bin_name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="storage_type" style="color:red"
                    class="form-label">{{ __('logistics.storage_type') }}</label>
                    <input type="text" class="form-control" wire:model.defer="storage_type" readonly="true">
                  </div>
                </div>

                <div class="mb-3 col-md-2">
                  <div class="form-group">
                    <label for="storage_section" style="color:red"
                    class="form-label">{{ __('logistics.storage_section') }}</label>
                    <input type="text" class="form-control" wire:model.defer="storage_section" readonly="true">
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                @if (!$toggleForm)
                <x-button class="btn-success">{{ __('logistics.save') }}</x-button>
                @else
                <x-button class="btn-success">{{ __('logistics.update') }}</x-button>
                @endif
              </div>
            </form>
          </div>

          {{ __('logistics.update') }}
          <!--  @endif -->
        </h5>
        @include('livewire.layouts.partials.inc.create-resource')
      </div>
    </div>
  </div>
</div>
<div class="card-body">

  @if ($createNew)
  @include('livewire.logistics.commodity-mgt.inc.receive-stock')
  <hr>
  @endif

  <div class="tab-content">

    <div class="table-responsive">
      <x-logistics-table-utilities>

        <div class="mb-1 col-md-2">
          <label for="orderBy" class="form-label">OrderBy</label>
          <select wire:model="orderBy" class="form-control">
            <option value="batch_number">Batch Number</option>
            <option value="commodity_id">Item</option>
            <option value="id">Latest</option>
          </select>
        </div>

        <div class="mb-1 col-md-1">
          <label for="orderAsc" class="form-label">{{ __('public.order') }}</label>
          <select wire:model="orderAsc" class="form-control" id="orderAsc">
            <option value="1">Asc</option>
            <option value="0">Desc</option>
          </select>
        </div>

        <div class="mb-1 col-md-2">
          <label class="form-label" for="from">{{ __('logistics.between') }}</label>
          <input type="date" class="form-control" wire:model="from" max="{{ date('Y-m-') }}">
        </div>

        <div class="mb-1 col-md-2">
          <label class="form-label" for="to">{{ __('logistics.and') }}</label>
          <input type="date" class="form-control" wire:model="to" max="{{ date('Y-m-d') }}">
        </div>

        <div class="mb-1 col-md-2">
          <label class="form-label" for="item_id">{{ __('logistics.item') }}</label>
          <select class="form-control" wire:model="item_id">
            <option value="">{{ __('logistics.item') }}...</option>
            @foreach ($items as $key => $value)
            <option value={{ $value->id }}>{{ $value->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- <div class="mb-1 col-md-2">
          <label class="form-label"
          for="transaction_type_filter">{{ __('logistics.transaction_type') }}</label>
          <select class="form-control" wire:model="transaction_type_filter">
            <option value="">{{ __('logistics.select') }}...</option>
            <option value="Issue Stock"> {{ __('logistics.issue_stock') }} </option>
            <option value="Receive Stock"> {{ __('logistics.receive_stock') }}</option>
            <option value="Physical Count"> {{ __('logistics.physical_count') }}</option>
            <option value="Loss / Adjustment">{{ __('logistics.losses_adjustments') }}</option>
          </select>
        </div> -->

        @if ($transaction_type_filter == 'Receive Stock')
        <div class="mb-3 col-md-2">
          <div class="form-group">
            <label for="source_or_destination_filter"
            class="form-label required">{{ __('logistics.source_or_destination') }}</label>
            <select class="form-control" wire:model='source_or_destination_filter'>
              <option value="">{{ __('logistics.select') }}...</option>
              @foreach ($distributors as $value)
              <option value="{{ $value->name }}">{{ $value->name }}
              </option>
              @endforeach
            </select>
            @error('source_or_destination')
            <span class="text-danger error">{{ $message }}</span>
            @enderror
          </div>
        </div>
        @endif
      </x-logistics-table-utilities>

      <table class="table table-striped table-bordered mb-0 w-100 sortable">
        <thead>
          <tr>
            <th>#</th>
            <th>{{ __('logistics.transaction_date') }}</th>
            <th>{{ __('logistics.commodity') }}</th>
            <th>{{ __('logistics.to_from') }}</th>
            <!-- <th>{{ __('logistics.voucher_number') }}</th> -->
            <th>{{ __('logistics.batch_number') }}</th>
            <th>{{ __('logistics.physical_count') }}</th>
            <th>{{ __('logistics.qunatity_in_out') }}</th>
            <th>{{ __('logistics.expiry_date') }}</th>
            <th>{{ __('logistics.stock_onhand') }}</th>
            <th>{{ __('logistics.remarks') }}</th>
            <th>{{ __('logistics.initials') }}</th>
            <!-- <th>{{ __('logistics.action') }} </th> -->
          </tr>
        </thead>
        <tbody>
          @foreach ($stockcards as $key => $stockcard)
          <tr>
            <td style="white-space:">{{ $key + 1 }}</td>
            <td style="white-space:">@formatDate($stockcard->transaction_date)</td>
            <td style="white-space:">{{ $stockcard->commodity->name }}</td>
            <td style="white-space:">{{ $stockcard->to_from }}</td>
            <td style="white-space:">{{ $stockcard->batch_number }}</td>
            <td style="white-space:">{{ $stockcard->physical_count }}</td>
            <td style="white-space:">
              @if ($stockcard->action == 'I')
              {{ $stockcard->quantity_in }}
              @elseif($stockcard->action == 'O')
              {{ $stockcard->quantity_out }}
              @elseif($stockcard->action == 'P')
              -
            </td>
            @endif
            <td style="white-space:">@formatDate($stockcard->expiry_date)</td>
            <td style="white-space:">{{ $stockcard->balance }}</td>
            <td style="white-space:">{{ $stockcard->comment }}</td>
            <td style="white-space:">{{ $stockcard->initials }}</td>
            <!--
              <td>

                <div class="d-flex table-actions">
                  <a href="javascript: void(0);"
                  class="action-ico btn-outline-danger text-danger mx-1 bx bx-trash"
                  wire:click="confirmDelete({{ $stockcard->id }})"  data-bs-target="#deleteConfirm" title="{{__('public.delete')}}"></a>
                </div>
              </td> -->

            </tr>
            @endforeach
          </tbody>
        </table>
      </div> <!-- end preview-->
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="btn-group float-end">
            {{ $stockcards->links('vendor.livewire.bootstrap') }}
          </div>
        </div>
      </div>
    </div> <!-- end tab-content-->

  </div> <!-- end card body-->
</div> <!-- end card -->

<!-- Delete confirm modal -->
{{-- @include('livewire.logistics.store-mgt.inc.confirm-delete') --}}

<!-- display and update Batch discrepancy modal -->
{{-- @include('livewire.logistics.store-mgt.inc.batch-discrepancy') --}}

</div> <!-- end modal-->
</div><!-- end col-->
@push('scripts')
<script>
  window.addEventListener('close-modal', event => {
    $('#deleteConfirm').modal('hide');
  });

  window.addEventListener('delete-modal', event => {
    $('#deleteConfirm').modal('show');
  });

  window.addEventListener('batch-discrepancy-modal', event => {
    $('#batchDiscrepancy').modal('show');
  });
</script>
@endpush
</div>
