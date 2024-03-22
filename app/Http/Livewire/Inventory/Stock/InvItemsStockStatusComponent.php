<?php

namespace App\Http\Livewire\Inventory\Stock;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\HumanResource\Settings\Department;

class InvItemsStockStatusComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

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

    public $entry_type = 'Department';
    public $unit_id;
    public $exportData;
    public $procurement_id;
    public $stock_code;
    public $grn;
    public $delivery_no;
    public $lpo;
    public $date_added;
    public $status;
    public $created_by;
    public $acknowledged_by;
    public $acknowledged_at;
    public $updated_by;
    public $unitable_type;
    public $unitable_id;
    public $todayDate;
    public $unit_type;
    public $requestable;
    public $requestable_type;
    public $requestable_id;
    public $type;

    public function mount($type)
    {
        $this->type =$type;
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->requestable = $requestable = Project::find($this->unit_id);
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->requestable = $requestable = Department::find($this->unit_id);
            }
            if ($requestable) {
                $this->unitable_type = get_class($requestable);
                $this->unitable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }
        $this->todayDate = date('Y-m-d');
        $this->date_added = date('Y-m-d');
    }
  
    public function close()
  {
    $this->resetInputs();
    $this->dispatchBrowserEvent('close-modal');
  }

  public function refresh()
  {
    return redirect(request()->header('Referer'));
  }

    public function resetInputs()
    {
        $this->reset([
            'date_added',
            'unit_id',
            'entry_type',
            'procurement_id',
            'stock_code',
            'grn',
            'delivery_no',
            'lpo',
            'date_added',
            'status',
            'created_by',
            'acknowledged_by',
            'acknowledged_at',
            'updated_by',
        ]);
    }
    public function mainQuery()
    {
        $services = InvDepartmentItem::search($this->search)->when($this->unitable_id && $this->unitable_type, function ($query) {
            $query->where(['unitable_id' => $this->unitable_id, 'unitable_type' => $this->unitable_type]);})
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportData = $services->pluck('id')->toArray();

        return $services;
    }

    public function render()
    {
        $data['inventory_items'] = $this->mainQuery()->with(['unitable','item','unitable'])->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        if ($this->entry_type == 'Project') {
            $data['units'] = Project::orderBy('name', 'asc')->get();
        } else {
            $data['units'] = Department::orderBy('name', 'asc')->get();
        }

        return view('livewire.inventory.stock.inv-items-stock-status-component', $data);
    }
}
