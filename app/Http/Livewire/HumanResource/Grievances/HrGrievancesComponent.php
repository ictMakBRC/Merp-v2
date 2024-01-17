<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\GrievanceType;
use App\Models\HumanResource\Settings\Department;

class HrGrievancesComponent extends Component
{
    use WithPagination;
    //Filters
    public $from_date;

    public $to_date;

    public $grievanceIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;
    public $exportIds;
    public $is_active = 1;
    protected $paginationTheme = 'bootstrap';

    public $edit_id;

    public $delete_id;
    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $comment;
    public $g_comment;
    public $file_upload;
    public $employee_id;
    public $grievance_type_id;
    public $subject;
    public $department_id;
    public $acknowledged_by_comment;
    public $addressee;
    public $status;
    public $unit_id;
    public $unit_type;
    public $requestable;
    public $requestable_type, $requestable_id;
    public function mount($type){
        $this->employee_id = auth()->user()->employee_id;
        if ($type =='all' && auth()->user()->hasPermission(['view_grievances'])) {
            $this->department_id = null;
            $this->unit_type = 'all';
        }elseif($type == 'unit'){
            $this->department_id = auth()->user()->employee->department_id??0;
            $this->unit_type = 'department';
            $this->requestable = $requestable = Department::where('supervisor',$this->employee_id)->first();
            if ($requestable) {
                $this->requestable_type = get_class($this->requestable);
                $this->requestable_id = $this->unit_id;
            }else{
                abort(403, 'Unauthorized access or action.'); 
            }
        }else{
            abort(403, 'Unauthorized access or action.'); 
        }
        
     
    }
    public function showGrievance(Grievance $grievance)
    {
        $this->edit_id = $grievance->id;
        $this->status = $grievance->status;
        $this->subject = $grievance->subject;
        $this->comment = $grievance->comment;
        $this->acknowledged_by_comment = $grievance->acknowledged_by_comment;
        $this->grievance_type_id = $grievance->grievance_type_id;
        $this->addressee = $grievance->addressee;
    }

    public function markGrievance($id){
        $this->validate([
            'acknowledged_by_comment' => 'required|string',
        ]);
        $grievance = Grievance::find($id);
        $grievance->status = 'Seen';
        $grievance->acknowledged_by_comment = $this->acknowledged_by_comment;
        $grievance->acknowledged_by = auth()->user()->id;
        $grievance->acknowledged_at = date('Y-m-d H:i:s');
        $grievance->update();
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Record marked seen successfully!']);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function close()
    {
        $this->resetInputs();
    }


    public function resetInputs()
    {
        $this->reset([
            'grievance_type_id',
            'subject',
            'addressee',
            'comment',
            'g_comment',
            'edit_id']);
    }

    public function mainQuery()
    {
        $grievances = Grievance::search($this->search)->when($this->unit_type && $this->department_id, function ($query) {
            $query->where(['department_id'=> $this->department_id])->whereIn('addressee',['Department','Both']);
        })->when($this->unit_type=='all', function ($query) {$query->whereIn('addressee',['Administration','Both']);})
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exportIds = $grievances->pluck('id')->toArray();

        return $grievances;
    }

    public function render()
    {
        $data['grievances'] = $this->mainQuery()->where('status','!=','pending')->with(['employee', 'comments','department','type','acknowledgedBy'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        $data['types'] = GrievanceType::all();
        return view('livewire.human-resource.grievances.hr-grievances-component', $data);
    }
}
