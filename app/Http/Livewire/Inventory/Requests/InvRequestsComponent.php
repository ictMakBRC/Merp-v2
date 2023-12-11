<?php

namespace App\Http\Livewire\Inventory\Requests;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Services\GeneratorService;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use App\Models\inventory\Requisitions\invRequest;

class InvRequestsComponent extends Component
{
    use WithPagination;
    public $from_date;

    public $to_date;

    public $serviceIds;

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
    public $request_type = 'Internal';
    public $unit_type = 'department';
    public $unit_id = 0;
    public $unitable_type;
    public $unitable_id;
    public $unitable;
    public $project_id;
    public $department_id;    
    public $request_code, $approver_id;
    public $active ='requests', $inv_request_id, $comment;

    public function mount()
    {
        $this->request_code = GeneratorService::requestCode();
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->unitable = $unitable = Project::find($this->unit_id);
                $this->project_id = $unitable->id??null;
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->unitable = $unitable = Department::find($this->unit_id);
                $this->department_id = $unitable->id??null;
            }
            if ($unitable) {
                $this->unitable_type = get_class($unitable);
                $this->unitable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        
    }

    public function storeRequest()
    {
        
        $this->validate([
            'unitable' => 'required',
            'request_code' => 'required',
            'approver_id' => 'required',
            'request_type'=>'required',
        ]);
        $request = new invRequest();
        $request->request_code = $this->request_code??GeneratorService::requestCode();
        $request->user_id = auth()->user()->id;
        $request->reqcomment = $this->comment;
        $request->approver_id = $this->approver_id;
        $request->request_type = $this->request_type;
        if($this->request_type == 'Internal'){
            $request->loantable()->associate($this->unitable);
        }
        $request->unitable()->associate($this->unitable);
        $request->save();        
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Request created successfully, please proceed']);
        return to_route('inventory-request_items', $request->request_code);
    }

    public function close(){
        $this->resetInputs();
    }
    public function resetInputs()
    {
        $this->reset([
            'approver_id',
            'comment',
        ]);
    }


    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
       $this->request_code= GeneratorService::requestCode();
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mainQuery()
    {
        $services = invRequest::search($this->search)->where(['unitable_id'=> $this->unitable_id,'unitable_type' => $this->unitable_type])
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->serviceIds = $services->pluck('id')->toArray();

        return $services;
    }

    public function render()
    {
        if($this->unit_type == 'department'){
            $data['signatories'] = User::where('is_active', 1)->where('employee_id', $this->unitable?->supervisor)->orWhere('employee_id', $this->unitable?->asst_supervisor)->get();
        }else{
            $data['signatories'] = User::where('is_active', 1)->with('employee')->where('employee_id', $this->unitable?->pi)->orWhere('employee_id', $this->unitable?->co_pi)->get();
        }
        $data['requests'] = $this->mainQuery()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.inventory.requests.inv-requests-component', $data);
    }
}
