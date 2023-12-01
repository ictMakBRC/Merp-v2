<?php

namespace App\Http\Livewire\Inventory\StockMgt;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Logistics\Commodity;
use App\Models\Logistics\StockCard;
use App\Models\Logistics\StorageBin;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Logistics\ExportStockcard;
use App\Models\Logistics\InstitutionSupplier;
use App\Models\NetworkManagement\Institution;


class ManageStockCardComponent extends Component
{
  use WithPagination;

  public $category;

  public $exportData;

  public $item;

  public $supplier;

  public $transaction_type;

  public $transaction_date;

  public $source_or_destination;

  public $batch;

  public $batch_number;

  public $batch_balance;

  public $commodity_id;

  public $expiry_date;

  public $quantity;

  public $comment;

  public $initials;

  public $balance;

  public $stockcard;

  public $action_type;

  public $to_from;

  public $discrepancy;

  public $balance_on_hand;

  public $batches;

  public $storage_bin;

  public $storage_bins;

  public $storage_type;

  public $storage_section;

  public $mode = 'store';

  public $search = '';

  public $perPage = 10;

  public $orderAsc = false;

  public $createNew = false;

  public $addNew = false;

  public $toggleForm = false;

  public $show = false;

  public $showDescripancy = false;

  public $orderBy = 'created_at';

  public $request_form_show = false;

  public $edit_id = '';

  public $delete_id = '';

  public $selectedBatch = '';

  public $previous_balance = '';

  public $from = '';

  public $to = '';

  public $item_id = '';

  public $batch_quantity;

  public $batch_discrepancy;

  public $available_batch_balance;

  public $quantity_confirmed;

  public $resolve_batch;

  public $stockcard_id;

  public $bundleCommodities;

  public $receive = false;

  public $transaction_type_filter = '';

  public $source_or_destination_filter = '';

  public $supplier_id;

  public $stock_batch_number;

  public $stock_expiry_date;

  public function mount()
  {
    $this->transaction_date = date('Y-m-d');
    $this->batches = collect([]);
    $this->resolve_batch = collect([]);
    $user_full_name = auth()->user()->surname.' '.auth()->user()->first_name.' '.auth()->user()->other_name;
    $name_arr = explode(' ', $user_full_name);
    if (count($name_arr) >= 2) {
      $this->initials = mb_strtoupper(mb_substr($name_arr[0], 0, 1, 'UTF-8').mb_substr($name_arr[1], 0, 1, 'UTF-8').mb_substr(end($name_arr), 0, 1, 'UTF-8'), 'UTF-8');
    }
  }

  public function confirmDelete($id)
  {

    $this->delete_id = $id;
    $this->dispatchBrowserEvent('delete-modal');
  }

  public function deleteEntry()
  {
    StockCard::find($this->delete_id)->delete();

    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Entry successfully removed!']);
  }

  public function refresh()
  {
    return redirect(request()->header('Referer'));
  }

  public function queryBatches()
  {
    $batches = StockCard::where('commodity_id', $this->commodity_id)
    ->where('institution_id', auth()->user()->institution_id)
    ->where('batch_balance', '>', 0)
    ->whereNotNull('batch_balance')
    ->orderBy('expiry_date', 'ASC')
    ->latest();

    return $batches;
  }
  public function updatedBatchNumber()
  {
    if($this->transaction_type == 'Issue Stock' && $this->batch_number != ''){
      $this->batch =$this->queryBatches()
      ->where('batch_number',$this->batch_number)
      ->latest()->first();
      $this->expiry_date = $this->batch->expiry_date;
      $this->batch_balance = $this->batch->batch_balance;
      $this->available_batch_balance = $this->batch->batch_balance ;
    }
    elseif ($this->transaction_type !=='Issue Stock') {
      $this->batch_balance = '';
      $this->expiry_date = '';
    }
  }

  public function updatedStorageBin()
  {
    if($this->storage_bin == ''){
      $this->storage_bin = '';
      $this->storage_type = '';
      $this->storage_section  = '';
    }
    else {
      // code...
      $storage_bin = StorageBin::findOrFail($this->storage_bin);
      $this->storage_type = $storage_bin->StorageType->name??'-';
      $this->storage_section = $storage_bin->StorageSection->name??'-';
    }
  }

  public function updatedQuantity()
  {
    // dd($this->commodity_id);
    // $commodity = StockCard::where('commodity_id',$this->commodity_id)->latest();
    $this->batch_balance = $this->quantity;
    // $this->balance_on_hand = intval($this->balance_on_hand) + intval($this->quantity);
  }

  public function updatedCommodityId()
  {
    $this->quantity = '';
    $this->expiry_date = '';
    $this->batch_balance = '';
    $this->discrepancy = '';

    // get exact location of item
    $commodity = Commodity::with('storageBin.StorageType', 'storageBin.StorageSection')->where('id',$this->commodity_id)->first();

    $this->stockcard = StockCard::with('institution')
    ->where('commodity_id', $this->commodity_id)
    ->where('institution_id', auth()->user()->institution_id)->latest()->first();

    // get balance of selected item
    $this->balance_on_hand = $this->stockcard->balance ?? '0';
    $this->previous_balance = $this->stockcard->balance ?? '0';
    if ($this->transaction_type == 'Issue Stock') {
      $this->batches = $this->queryBatches()->whereDate('expiry_date', '>', date('Y-m-d'))
      ->groupBy('batch_number')
      ->get();

      if ($this->balance_on_hand == 0) {
        $this->dispatchBrowserEvent('swal:modal', [
        'type' => 'warning',
        'message' => 'Insufficient Balance on Hand!',
        'text' => 'Item Balance for this Item is insufficient for this transaction.',
        ]);
      }
    }
  }

  public function receiveStock()
  {
    $action_type = '';
    $to_from = '';

    if ($this->stockcard) {
      $this->balance_on_hand = intval($this->quantity) + intval($this->stockcard->balance);
      $this->batch_balance = intval($this->quantity);
      $this->action_type = 'I';
      $this->to_from = $this->source_or_destination;
    } else {
      $this->balance_on_hand = intval($this->quantity);
      $this->action_type = 'I';
      $this->to_from = $this->source_or_destination;
      $this->batch_balance = intval($this->quantity);
    }

    $this->validate([
    'stock_expiry_date' => 'required',
    'transaction_date' => 'required',
    'stock_batch_number' => 'required',
    'commodity_id' => 'required',
    'comment' => 'nullable|string',
    'quantity' => 'required|numeric',
    ]);

    $stockcard = new StockCard();
    $stockcard->transaction_type = 'Receive Stock';
    $stockcard->transaction_date = $this->transaction_date;
    $stockcard->to_from = $this->supplier_id;
    $stockcard->batch_number = $this->stock_batch_number;
    $stockcard->commodity_id = $this->commodity_id;
    $stockcard->created_by =auth()->user()->id;
    $stockcard->institution_id =auth()->user()->institution_id;
    $stockcard->comment = $this->comment;
    $stockcard->initials = $this->initials;
    $stockcard->expiry_date = $this->stock_expiry_date;
    $stockcard->received_date = $this->transaction_date;
    $stockcard->quantity = $this->quantity;
    $stockcard->batch_balance = $this->quantity;
    $stockcard->action = 'I';
    $stockcard->quantity_in = $this->quantity;
    $stockcard->discrepancy = $this->discrepancy;
    $stockcard->balance = $stockcard->quantity;
    $stockcard->quantity_in = $this->quantity;
    $stockcard->balance = $this->balance_on_hand;
    $stockcard->storage_bin_id = $this->storage_bin;
    $stockcard->previous_balance = $this->previous_balance;
    $stockcard->save();

    $this->resetInputs();
    $this->createNew = false;
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Stockcard entry successfully added']);

  }

  public function resetInputs()
  {
    $this->reset([
    'comment',
    'quantity',
    'expiry_date',
    'discrepancy',
    'batch_number',
    'commodity_id',
    'batch_balance',
    'balance_on_hand',
    'transaction_type',
    'source_or_destination',
    'quantity_confirmed',
    ]);
    $this->transaction_date = date('Y-m-d');
  }

  public function mainQuery()
  {
    $stockcards = StockCard::search($this->search)->where('transaction_type', 'Receive Stock')
    ->when(auth()->user()->category == 'Core-Institution-Staff', function ($query) {
      $query->where('institution_id', auth()->user()->institution_id);
    })
    ->when(auth()->user()->hasPermission('view_facility_stock_status'), function ($query) {
      $query->where('institution_id', '!=', null);
    })
    ->when($this->from, function ($query) {
      $query->where('transaction_date', '>', $this->from);
    })
    ->when($this->to, function ($query) {
      $query->where('transaction_date', '<', $this->to);
    })
    ->when($this->item_id, function ($query) {
      $query->where('commodity_id', $this->item_id);
    })
    ->when($this->source_or_destination_filter, function ($query) {
      $query->whereYear('to_from', $this->source_or_destination_filter);
    })
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

    return $stockcards;
  }

  public function export()
  {
    $this->exportData = $this->mainQuery()->pluck('id')->toArray();

    return Excel::download(new ExportStockcard($this->exportData), 'stockcard-'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
  }

  public function render()
  {

    // $data['distributors'] = Institution::whereIn('category', ['Distributor'])->get(['name', 'id']);
    $data['distributors'] = InstitutionSupplier::where('institution_id',\Auth::user()->institution_id)->get(['name', 'id']);
    $data['items'] = Commodity::where('entered_by_lab',1)->where('institution_id',auth()->user()->institution_id)->orWhere('entered_by_lab',0)->get(['name', 'id']);
    $this->storage_bins = StorageBin::where('institution_id',\Auth::user()->institution_id)->get();

    $data['stockcards'] = $this->mainQuery()
    ->paginate($this->perPage);

    return view('livewire.logistics.store-mgt.manage-stock-card-component', $data)->layout('layouts.app');
  }
}
