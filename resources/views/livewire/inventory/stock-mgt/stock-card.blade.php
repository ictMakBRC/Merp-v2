<div>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pt-0">

          <div class="row mb-2">
            <div class="col-sm-12 mt-3">
              <div class="d-sm-flex align-items-center">
                <h5 class="mb-2 mb-sm-0">
                  Stockcard Entries (<span class="text-danger fw-bold">{{ $stockcards->total() }}</span>)
                  {{-- @include('livewire.layouts.partials.inc.filter-toggle') --}}
                </h5>
                @include('livewire.layouts.partials.inc.inv-create-resource')
              </div>
            </div>
          </div>

          @if ($createNew)
          @include('livewire.inventory.stock-mgt.inc.create-stockcard')
          <hr>
          @endif

        <div class="table-responsive">
          <x-logistics-table-utilities>

            <div class="col-sm-1">
              <label for="orderBy" class="form-label">Order By</label>
              <select wire:model="orderBy" class="form-control">
                <option value="batch_number">Batch</option>
                <option value="commodity_id">Commodity</option>
                <option value="id">Latest</option>
              </select>
            </div>

            <div class="mb-1 col-md-1">
                <label for="orderAsc" class="form-label">Order</label>
                <select wire:model="orderAsc" class="form-control" id="orderAsc">
                    <option value="1">Asc</option>
                    <option value="0">Desc</option>
                </select>
            </div>

            <div class="mb-1 col-md-2">
              <label class="form-label" for="from">{{__('Between')}}</label>
              <input type="date"  class="form-control" wire:model="from"  max="{{date('Y-m-d')}}">
            </div>

            <div class="mb-1 col-md-2">
              <label class="form-label" for="to">{{__('And')}}</label>
              <input type="date"  class="form-control" wire:model="to"  max="{{date('Y-m-d')}}">
            </div>

            <div class="mb-1 col-md-2">
              <label class="form-label"  for="item_id">{{__('Item')}}</label>
              <select class="form-control" wire:model="item_id">
                <option value="">{{__('Select')}}...</option>
                @foreach ($items as $key => $value)
                <option value={{$value->id}}>{{$value->name}}</option>
                @endforeach
              </select>
            </div>


            <div class="mb-1 col-md-1">
              <label class="form-label" for="transaction_type_filter">{{__('Transaction Type')}}</label>
              <select class="form-control" wire:model="transaction_type_filter">
                <option value="">{{__('Select')}}...</option>
                <option value="Issue Stock"> {{ __('Issue Stock') }} </option>
                <option value="Receive Stock"> {{ __('Receive Stock') }}</option>
                <option value="Physical Count"> {{ __('Physical Count') }}</option>
                <option value="Loss / Adjustment">{{ __('Losses / Adjustments') }}</option>
              </select>
            </div>

            @if($transaction_type_filter == "Receive Stock")
            <div class="mb-3 col-md-2">
              <div class="form-group">
                <label for="source_or_destination_filter"
                class="form-label required">{{ __('Source or Destination') }}</label>
                <select class="form-control" wire:model='source_or_destination_filter'>
                  <option value="">{{ __('Select') }}...</option>
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
          <div class="table-responsive">

        <table class="table table-striped table-bordered mb-0 w-100 sortable">
          <thead>
            <tr>
              <th>#</th>
              <th>{{ __('Transaction Date') }}</th>
              <th>{{ __('Commodity') }}</th>
              <th>{{ __('To / From') }}</th>
              <!-- <th>{{ __('voucher_number') }}</th> -->
              <th>{{ __('Batch / Lot No.') }}</th>
              <th>{{ __('Physical Count') }}</th>
              <!-- <th>{{ __('discrepancy') }}</th> -->
              <th>{{ __('Quantity in/out') }}</th>
              <th title="{{ __('losses_adjustments') }}">L/A(-/+)</th>
              <th>{{ __('Transaction Type') }}</th>
              <th>{{ __('Expiry Date') }}</th>
              <th>{{ __('Stock On Hand') }}</th>
              <th>{{ __('Remarks') }}</th>
              <!-- <th>{{ __('initials') }}</th> -->
              <th>{{ __('Action') }} </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($stockcards as $key => $stockcard)
            <tr>
              <td style="white-space:">{{ $key + 1 }}</td>
              <td style="white-space:">{{$stockcard->transaction_date}}</td>
              <td style="white-space:">{{ $stockcard->commodity->name }}</td>
              <td style="white-space:">{{ $stockcard->to_from }}</td>
              <td style="white-space:">{{ $stockcard->batch_number }}</td>
              <td style="white-space:">{{ $stockcard->physical_count }}</td>
              <!-- <td style="white-space:">{{ $stockcard->discrepancy }}</td> -->
              <td style="white-space:">
                @if ($stockcard->action == 'I')
                {{ $stockcard->quantity_in }}
                @elseif($stockcard->action == 'O' || $stockcard->action == 'Issue Stock' )
                {{ $stockcard->quantity_out }}
                @elseif($stockcard->action == 'P')
                -
              </td>
              @endif
              <td style="white-space:">{{ $stockcard->losses_adjustments }}</td>
              <td style="white-space:">
                {{ $stockcard->transaction_type}}
              </td>
              <!-- <td style="white-space:">
                @if ($stockcard->action == 'I')
                {{__('incoming')}}
                @elseif($stockcard->action == 'O')
                {{__('outgoing')}}
                @elseif($stockcard->action == 'P')
                {{__('physical_count')}}
                @elseif($stockcard->action == 'L / A')
                {{__('losses_adjustments')}}
                @endif
              </td> -->
              <td style="white-space:">{{$stockcard->expiry_date}}</td>
              <td style="white-space:">{{ $stockcard->balance }}</td>
              <td style="white-space:">{{ $stockcard->comment }}</td>
              <!-- <td style="white-space:">{{ $stockcard->initials }}</td> -->

              <td>
                <div class="d-flex table-actions">
                  @if($stockcard->discrepancy != 0)
                  <a href="javascript: void(0);">
                  <i class="bx bx-edit-alt" wire:click="resolveDiscrepancy({{ $stockcard->id }})" title="resolve discrepancy"></i></a>
                  @endif

                  <!-- <a href="javascript: void(0);"
                  class="action-ico btn-outline-danger text-danger mx-1 bx bx-trash"
                  wire:click="confirmDelete({{ $stockcard->id }})" title="{{__('public.delete')}}"></a> -->
                </div>
              </td>
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
</div><!-- end col-->
</div>
<!-- Delete confirm modal -->
@include('livewire.inventory.stock-mgt.inc.confirm-delete')

<!-- display and update Batch discrepancy modal -->
@include('livewire.inventory.stock-mgt.inc.batch-discrepancy')

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
