<?php

namespace App\Http\Livewire\Inventory\Requisitions;

use App\Models\Inventory\Item\InvItem;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\Inventory\Requisitions\InvDepartmentRequest;
use App\Models\Inventory\Settings\InvCategory;
use App\Models\Inventory\Settings\InvUnitOfMeasure;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Services\GeneratorService;
use Livewire\WithPagination;
use Livewire\Component;

class GeneralRequisitionsComponent extends Component
{

  use WithPagination;

  public $department ;

  public $department_id;

  public $from_date;

  public $to_date;

  public $customerIds;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'id';

  public $orderAsc = 0;

  public $delete_id;

  public $edit_id;

  protected $paginationTheme = 'bootstrap';

  public $createNew = false;

  public $toggleForm = false;

  public $filter = false;

  public $qty_left;

  public $item_id;

  public $items =[];

  public $brand;

  public $request_code;

  public $qty_required;

  public $comment;

  public $hod = [];

  public $approver;

  public $cancel_id;

  public $reject_id;

  public $issue_id;

  public $orders;

  public $stock_balance;

  public $requested_by;

  public $dispatch_comment;

  public $quantity_dispatched;

  public function mount()
  {
    $this->items = collect([]);
    $this->orders = collect([]);
  }

  public function HodApproveRequest($id)
  {
    $request = InvDepartmentRequest::findOrFail($id);
    $request->status = 1;
    $request->update();

    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reqquest successfully approved!']);
  }

  public function storeApproveRequest($id)
  {
    $request = InvDepartmentRequest::findOrFail($id);
    $request->status = 3;
    $request->update();

    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reqquest successfully approved!']);
  }

  public function removeFromList(InvDepartmentRequest $request)
  {
    $request->delete();
    $this->orders = InvDepartmentRequest::where('request_code', $this->request_code)->latest()->get();
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Item successfully removed from order!']);
  }

  public function cancelRequest($id)
  {
    $this->cancel_id = $id;
    $this->dispatchBrowserEvent(['confirm-cancel-modal']);
  }

  public function confirmRequestCancel()
  {
    $request = InvDepartmentRequest::findOrFail($this->cancel_id);
    $request->status = 7;
    $request->update();

    $this->dispatchBrowserEvent(['close-modal']);
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reqquest successfully canceled!']);
  }

  public function rejectRequest($id)
  {
    $this->reject_id = $id;
    $this->dispatchBrowserEvent(['reject-request-modal']);
  }

  public function saveRejectedRequest()
  {
    $request = InvDepartmentRequest::findOrFail($this->cancel_id);
    $request->status = 7;
    $request->update();

    $this->dispatchBrowserEvent(['close-modal']);
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reqquest successfully canceled!']);
  }

  public function issueStock($id)
  {

    $request = InvDepartmentRequest::findOrFail($id);

    $this->item_id = $request->item_id;
    $this->ordered_by = $request->ordered_by;
    $this->email = $request->email;
    $this->quantity_required = $request->quantity_required;
    $this->request_code = $request->request_code;
    $this->department_id = $request->department->name;
    $this->item_id = $request->item->name;
    $this->brand = $request->item->brand;
    $this->order_date = $request->order_date;

    $this->issue_id = $id;

    //get stock balance
    $this->stock_balance = InvDepartmentItem::where('inv_item_id',$request->item_id)
    ->value('qty_left');

    $this->dispatchBrowserEvent(['issue-item-modal']);
  }

  public function saveIssueStock()
  {
    $this->validate([
    'quantity_dispatched' => 'required|numeric',
    ]);

    $request = InvDepartmentRequest::find($this->issue_id);

    $request->status = 5;
    $request->dispatched_by = \Auth::user()->id;
    $request->dispatch_date = date('Y-m-d');
    $request->dispatch_comment = $this->dispatch_comment;
    $request->quantity_dispatched = $this->quantity_dispatched;
    $request->update();

    $this->close();
    $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Item issued successfully!']);

  }

  public function editData($id)
  {
    $this->createNew = true;
    $this->toggleForm = true;

    $request = InvDepartmentRequest::findOrFail($id);

    $this->item_id = $request->item_id;
    $this->order_type = $request->order_type;
    $this->ordered_by = $request->ordered_by;
    $this->email = $request->email;
    $this->quantity_required = $request->quantity_required;
    $this->request_code = $request->request_code;
    $this->department_id = $request->department_id;
    $this->comment = $request->comment;
    $this->order_date = $request->order_date;
    $this->edit_id = $id;
    $this->dispatchBrowserEvent('show-modal');

  }

  public function storeData()
  {
    $this->validate([
    'item_id' => 'required',
    'approver' => 'required',
    'qty_required' => 'required',
    'department_id' => 'required',
    ]);

    $request = new InvDepartmentRequest();

    $request->status = 0;
    $request->order_type = 1;
    $request->item_id = $this->item_id;
    $request->comment = $this->comment;
    $request->order_date = date('Y-m-d');
    $request->email = \Auth::user()->email;
    $request->approver_id = $this->approver;
    $request->ordered_by = \Auth::user()->id;
    $request->request_code = $this->request_code;
    $request->department_id = $this->department_id;
    $request->quantity_required = $this->qty_required;
    $request->save();

    $this->orders = collect([]);
    $this->orders = InvDepartmentRequest::where('request_code', $this->request_code)->latest()->get();

    // $this->close();
    // $this->dispatchBrowserEvent('close-modal');
    $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Reqquest successfully submitted!']);
  }

  public function newRequest()
  {
    $this->request_code = GeneratorService::requestCode();
    $this->dispatchBrowserEvent('new-request-modal');
  }

  public function close()
  {
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
  }

  public function resetInputs()
  {

    $this->reset([
    'qty_left',
    'item_id',
    'items',
    'brand',
    'request_code',
    'department_id',
    'qty_required'
    ]);

  }

  public function export()
  {

  }

  public function updatedItemId()
  {
    $this->qty_left = InvDepartmentItem::where('inv_item_id',$this->item_id)
    ->value('qty_left');

    $this->brand = InvDepartmentItem::where('inv_item_id',$this->item_id)
    ->value('brand');
  }

  public function updatedDepartmentId()
  {
    $this->items = InvDepartmentItem::where('department_id',$this->department_id)
    ->get();
    $this->hod = Employee::where('department_id',$this->department_id)
    ->orderBy('id', 'asc')->get();
  }

  public function mainQuery()
  {
    return InvDepartmentRequest::search($this->search)
    ->when(\Auth::user()->category == 'System-Admin', function ($query) {
      $query->whereIn('status',[1,3,5,6]);
      // $query->where('department_id',\Auth::user()->$employee->department);
    })
    ->when(\Auth::user()->category == 'Deparment-staff', function ($query) {
      $query->where('department_id',\Auth::user()->$employee->department);
    })
    ->when($this->department, function ($query) {
      $query->where('department_id',$this->department);
    })
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');
  }

  public function render()
  {
    $data['requests'] = $this->mainQuery()
    ->paginate($this->perPage);

    $data['departments'] = Department::orderBy('name', 'asc')->get();

    return view('livewire.inventory.requisitions.general-requisitions-component',$data);
  }
}
