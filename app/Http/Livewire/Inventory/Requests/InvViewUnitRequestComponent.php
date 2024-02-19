<?php

namespace App\Http\Livewire\Inventory\Requests;

use App\Jobs\SendNotifications;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\Inventory\Requests\InvUnitRequest;
use App\Models\Inventory\Requests\InvUnitRequestItem;
use App\Models\Inventory\Settings\InvSetting;
use App\Models\Inventory\Stock\InvItemStockCard;
use App\Models\Inventory\Stock\InvStockIssueLog;
use App\Models\Inventory\Stock\InvStockLogItem;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Throwable;

class InvViewUnitRequestComponent extends Component
{
    public $request_data;
    public $request_code;
    public $active = 'items', $inv_requests_id;
    public $qty_left = 0, $request_qty, $inv_item_id;
    public $filter = false;
    public $request_type = 'Normal';
    public $unit_type = 'department';
    public $description;
    public $unit_id = 0;
    public $unitable_type;
    public $unitable_id;
    public $unitable;
    public $click_action;
    public $acknowledge;
    public $approver;
    public $approver_comment;
    public $comment;
    public $inventory_data;
    public $active_item;
    public $active_item_id;
    public $stock_batches;
    public $issued_amount;
    public $active_batch;
    public function mount($code)
    {
        $this->stock_batches = collect([]);
        $this->inventory_data = InvSetting::first();
        $this->request_data = InvUnitRequest::where('request_code', $code)->with('unitable', 'createdBy')->first();
        if ($this->request_data) {
            $this->request_code = $code;
            $this->inv_requests_id = $this->request_data->id;
            if ($this->request_data->entry_type == 'department') {
                $this->approver = $this->request_data->unitable->supervisor;
            } elseif ($this->request_data->entry_type == 'project') {
                $this->approver = $this->request_data->unitable->coordinator_id;
            }
        }
        if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
            $this->unit_id = session('unit_id');
            $this->unit_type = session('unit_type');
            $this->unitable = $unitable = Project::find($this->unit_id);
        } else {
            $this->unit_id = auth()->user()->employee->department_id ?? 0;
            $this->unit_type = 'department';
            $this->unitable = $unitable = Department::find($this->unit_id);
        }

        if ($unitable) {
            $this->unitable_type = get_class($unitable);
            $this->unitable_id = $this->unit_id;
        } else {
            // abort(403, 'Unauthorized access or action.');
        }

    }
    public function approveRejectRequest($id)
    {
        try {
            $this->validate([
                'click_action' => 'required',
            ]);
            $request = InvUnitRequest::where('id', $id)->first();
            $request->approval_comment = $this->approver_comment;
            $request->status = $this->click_action;
            $request->approved_at = date('Y-m-d H:i:s');
            $request->approved_by = auth()->user()->id;
            $request->update();
            if ($this->click_action == 'Approved') {
                $body = 'Hello, You have a Inventory pending request #' . $this->request_code . ' to sign, with Comment: ' . $this->approver_comment . ' please login to view more details';
                $this->SendMail($this->inventory_data->manager_id ?? 1, $body);
                $body2 = 'Hello, Your Inventory request #' . $this->request_code . ' has been approved, please followup with the inventory manager';
                $this->SendMail($request->created_by, $body2);
            } else {
                $body = 'Hello, Your Inventory request #' . $this->request_code . ' has been declined, with Comment: ' . $this->approver_comment . ' please login to view more details';
                $this->SendMail($request->created_by, $body);
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request Successfully ' . $this->click_action]);
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to submit, please refresh your browser and try again. ' . $error,
            ]);
        }
    }
    public function receiveRejectRequest($id)
    {
        try {
            $this->validate([
                'click_action' => 'required',
            ]);
            $request = InvUnitRequest::where('id', $id)->first();
            $request->processor_comment = $this->approver_comment;
            $request->status = $this->click_action;
            $request->processed_at = date('Y-m-d H:i:s');
            $request->processed_by = auth()->user()->id;
            $request->update();
            if ($this->click_action == 'Received') {
                $body = 'Hello, Your Inventory request #' . $this->request_code . ' has been received at the store, please followup with the inventory manager for- your item(s)';
                $this->SendMail($request->created_by, $body);
            } else {
                $body = 'Hello, Your Inventory request #' . $this->request_code . ' has been declined, with Comment: ' . $this->approver_comment . ' please login to view more details';
                $this->SendMail($request->created_by, $body);
            }
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request Successfully ' . $this->click_action]);
            $this->dispatchBrowserEvent('close-modal');
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to submit, please refresh your browser and try again. ' . $error,
            ]);
        }
    }
    public function SendMail($id, $body)
    {
        try {
            $user = User::where('id', $id)->first();
            $link = URL::signedRoute('inventory-request_view', $this->request_code);
            $notification = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'MERP Inventory Request',
                'greeting' => 'Dear ' . $user->title . ' ' . $user->name,
                'body' => $body,
                'thanks' => 'Thank you, incase of any question, please reply to support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => $link,
                'unit_id' => $this->unit_id,
                'unitable_type' => $this->unit_type,
                'user_id' => $id,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
            $mm = SendNotifications::dispatch($notification)->delay(Carbon::now()->addSeconds(20));
            //   dd($mms);
        } catch (Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Document has been successfully marked complete! ']);
    }
    public function fetchBatches($item_id)
    {
        $this->stock_batches = collect([]);
        $this->active_item = InvUnitRequestItem::where('id', $item_id)->with('departmentItem', 'departmentItem.item', 'departmentItem.item.uom')->first();
        if ($this->active_item) {
            $this->active_item_id = $this->active_item->id;
            $this->stock_batches = InvStockLogItem::where('inv_item_id', $this->active_item->inv_item_id)->where('qyt_left', '>', 0)
                ->orderBy('created_at', 'asc')->orderBy('expiry_date', 'asc')->get();
            // $this->active_batch = $this->stock_batches
        }
    }
    public function setBatch()
    {

    }
    public function issueStock($id)
    {
        $qtyRemaining = $this->active_item->qty_requested - $this->active_item->qty_given;
        if ($this->issued_amount > $qtyRemaining ?? 0) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => "Issued quantity(" . $this->issued_amount . ") > requested qty!",
                'text' => 'Please revise your quantity issued and try again. ' . $this->active_item->qty_requested,
            ]);
            $this->issued_amount = null;
            return false;
        } else {
            $this->validate([
                'issued_amount' => 'required|numeric|min:1',
            ]);
            DB::transaction(function () use ($id) {
                $stock_batch = InvStockLogItem::where('id', $id)->first();
                if ($stock_batch) {
                    $stockBalance = $stock_batch->qyt_left;
                    /* The code below is updating the quantity given for a specific item in a database
                    table. It retrieves the active item based on its ID, calculates the new quantity
                    by adding the issued amount to the current quantity given, and then updates the
                    quantity given for that item in the database. */
                    $active_item = InvUnitRequestItem::where('id', $this->active_item_id)->first();
                    $newQty = $active_item->qty_given + $this->issued_amount;
                    $active_item->qty_given = $newQty;
                    $active_item->update();

                    /* The code below is subtracting the issued amount from the quantity left in a
                    stock batch and updating the quantity left in the stock batch. */
                    $stockLeft = $stock_batch->qyt_left - $this->issued_amount;
                    $stock_batch->qyt_left = $stockLeft;
                    $stock_batch->update();

                    /* The code below is creating a new instance of the InvStockIssueLog class and
                    assigning values to its properties. It then saves the instance to the database. */
                    $log = new InvStockIssueLog();
                    $log->qty_given = $this->issued_amount;
                    $log->request_item_id = $this->active_item_id;
                    $log->batch_id = $stock_batch->id;
                    $log->save();

                    /* This code is updating the quantity left of an inventory item in a specific
                    department. */
                    $department_Item = InvDepartmentItem::where('id', $active_item->inv_item_id)->first();
                    $dptItemQty = $department_Item->qty_left;
                    $dptItemQtyLeft = $department_Item->qty_left - $this->issued_amount;;
                    $department_Item->qty_left = $dptItemQtyLeft;
                    $department_Item->save();

                    /* The above code is creating a new instance of the InvItemStockCard class and
                    setting its properties with various values. It then saves the instance to the
                    database. */
                    $stockCard = new InvItemStockCard();
                    $stockCard->batch_id = $stock_batch->id;
                    $stockCard->request_id = $this->inv_requests_id;
                    $stockCard->inv_item_id = $active_item->inv_item_id;
                    $stockCard->voucher_number = $this->request_code;
                    $stockCard->quantity = $this->issued_amount;
                    $stockCard->comment = 'Issued Stock';
                    $stockCard->quantity_in = null;
                    $stockCard->quantity_out = $this->issued_amount;
                    $stockCard->opening_balance = null;
                    $stockCard->losses_adjustments = null;
                    $stockCard->physical_count = $dptItemQty;
                    $stockCard->item_balance = $department_Item->qty_left;
                    $stockCard->discrepancy = null;
                    $stockCard->quantity_resolved = null;
                    $stockCard->batch_balance = $stock_batch->qyt_left;
                    $stockCard->initial_quantity = $stockBalance;
                    $stockCard->transaction = 'Outgoing';
                    $stockCard->transaction_type = 'OUT';
                    $stockCard->save();

                    $this->issued_amount = null;
                    $this->active_batch = null;
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Stock issued successfully']);
                } else {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'error',
                        'message' => "Something went wrong!",
                        'text' => 'Please revise your transaction and try again',
                    ]);
                }

            });

        }
    }
    function closeRequest() {
        try{
            DB::transaction(function () {
               $request = InvUnitRequest::where('id', $this->request_data->id)->first();
                $items = InvUnitRequestItem::where('inv_requests_id', $this->request_data->id)->where('status','Pending')->get();
                if(count($items)>0){
                    foreach($items as $item){
                    $activeItem = InvUnitRequestItem::where('id', $item->id)->first();
                    $invItem = InvDepartmentItem::where('id', $activeItem->inv_item_id)->first();
                    $newHeld = $invItem->qty_held - $activeItem->qty_requested;
                    $invItem->qty_held = $newHeld;
                    $invItem->update();
                    $activeItem->status ='Processed';
                    $activeItem->update();                    
                    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item processed']);
                    }
                }
                $request->status ='Processed';
                $request->save();
            });
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'success',
                'message' => 'Done!',
                'text' => 'Request successfully processed.',
            ]);
        } catch (\Exception $error) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Something went wrong!',
                'text' => 'Failed to remove the item from the list, please refresh try again.',
            ]);
            // $this->dispatchBrowserEvent('alert', ['type' => 'error',  'message' => 'Record can not be deleted']);
        }

    }
    public function close()
    {
        $this->click_action = null;
        $this->stock_batches = collect([]);
        $this->active_item = null;
        $this->issued_amount = null;
        $this->active_batch = null;
    }
    public function render()
    {

        $data['request_items'] = InvUnitRequestItem::where('inv_requests_id', $this->request_data->id)->with('departmentItem', 'departmentItem.item', 'departmentItem.item.uom')->get();
        return view('livewire.inventory.requests.inv-view-unit-request-component', $data);
    }
}
