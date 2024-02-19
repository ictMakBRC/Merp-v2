<?php

namespace App\Http\Livewire\Inventory\Requests;

use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\Inventory\Requests\InvUnitRequest;
use App\Models\Inventory\Requests\InvUnitRequestItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InvUnitRequestItemsComponent extends Component
{
    public $request_data;
    public $request_code;
    public $active = 'items', $inv_requests_id;
    public $qty_left = 0, $request_qty, $inv_item_id;
    public function mount($code)
    {

        $this->request_data = InvUnitRequest::where('request_code', $code)->with('unitable', 'createdBy')->first();
        if ($this->request_data) {
            if ($this->request_data->status != 'Pending') {
                return redirect()->SignedRoute('inventory-request_view', $code);
            }
            $this->request_code = $code;
            $this->inv_requests_id = $this->request_data->id;
        }

    }
    public function updatedInvItemId()
    {
        $this->qty_left = 0;
        $activeItem = InvDepartmentItem::where('id', $this->inv_item_id)->first();
        $this->qty_left = $activeItem->qty_left - $activeItem->qty_held;
        $this->request_qty = 0;
    }
    public function addItem()
    {
        $this->validate([
            'inv_item_id' => 'required',
            'request_code' => 'required',
            'inv_item_id' => 'required',
            'request_qty' => 'required',
        ]);
        $isExist = InvUnitRequestItem::where('request_code', $this->request_code)
            ->where('inv_item_id', $this->inv_item_id)
            ->exists();
        if ($isExist) {
            DB::transaction(function () {
                InvUnitRequestItem::where('request_code', $this->request_code)->where('inv_item_id', $this->inv_item_id)
                    ->increment('qty_requested', $this->request_qty);
                InvDepartmentItem::where('id', $this->inv_item_id)->increment('qty_held', $this->request_qty);
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record Successfully updated !']);
            });
        } else {
            DB::transaction(function () {
                $value = new InvUnitRequestItem();
                $value->inv_requests_id = $this->inv_requests_id;
                $value->request_code = $this->request_code;
                $value->inv_item_id = $this->inv_item_id;
                $value->qty_requested = $this->request_qty;
                $value->save();
                InvDepartmentItem::where('id', $this->inv_item_id)->increment('qty_held', $this->request_qty);
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Item Successfully added']);
            });
        }
        $this->resetInputs();
    }
    public function destroyItem(InvUnitRequestItem $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $id = $request->id;
                $qty = $request->request_qty;
                $item = $request->inv_item_id;
                InvDepartmentItem::where('id', $item)->update(['qty_held' => DB::raw('qty_held - ' . $qty)]);
                InvUnitRequestItem::where('id', $id)->where('is_active', 0)->delete();
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record deleted successfully']);
            });
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to remove the item from the list, please refresh try again.',
            ]);
            // $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted']);
        }
    }
    public function resetInputs()
    {
        $this->reset([
            'inv_item_id',
            'request_qty',
            'qty_left',
            'inv_item_id',
        ]);
    }
    public function submitRequest($code)
    {
        try {
            DB::transaction(function () use ($code) {
                InvUnitRequest::where('request_code', $code)->update(['is_active' => 1,
                    'status' => 'Submitted', 'date_added' => date('Y-m-d H:i:s'),
                ]);

                InvUnitRequestItem::where('request_code', $code)->update(['is_active' => 1]);
                $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request Successfully submitted']);
                return redirect()->SignedRoute('inventory-request_view', $code);
            });
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to submit, please refresh your browser and try again.',
            ]);
        }
    }
    public function requestPreviewRoute($code)
    {
        return redirect()->SignedRoute('inventory-request_view', $code)->with('success', 'Request submitted successfully !!');
    }
    public function previewRequest()
    {
        $this->active = 'preview';
    }
    public function defultRoute()
    {
        return to_route('inv_user.dashboard')->with('error', 'Please selecte a departmet');
    }
    public function render()
    {
        $data['items'] = InvDepartmentItem::where(['unitable_id' => $this->request_data->unitable_id, 'unitable_type' => $this->request_data->unitable_type])
            ->with('item', 'unitable', 'item.uom')->get();
        $data['request_items'] = InvUnitRequestItem::where('inv_requests_id', $this->request_data->id)->with('departmentItem', 'departmentItem.item', 'departmentItem.item.uom')->get();
        return view('livewire.inventory.requests.inv-unit-request-items-component', $data);
    }
}
