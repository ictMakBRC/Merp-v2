<?php

namespace App\Http\Livewire\Inventory\Manage;

use Exception;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\inventory\invStores;
use App\Models\inventory\invSubunits;
use App\Models\inventory\invSuppliers;
use App\Models\inventory\invStocklevel;
use App\Models\Inventory\InvStockDocument;
use App\Models\inventory\invStockSettlement;
use App\Models\inventory\inv_department_Item;
use App\Models\Inventory\InvStockDocumentItem;

class ReceiveStockComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'subunit_name';
    public $active ='';
    public $orderAsc = true;

    public $subunit_name;

    public $edit_id;

    public $is_active;
    public $display ='d-none';
    public $invitemid;
    public $item_id;
    public $stock_qty;
    public $batch_no;
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
    public $defult_department;
    public $department;
    public $departments;
    public $stock_docement;
    public $create_new = false;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'invitemid' => 'required',
            'as_of' => 'required',

        ]);
    }

    public function mount($id)
    {
        $this->code = $id;
        
        $this->stock_docement = InvStockDocument::where('stock_code',$this->code)->with('department')->first();
        if($this->stock_docement != null){
            if ($this->stock_docement->is_active == 1){
                $this->active ='d-none';
            }
            $this->defult_department = $this->stock_docement->department_id;
            $this->create_new = false;
            $this->document_id = $this->stock_docement->id;
            $this->active ='';
        }else{
            $this->departments = Department::where('status','Active')->get();
            $this->create_new = true;
        }

    }

    public function addNewStockDoc()
    {
        $this->validate([
            'defult_department' => 'required',
        ]);

        $value = new InvStockDocument();
        $value->department_id = $this->defult_department;
        $value->stock_code = $this->code;
        $value->date_added = $this->as_of;
        $value->stock_year = date('Y');
        $value->stock_month = date('M-Y');
        $value->stock_week = date('Y-M-W');
        $value->user_id = auth()->user()->id;
        $value->save();
        $this->create_new = false;
        $this->resetInputs();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'value created successfully!']);
    }


    public function updatedinvitemid()
    {
        $item_data = inv_department_Item::with(['item'])->where('id',$this->invitemid)->first();
        $this->unit_cost = $item_data->item->cost_price??0;
        $this->expires = $item_data->item->expires??'Off';
        $this->item_id = $item_data->inv_item_id;
    }

   
    public function storeItem()
    {
        $this->validate([
            'inv_store_id' => 'required',
            'stock_qty' => 'required|numeric',
            'document_id' => 'required|numeric',
            'unit_cost' => 'required',
            'as_of' => 'required',
            'invitemid' => 'required',
            'defult_department'=>'required',
        ]);
    
        $total_cost = $this->unit_cost * $this->stock_qty;
        $isExist = InvStockDocumentItem::select('*')
        ->where('stock_code', $this->code)
        ->where('inv_item_id', $this->invitemid)
        ->exists();
        if ($isExist) {
            InvStockDocumentItem::where('stock_code', $this->code)
            ->where('inv_item_id', $this->invitemid)
            //->increment('stock_qty',$this->stock_qty'))
            ->update([
                'stock_qty' => DB::raw('stock_qty + '.$this->stock_qty),
                'qyt_remaining' => DB::raw('qyt_remaining + '.$this->stock_qty),
                'total_cost' => DB::raw('total_cost + '.$total_cost),
            ]);
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Record updated successfully!']);
        } else {
            $value = new InvStockDocumentItem();
            $value->document_id = $this->document_id;
            $value->department_id = $this->defult_department;
            $value->inv_supplier_id = $this->inv_supplier_id;
            $value->stock_qty = $this->stock_qty;
            $value->qyt_remaining = $this->stock_qty;
            $value->batch_no = $this->batch_no;
            $value->unit_cost = $this->unit_cost;
            $value->total_cost = $total_cost;
            $value->date_added = $this->as_of;
            $value->expiry_date = $this->expiry_date;
            $value->inv_item_id = $this->invitemid;
            $value->item_id = $this->item_id;
            $value->inv_store_id = $this->inv_store_id;
            $value->stock_code = $this->code;
            $value->user_id = auth()->user()->id;
            $value->save();

            $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Record added successfully!']);
        }
    }
    //chkdsk
    // wmic
    // diskdrive get status

    public function SaveStock()
    {
        $this->validate( [
            'item' => 'required',
            'quantity' => 'required',
            'stockcode' => 'required',
            'delivery_no' => 'required',
            'lpo' => 'required',
            'grn' => 'required',

        ]);
        InvStockDocumentItem::where('stock_code', $this->code)
        ->update(['is_active' => '1', 'delivery_no' => $this->delivery_no, 'lpo' => $this->lpo, 'grn' => $this->grn]);
        $value = InvStockDocumentItem::where('stock_code', $this->code);
        $value->is_active = 1;
        $value->delivery_no = $this->delivery_no;
        $value->lpo = $this->lpo;
        $value->grn = $this->grn;
        $value->update();
        foreach ($this->item as $key => $value) {
            $item = $value;
            $qty = $this->quantity[$key];
            inv_department_Item::where('inv_department_items.id', $item)
            ->increment('qty_left', $qty);
        }
    }

   
    public function resetInputs()
    {
        $this->reset([
            'inv_store_id',
            'stock_qty',
            'unit_cost',
            'batch_no',
            'invitemid',
            'expiry_date',
            'item_id'
        ]);
        $this->expires = 'Off';
    }
   

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function deleteConfirmation($id)
    {
        $this->delete_id = $id;
         $this->dispatchBrowserEvent('swal:delete-confirm', [
            'type' => 'warning',
            'message' => 'Are you sure you want to proceed?',
            'text' => 'If yes, This Item will be completely deleted from this stock document!',
        ]);
    }

    public function deleteStockDoc($stock_code)
    {
        
        try {
            $doc = InvStockDocument::where(['stock_code' => $stock_code, 'is_active'=>0])->first();
            if($doc){
            $value = InvStockDocumentItem::where('document_id', $doc->id)->delete();
            $doc->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item deleted successfully!']);
            }else{
                $this->dispatchBrowserEvent('swal:modal', [
                    'type' => 'error',
                    'message' => 'Something went wrong!',
                    'text' => 'Failed to submit, please refresh your browser and try again.',
                ]);
            }
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted!']);
        }
    }

    public function deleteItem()
    {
       
        try {
            $value = InvStockDocumentItem::where('id', $this->delete_id)->first();
            $value->delete();
            $this->delete_id = '';
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item deleted successfully!']);
        } catch(Exception $error) {
            $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted!']);
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

    public function render()
    {
        $data['stores'] = invStores::orderBy('store_name', 'asc')->get();
        $data['suppliers'] = invSuppliers::orderBy('sup_name', 'asc')->get(); //getting all suppliers
        $data['items'] = inv_department_Item::with(['item', 'item.parentUom','item.subUmit'])
        ->where('department_id',$this->defult_department)->get();
        $data['stock_items'] = InvStockDocumentItem::search($this->search)->with(['item','item.parentUom','item.subUmit'])
        ->where('stock_code', $this->code)->paginate($this->perPage);
        if ($this->create_new){
        $data['stock_docments'] = InvStockDocument::search($this->search)->with('department')
        ->orderBy('created_at','desc')
        ->paginate($this->perPage);
        }else{
            $data['stock_docments'] =[];
        }
        return view('livewire.inventory.manage.receive-stock-component', $data)->layout('inventdashboard.layouts.app');
    }
}
