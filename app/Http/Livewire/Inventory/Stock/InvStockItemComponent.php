<?php

namespace App\Http\Livewire\Inventory\Stock;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory\Settings\InvStore;
use App\Models\Inventory\Stock\InvStockLog;
use App\Models\Inventory\Stock\InvStockLogItem;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\Inventory\Stock\InvItemStockCard;

class InvStockItemComponent extends Component
{
    public $unitable_type;
    public $unitable_id;
    public $stockLog;
    public $is_active;
    public $display = 'd-none';
    public $inv_item_id;
    public $item_id;
    public $stock_qty;
    public $batch_no='N/A';
    public $supplier_id;
    public $expiry_date;
    public $stock_code;
    public $document_id;
    public $unit_cost;
    public $total_cost;
    public $inv_supplier_id;
    public $inv_store_id;
    public $expires = 'Off';
    public $delete_id;
    public $as_of;
    public $code;
    public $lpo;
    public $grn;
    public $delivery_no;
    public $inv_stock_log_id;
    public $item_data;
    public function mount($code)
    {
        $this->stockLog = $stockLog = InvStockLog::where('stock_code', $code)->first();
        $this->unitable_type = $stockLog->unitable_type;
        $this->unitable_id = $stockLog->unitable_id;
        $this->inv_stock_log_id = $stockLog->id;
        $this->stock_code = $code;
    }

    public function updatedInvItemId()
    {
       $this->item_data = $item_data = InvDepartmentItem::with(['item'])->where('id', $this->inv_item_id)->first();
        $this->unit_cost = $item_data->item->cost_price ?? 0;
        $this->expires = $item_data->item->expires ?? 'Off';
        $this->item_id = $item_data->inv_item_id;
    }
    public function storeItem()
    {
        $this->validate([
            'inv_stock_log_id' => 'required|numeric',
            'inv_item_id' => 'required|numeric',
            'stock_qty' => 'required|numeric',
            'batch_no' => 'nullable',
            'expiry_date' => 'nullable|date',
            'unit_cost' => 'nullable|numeric',
            'total_cost' => 'nullable|numeric',
            'inv_store_id' => 'nullable|numeric',
            'stock_code' => 'required|string',
        ]);

        $total_cost = $this->unit_cost * $this->stock_qty;
        $isExist = InvStockLogItem::select('*')
            ->where('stock_code', $this->stock_code)
            ->where('inv_item_id', $this->inv_item_id)
            ->where('batch_no', $this->batch_no??'N/A')
            ->exists();
        if ($isExist) {
           $stock = InvStockLogItem::where('stock_code', $this->stock_code)
                ->where('inv_item_id', $this->inv_item_id)
                ->where('batch_no', $this->batch_no??'N/A')->first();
                $stock_qty = $stock->stock_qty + $this->stock_qty;
                $qyt_left = $stock->qyt_left + $this->stock_qty;
                //->increment('stock_qty',$this->stock_qty'))
                $stock->stock_qty =$stock_qty;
                $stock->qyt_left =$qyt_left;
                $stock->update();
               
                $stockCard = InvItemStockCard::where(['inv_item_id' => $this->inv_item_id,'voucher_number' => $this->stock_code,'batch_id'=>$stock->id])->first();               
                $stockCard->quantity_in = $stock->stock_qty;
                $stockCard->batch_balance = $stock->stock_qty;
                $stockCard->quantity = $stock->stock_qty;
                $stockCard->save();
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record updated successfully!']);
        } else {
            $value = new InvStockLogItem();
            $value->inv_stock_log_id = $this->inv_stock_log_id;
            $value->inv_item_id = $this->inv_item_id;
            $value->stock_qty = $this->stock_qty;
            $value->qyt_left = $this->stock_qty;
            $value->batch_no = $this->batch_no??'N/A';
            $value->expiry_date = $this->expiry_date;
            $value->unit_cost = $this->unit_cost;
            $value->total_cost = $this->total_cost;
            $value->inv_store_id = $this->inv_store_id;
            $value->stock_code = $this->stock_code;
            $value->stock_code = $this->code;
            $value->save();
            $stockCard = new InvItemStockCard();
            $stockCard->batch_id = $value->id;
            $stockCard->request_id = null;
            $stockCard->inv_item_id = $this->inv_item_id;
            $stockCard->voucher_number = $this->stock_code;
            $stockCard->quantity = $this->stock_qty;
            $stockCard->comment = 'Receive Stock';
            $stockCard->quantity_in = $this->stock_qty;
            $stockCard->quantity_out = null;
            $stockCard->opening_balance = null;
            $stockCard->losses_adjustments = null;
            $stockCard->physical_count = $this->item_data->qty_left;
            $stockCard->item_balance = $this->item_data->qty_left;
            $stockCard->discrepancy = null;
            $stockCard->quantity_resolved = null;
            $stockCard->batch_balance = $value->qyt_left;
            $stockCard->initial_quantity = $value->qyt_left;
            $stockCard->transaction = 'Incoming';
            $stockCard->transaction_type = 'IN';
            $stockCard->save();

            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record added successfully!']);
        }
    }
    public function SaveStock()
    {
        $this->validate([
            'inv_stock_log_id' => 'required|numeric',
            'delivery_no' => 'required',
            'lpo' => 'required',
            'grn' => 'required',

        ]);
        DB::transaction(function () {
            $value = InvStockLog::where('id', $this->inv_stock_log_id)->first();
            $value->status = 'Received';
            $value->delivery_no = $this->delivery_no;
            $value->lpo = $this->lpo;
            $value->grn = $this->grn;
            $items = InvStockLogItem::where('inv_stock_log_id', $value->id)->get();
            // dd($items);
            foreach ($items as  $myItem) {
                $item = $myItem->inv_item_id;
                $qty = $myItem->stock_qty;
                // dd($qty);
               $dptItem = InvDepartmentItem::where('id', $item)->first();
               $newQty=$dptItem->qty_left+$qty;
               $dptItem->qty_left = $newQty;
               $dptItem->update();
            //    dd($dptItem);
            //    ->update(['qty_left' => DB::raw('qty_left + ' . $qty)]);
            }
            $value->update();
            
        $this->dispatchBrowserEvent('swal:modal', [
            'type' => 'success',
            'message' => 'Done!',
            'text' => 'Stock values.',
        ]);
        return to_route('inventory-stock_doc', 'all');
        });
    }
    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        // $this->dispatchBrowserEvent('delete-modal');
        $this->deleteEntry();
    }

    public function deleteEntry()
    {
        $dept_item = InvStockLogItem::findOrFail($this->delete_id);
        // dd($dept_item);
        $dept_item->delete();

        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Entry successfully deleted!']);
    }

    public function deleteStockDoc($stock_code)
    {
        try {
            $doc = InvStockLog::where(['stock_code' => $stock_code, 'status' => 'Pending'])->first();
            if ($doc) {
                // dd($stock_code);
                $value = InvStockLogItem::where('inv_stock_log_id', $doc->id)->delete();
                $doc->delete();
                $this->delete_id = '';
                $this->dispatchBrowserEvent('close-modal');
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Item deleted successfully!']);
                return to_route('inventory-stock_doc', 'all');
            } else {
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'message' => 'Something went wrong!',
                    'text' => 'Failed to submit, please refresh your browser and try again.',
                ]);
            }
        } catch (Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Document Can not be deleted because: '.$error,
            ]);
        }
    }

    public function cancel()
    {
        $this->delete_id = '';
    }

    public function close()
    {
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset([
            'inv_item_id',
            'stock_qty',
            'expiry_date',
            'unit_cost',
            'total_cost',
            'inv_store_id',
        ]);
        $this->batch_no ='N/A';
    }
    public function render()
    {
        $data['items'] = InvDepartmentItem::where(['unitable_id' => $this->unitable_id, 'unitable_type' => $this->unitable_type])
            ->with('item', 'unitable', 'item.uom')->get();
        $data['stock_items'] = InvStockLogItem::where('inv_stock_log_id', $this->stockLog->id)->with('departmentItem','departmentItem.item', 'store', 'departmentItem.item.uom')->get();
        $data['stores'] = InvStore::where('is_active', 1)->get();
        return view('livewire.inventory.stock.inv-stock-item-component', $data);
    }
}
