<?php

namespace App\Http\Livewire\Inventory\Requests;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\inventory\Requisitions\invRequest;
use App\Models\Inventory\Requisitions\invRequestitem;

class InvRequestComponent extends Component
{
    public $qty_left;
    public $inv_item_id;
    public $request_qty;
    public $request_code;
    public $inv_items_id;
    public function mount($code)
    {
            $this->request_code = $code;
    
    }
    public function updatedInvItemsId()
    {
       $this->qty_left = 0;
       $activeItem = InvDepartmentItem::where('id',$this->inv_items_id)->first();
       if($activeItem){
        $this->qty_left = $activeItem->qty_left - $activeItem->qty_held;
        $this->inv_item_id = $activeItem->inv_item_id;
        $this->request_qty = 0;
       }
    }
    public function addItem()
    {
        $this->validate([
            'inv_item_id' => 'required',
            'request_code' => 'required',
            'inv_items_id' => 'required',
            'request_qty' => 'required',
        ]);
        $isExist = invRequestitem::where('request_code', $this->request_code)
        ->where('inv_items_id', $this->inv_items_id)
        ->exists();
        if ($isExist) {
            invRequestitem::where('inv_requestitems.request_code', $this->request_code)
            ->where('inv_requestitems.inv_items_id', $this->inv_items_id)
            ->increment('request_qty', $this->request_qty);
            InvDepartmentItem::where('id', $this->inv_items_id)->increment('qty_held',$this->request_qty);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Record Successfully updated !']);
        } else {
            $value = new invRequestitem();
            $value->inv_requests_id = $this->inv_requests_id;
            $value->request_code = $this->request_code;
            $value->inv_items_id = $this->inv_items_id;
            $value->inv_item_id = $this->inv_item_id;
            $value->request_qty = $this->request_qty;
            $value->users_id = auth()->user()->id;
            $value->save();
            InvDepartmentItem::where('id', $this->inv_items_id)->increment('qty_held',$this->request_qty);
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item Successfully added']);
        }
        $this->resetInputs();
    }
    public function destroyItem(invRequestitem $request)
    {
        $id = $request->id;
        $qty = $request->request_qty;
        $item = $request->inv_items_id;
        try {
            InvDepartmentItem::where('id', $item) ->update(['qty_held' => DB::raw('qty_held - '.$qty)]);
            invRequestitem::where('id', $id)->where('is_active', 0)->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Record deleted successfully']);
        } catch(\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to remove the item from the list, please refresh try again.',
            ]);
            // $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted']);
        }
    }
    public function render()
    {
        $data['request'] = $requestData = invRequest::where('request_code',$this->request_code)->with('unitable','loantable','requester','approver')->first();
        $data['requestItems']=invRequestitem::where('inv_requests_id', $requestData?->id)->get();
        $data['items']=InvDepartmentItem::where(['unitable_id'=>$requestData?->unitable_id, 'unitable_type'=>$requestData?->unitable_type])->with('item','item.uom')->get();
        return view('livewire.inventory.requests.inv-request-component', $data);
    }
}
