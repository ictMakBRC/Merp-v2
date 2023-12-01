<?php

namespace App\Http\Livewire\Inventory\StockMgt;

use App\Models\Inventory\Item\InvItem;
use App\Exports\Logistics\ExportStockcard;
use App\Models\Inventory\Settings\InvSupplier;
use App\Models\Inventory\Stockcard\InvStockcard;
use App\Models\HumanResource\Settings\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class StockCardComponent extends Component
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
    public $rbatch_number;
    public $storage_bin;
    public $storage_type;
    public $storage_section;
    public $discrepancy_value;
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
    public $entry_id;
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
    public $has_expiry;

    public function updatedCreateNew()
    {
        // $this->resetInputs();
        $this->toggleForm = false;
        // $this->bundleCommodities = collect([]);
    }

    public function updatedReceive()
    {
        $this->resetInputs();
        $this->transaction_type = 'Receive Stock';
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function mount()
    {
        $this->transaction_date = date('Y-m-d');
        $this->batches = collect([]);
        $this->resolve_batch = collect([]);
        $user_full_name = \Auth::user()->surname.' '.\Auth::user()->first_name.' '.\Auth::user()->other_name;
        $name_arr = explode(' ', $user_full_name);
        if (count($name_arr) >= 2) {
            $this->initials = mb_strtoupper(mb_substr($name_arr[0], 0, 1, 'UTF-8').mb_substr($name_arr[1], 0, 1, 'UTF-8').mb_substr(end($name_arr), 0, 1, 'UTF-8'), 'UTF-8');
        }
    }

  public function queryBatches()
  {
    $batches = InvStockcard::where('commodity_id', $this->commodity_id)
    ->with('storageBin.StorageType', 'storageBin.StorageSection')
    ->where('institution_id', \Auth::user()->institution_id)
    ->where('batch_balance','>',0)
    ->whereNotNull('batch_balance')
    ->orderBy('expiry_date','ASC')
    ->latest();

        return $batches;
    }

    public function updatedCommodityId()
    {
        $this->quantity = '';
        $this->expiry_date = '';
        $this->batch_balance = '';
        $this->discrepancy = '';

    // get exact location of item
    // $commodity = Commodity::with('storageBin.StorageType', 'storageBin.StorageSection')->where('id',$this->commodity_id)->first();

    $this->stockcard = InvStockcard::with('storageBin.StorageType', 'storageBin.StorageSection')
    ->where('commodity_id', $this->commodity_id)
    // ->latest()->first();
    ->where('institution_id', \Auth::user()
    ->institution_id)->latest()->first();

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

  public function updatedBatchNumber()
  {
    if($this->transaction_type == 'Issue Stock' && $this->batch_number != ''){
      $this->batch =$this->queryBatches()
      ->where('batch_number',$this->batch_number)
      ->latest()->first();

      $stockcard = InvStockcard::where('batch_number',$this->batch_number)->first();

      $this->expiry_date = $this->batch->expiry_date;
      $this->batch_balance = $this->batch->batch_balance;
      $this->available_batch_balance = $this->batch->batch_balance ;

      $this->storage_bin = $stockcard->storageBin->bin_name??'-';
      $this->storage_type = $stockcard->storageBin->StorageType->name??'-';
      $this->storage_section = $stockcard->storageBin->StorageSection->name??'-';

    }
    elseif($this->transaction_type !=='Issue Stock') {
      $this->batch_balance = '';
      $this->expiry_date = '';
    }
  }


    public function updatedQuantity()
    {
        $action_type = '';
        $to_from = '';

    if ($this->transaction_type == 'Receive Stock' && $this->stockcard) {
      $this->balance_on_hand = intval($this->stockcard->balance);
      $this->balance_on_hand = intval($this->quantity) + intval($this->stockcard->balance);
      $this->batch_balance = intval($this->quantity);
      $this->action_type = 'I';
      $this->to_from = $this->source_or_destination;
    }

        if ($this->transaction_type == 'Receive Stock') {
            $this->balance_on_hand = intval($this->quantity);
            $this->action_type = 'I';
            $this->to_from = $this->source_or_destination;
            $this->batch_balance = intval($this->quantity);
        }

        if ($this->transaction_type == 'Issue Stock' && $this->balance_on_hand < 1) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Insufficient Balance on Hand!',
                'text' => 'Item Balance is Insufficient for this transaction.',
            ]);
            $this->quantity = '';
        }

        if ($this->transaction_type == 'Issue Stock' && $this->batch->balance > 0) {

      $this->balance_on_hand = intval($this->batch->balance);
      $this->balance_on_hand = intval($this->balance_on_hand) - intval($this->quantity);
      $this->batch_balance = intval($this->batch->batch_balance) - intval($this->quantity);
      $this->action_type = 'O';
      $this->to_from = \Auth::user()->institution_id;
    }

        if ($this->transaction_type == 'Issue Stock' && $this->quantity > $this->batch->batch_balance) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Transaction Declined',
                'text' => 'You cannot issue more quantity than your Batch Balance or Balance at Hand.',
            ]);
            $this->quantity = '';
            $this->balance_on_hand = intval($this->stockcard->balance);
            $this->batch_balance = intval($this->stockcard->batch_balance);

        }

        if ($this->transaction_type == 'Issue Stock' && $this->quantity != '' && $this->quantity <= 0) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Transaction Declined',
                'text' => 'Invalid Quantity.',
            ]);

            $this->quantity = '';
            $this->balance_on_hand = intval($this->batch->balance);
            $this->batch_balance = intval($this->batch->batch_balance);

        }

        if ($this->transaction_type == 'Physical Count') {
            // $this->batch_balance = intval($this->batch[0]->batch_balance);
            $this->balance_on_hand = $this->stockcard->balance ?? 0;

            $tmp = $this->stockcard->balance ?? 0;
            $this->balance_on_hand = intval($tmp);

            $this->discrepancy = $this->quantity == '' ? 0 : intval($this->quantity) - intval($tmp);
            // $this->balance_on_hand = $this->quantity == '' ? intval($tmp) : $this->quantity;
            $this->action_type = 'Physical Count';
            $this->to_from = 'Physical Count';
        }

        if ($this->transaction_type == 'Loss / Adjustment') {
            $this->balance_on_hand = $this->stockcard->balance ?? 0;

            $this->balance_on_hand = intval($this->balance_on_hand) + intval($this->quantity);
            $tmp = $this->stockcard->balance ?? 0;

            $this->action_type = 'Loss / Adjustment';
            $this->to_from = 'Loss / Adjustment';
        }
    }

    public function store()
    {
        $this->validate([
            'transaction_date' => 'required|date',
            'transaction_type' => 'required',
            // 'batch_number' => 'required_if:transaction_type,Receive Stock,Issue Stock,',
            'has_expiry' => 'required',
            'batch_number' => 'required',
            'expiry_date' => 'required_if:has_expiry,Yes',
            'commodity_id' => 'required',
            'quantity' => 'required',
            'source_or_destination' => 'required_if:transaction_type,==,Receive Stock',
        ], ['commodity_id.required' => 'Select an item/commodity.']);

        // dd($this->commodity_id);
        $stockcard = InvStockcard::create([
            'commodity_id' => $this->commodity_id,
            'created_by' => \Auth::user()->id,
            'quantity' => $this->quantity,
            'action' => $this->action_type,
            'batch_number' => $this->batch_number == '' ? $this->rbatch_number : $this->batch_number,
            'batch_balance' => $this->batch_balance == '' ? $this->quantity : $this->batch_balance,
            'expiry_date' => $this->expiry_date,
            'received_date' => $this->transaction_type == 'Receive Stock' ? $this->transaction_date : null,
            'initials' => $this->initials,
            'comment' => $this->comment,
            'previous_balance' => $this->previous_balance,
            'balance' => $this->transaction_type == 'Physical Count' ? $this->balance_on_hand + $this->discrepancy : $this->balance_on_hand,
            'transaction_date' => $this->transaction_date,
            'quantity_in' => $this->transaction_type == 'Receive Stock' ? $this->quantity : null,
            'quantity_out' => $this->transaction_type == 'Issue Stock' ? $this->quantity : null,
            'physical_count' => $this->transaction_type == 'Physical Count' ? $this->quantity : null,
            'discrepancy' => $this->discrepancy,
            // 'quantity_resolved' => $this->quantity,
            'losses_adjustments' => $this->transaction_type == 'Loss / Adjustment' ? $this->quantity : null,
            'transaction_type' => $this->transaction_type,
            'to_from' => $this->transaction_type == 'Issue Stock' ? $this->stockcard->institution->short_code : $this->to_from,
        ]);


        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Stockcard entry successfully added']);

        $this->createNew = true;
    }

    public function editData(InvStockcard $stockcard)
    {
        $this->edit_id = $stockcard->id;

        $this->transaction_type = $stockcard->transaction_type;
        $this->transaction_date = $stockcard->transaction_date;
        $this->source_or_destination = $stockcard->to_from;
        $this->batch_number = $stockcard->batch_number;
        $this->commodity_id = $stockcard->commodity_id;
        $this->comment = $stockcard->comment;
        $this->expiry_date = $stockcard->expiry_date;
        $this->discrepancy = $stockcard->discrepancy;
        $this->quantity = $stockcard->quantity;
        $this->balance_on_hand = $stockcard->balance;
        $this->previous_balance = $stockcard->previous_balance;
        if ($stockcard->action == 'I') {
            $this->show = true;
        } else {
            $this->show = false;
        }
        $this->toggleForm = true;
    }

    public function updateData()
    {

        $this->validate([
            'transaction_type' => 'required',
            'transaction_date' => 'required',
            'batch_number' => 'required',
            'commodity_id' => 'required',
            'comment' => 'required',
            'quantity' => 'required',
        ]);

        $stockcard = InvStockcard::findOrFail($this->edit_id);
        $stockcard->transaction_type = $this->transaction_type;
        $stockcard->transaction_date = $this->transaction_date;
        $stockcard->to_from = $this->source_or_destination;
        $stockcard->batch_number = $this->batch_number;
        $stockcard->commodity_id = $this->commodity_id;
        $stockcard->comment = $this->comment;
        $stockcard->expiry_date = $this->expiry_date;
        $stockcard->discrepancy = $this->transaction_type == 'Loss / Adjustment' ? $this->discrepancy : null;
        $stockcard->received_date = $this->transaction_type == 'Receive Stock' ? $this->transaction_date : null;
        $stockcard->quantity = $this->quantity;
        $stockcard->quantity_in = $this->quantity;
        $stockcard->discrepancy = $this->discrepancy;
        $stockcard->balance = $stockcard->quantity;
        $stockcard->quantity_in = $this->transaction_type == 'Receive Stock' ? $this->quantity : null;
        $stockcard->quantity_out = $this->transaction_type == 'Issue Stock' ? $this->quantity : null;
        $stockcard->physical_count = $this->transaction_type == 'Physical Count' ? $this->quantity : null;
        $stockcard->discrepancy = $this->discrepancy;
        $stockcard->losses_adjustments = $this->transaction_type == 'Loss / Adjustment' ? $this->quantity : null;
        $stockcard->previous_balance = $this->previous_balance;
        $stockcard->to_from = $this->transaction_type == 'Issue Stock' ? $this->stockcard->institution->name : $this->to_from;
        $stockcard->update();

        $this->resetInputs();
        $this->close();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Entry updated successfully!']);
    }

    public function updateBatchQuantity()
    {
        InvStockcard::updateOrCreate([
            'id' => $this->id,
        ], [
            'batch_number' => $this->batch_number,
            'expiry_date' => $this->expiry_date,
            'batch_balance' => $this->batch_quantity,
            'balance' => $this->batch_quantity,
            'quantity' => $this->batch_quantity,
            'comment' => $this->comment,
            'action' => 'L / A',
            'transaction_type' => 'Loss / Adjustment',
            'to_from' => 'Physical Count',
            'previous_balance' => $this->balance,
            'losses_adjustments' => $this->batch_quantity,
            'initials' => $this->initials,
            'commodity_id' => $this->commodity_id,
            'transaction_date' => $this->transaction_date,
            'institution_id' => \Auth::user()->institution_id,
        ]);

        $this->resetInputs();
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        $this->dispatchBrowserEvent('delete-modal');
    }

    public function deleteEntry()
    {
        InvStockcard::find($this->delete_id)->delete();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Entry successfully removed!']);
    }

    public function getStockcardId()
    {
        $this->commodity_id = InvStockcard::where('commodity_id', $stockcard_id->commodity_id)
            ->where('institution_id', \Auth::user()->institution_id)
            ->get();

        return $this->commodity_id;
    }

    public function updatedQuantityConfirmed()
    {

        $stockcardID = InvStockcard::where('id', $this->stockcard_id)->first();

        $this->previous_balance = $stockcardID->previous_balance;
        // $this->balance = $stockcardID->quantity_resolved;
        $this->discrepancy_value = $stockcardID->discrepancy;
        $this->commodity_id = $stockcardID->commodity_id;

        $this->batch_discrepancy = $this->discrepancy_value < 0 ? intval($this->discrepancy_value) + intval($this->quantity_confirmed) : intval($this->discrepancy_value) - intval($this->quantity_confirmed);

        if (intval($this->quantity_confirmed) > $this->discrepancy_value || intval($this->quantity_confirmed) < $this->discrepancy_value) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Warning',
                'text' => 'Quantity confirmed for this batch is less or more than the discrepancy value: '.$this->discrepancy_value.'Ignore this warning if it is intended',
            ]);
        }
    }

    public function resolveDiscrepancy(InvStockcard $stockcard)
    {
        // dd($stockcard->commodity_id);
        // $this->stockcard_id = $stockcard_id->id;
        // $this->commodity_id = $stockcard_id->commodity_id;

        $this->resolve_batch = InvStockcard::where('commodity_id', $stockcard->commodity_id)
            ->where('institution_id', \Auth::user()->institution_id)
            ->where('discrepancy', '<>', 0)
            ->whereNotNull('batch_balance')
            ->orderBy('expiry_date', 'asc')
            ->groupBy('batch_number')
            ->latest()
            ->get();

        $this->dispatchBrowserEvent('batch-discrepancy-modal');
    }

    public function saveResolvedDiscrepancy()
    {
        $this->validate([
            'batch_number' => 'required',
            'expiry_date' => 'required',
            'quantity_confirmed' => 'required',
        ]);

        // if(intval($this->quantity_confirmed) != $this->discrepancy_value){
        $stockcard = InvStockcard::create([
            'commodity_id' => $this->commodity_id,
            'institution_id' => \Auth::user()->institution_id,
            'quantity' => $this->quantity_confirmed,
            'action' => 'L/A',
            'batch_number' => $this->batch_number,
            'batch_balance' => $this->quantity_confirmed,
            'expiry_date' => $this->expiry_date,
            'initials' => $this->initials,
            'comment' => $this->comment,
            'balance' => intval($this->balance) + intval($this->quantity_confirmed),
            'transaction_date' => date('Y-m-d'),
            'physical_count' => $this->quantity_confirmed,
            // 'quantity_resolved' => intval($this->balance) + intval($this->quantity_confirmed),
            'transaction_type' => 'L/A',
            'to_from' => 'Discrepancy Resolution',
            'previous_balance	' => $this->previous_balance,
        ]);

        InvStockcard::updateOrCreate([
            'id' => $this->stockcard_id,
        ], [
            'discrepancy' => $this->discrepancy_value < 0 ? intval($this->discrepancy_value) + intval($this->quantity_confirmed) : intval($this->discrepancy_value) - intval($this->quantity_confirmed),
            // 'quantity_resolved' => $stockcard->balance,
        ]);
        // }

        // else{
        // $resolve_batch = StockCard::findOrFail($this->stockcard_id);
        // $resolve_batch->batch_balance = $this->quantity_confirmed;
        // $resolve_batch->batch_number = $this->batch_number;
        // $resolve_batch->expiry_date = $this->expiry_date;
        // $resolve_batch->quantity = $this->quantity_confirmed;
        // $resolve_batch->discrepancy = $this->discrepancy_value < 0 ? intval($this->discrepancy_value) + intval($this->quantity_confirmed) : intval($this->discrepancy_value) - intval($this->quantity_confirmed);
        // $resolve_batch->update();
        // }

        $this->resetInputs();
    }

    public function close()
    {
        $this->resetInputs();
    }

  public function resetInputs()
  {
    $this->reset([
    'comment',
    'quantity',
    'expiry_date',
    'discrepancy',
    'batch_number',
    'batch_quantity',
    'commodity_id',
    'batch_balance',
    'batch_discrepancy',
    'balance_on_hand',
    'transaction_type',
    'source_or_destination',
    'quantity_confirmed',
    'storage_bin',
    'storage_type',
    'storage_section',
    ]);
    $this->transaction_date = date('Y-m-d');
  }

    public function mainQuery()
    {
        $stockcards = InvStockcard::search($this->search)
            ->when(\Auth::user()->category == 'Core-Institution-Staff', function ($query) {
                $query->where('institution_id', \Auth::user()->institution_id);
            })
            ->when(\Auth::user()->hasPermission('view_facility_stock_status'), function ($query) {
                $query->where('institution_id', '!=', null);
            })
            ->when(\Auth::user()->category == 'Core-Institution-Staff', function ($query) {
                $query->where('institution_id', \Auth::user()->institution_id);
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
            ->when($this->transaction_type_filter, function ($query) {
                $query->where('transaction_type', $this->transaction_type_filter);
            })
            ->when($this->source_or_destination_filter, function ($query) {
                $query->where('to_from', $this->source_or_destination_filter);
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
        $distributors = InvSupplier::get(['name', 'id']);
        $items = InvItem::get(['name', 'id']);


        $stockcards = $this->mainQuery()
            ->paginate($this->perPage);

        return view('livewire.inventory.stock-mgt.stock-card', compact('stockcards', 'distributors', 'items'));
    }
}
