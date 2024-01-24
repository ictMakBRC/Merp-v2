<?php

namespace App\Http\Livewire\Inventory\Stock;

use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Stock\InvStockLog;
use App\Services\GeneratorService;
use Livewire\Component;
use Livewire\WithPagination;

class InvStockHistoryComponent extends Component
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

    public function mount($type)
    {
        $this->todayDate = date('Y-m-d');
        $this->date_added = date('Y-m-d');
    }
    public function storeData()
    {

        $unitable = null;
        $check = null;
        if ($this->entry_type == 'Project') {
            $unitable = Project::find($this->unit_id);

        } elseif ($this->entry_type == 'Department') {
            $unitable = Department::find($this->unit_id);
        }

        $this->validate([
            'unit_id' => 'required',
            'date_added' => 'required',
        ]);

        $dept_item = new InvStockLog();
        $dept_item->date_added = $this->date_added;
        $dept_item->stock_code = 'STK' . GeneratorService::getNumber(7);
        $dept_item->entry_type = $this->entry_type;
        $dept_item->unitable()->associate($unitable);
        $dept_item->save();

        $this->close();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Department Item successfully added!']);
        return redirect()->signedRoute('inventory-stock_doc_items',$dept_item->stock_code);
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
        $services = InvStockLog::search($this->search)->when($this->unitable_id && $this->unitable_type, function ($query) {
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
        $data['stock_docs'] = $this->mainQuery()->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->with('createdBy','unitable')->paginate($this->perPage);
        if ($this->entry_type == 'Project') {
            $data['units'] = Project::orderBy('name', 'asc')->get();
        } else {
            $data['units'] = Department::orderBy('name', 'asc')->get();
        }

        return view('livewire.inventory.stock.inv-stock-history-component', $data);
    }
}
