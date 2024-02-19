<?php

namespace App\Http\Livewire\Inventory\Requests;

use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Requests\InvUnitRequest;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class InvUnitRequestsComponent extends Component
{
    public $from_date;

    public $to_date;

    public $invoiceIds;

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
    public $request_type = 'Normal';
    public $unit_type = 'department';
    public $description;
    public $unit_id = 0;
    public $unitable_type;
    public $unitable_id;
    public $unitable;
    public function mount($type)
    {
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
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
                abort(403, 'Unauthorized access or action.');
            }
        }
    }
    public function storeRequest()
    {
        $this->validate([
            'description' => 'required|string',
            'request_type' => 'required|string',
        ]);
        DB::transaction(function () {
            $p_request = new InvUnitRequest();
            $p_request->request_code = 'INV' . GeneratorService::getNumber(7);
            $p_request->comment = $this->description;
            $p_request->request_type = $this->request_type;
            $p_request->entry_type = $this->unit_type;
            $p_request->unitable()->associate($this->unitable);
            $p_request->save();
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request created successfully, please proceed!']);
            return redirect()->SignedRoute('inventory-request_items', $p_request->request_code);
        });
    }
    public function resetInputs()
    {

        $this->reset([
            'description',
            'request_type',
        ]);

    }

    public function mainQuery()
    {
        $invoices = InvUnitRequest::search($this->search)->when($this->unitable_id && $this->unitable_type, function ($query) {
            $query->where(['unitable_id' => $this->unitable_id, 'unitable_type' => $this->unitable_type]);})
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->invoiceIds = $invoices->pluck('id')->toArray();

        return $invoices;
    }
    public function render()
    {
        $data['requests'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.inventory.requests.inv-unit-requests-component', $data);
    }
}
