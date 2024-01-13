<?php

namespace App\Http\Livewire\Procurement\Requests\Supervisor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\HumanResource\Settings\Department;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Procurement\Request\ProcurementRequest;

class SupervisorPanelComponent extends Component
{
    use WithPagination;

    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'status';

    public $orderAsc = 0;

    public $filter = false;

    public $procurementRequestIds =[];
    
    public function filterProcurementRequests()
    {
        $user = auth()->user(); // Assuming you are using Laravel's default authentication

        $procurementRequests = ProcurementRequest::whereHasMorph(
            'requestable',
            [Department::class, Project::class],
            function (Builder $query, string $type) {
                $column = $type === Department::class ? 'supervisor' : 'pi';
         
                $query->where($column, auth()->user()->employee->id);

                $column2 = $type === Department::class ? 'asst_supervisor' : 'co_pi';
                $query->orWhere($column2, auth()->user()->employee->id);
            }
        )->where('step_order','>=',2)
        ->when($this->from_date != '' && $this->to_date != '', function ($query) {
            $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }, function ($query) {
            return $query;
        });

        // $procurementRequests = ProcurementRequest::where(function ($query) use ($user) {
        //     // Check if the logged-in user is the supervisor or assistant supervisor of the department
        //     $query->whereHas('requestable.departments', function ($query) use ($user) {
        //         $query->where('supervisor', $user->employee->id)
        //             ->orWhere('asst_supervisor', $user->employee->id);
        //     });

        //     // Check if the logged-in user is the principal investigator or co-investigator of a project
        //     $query->orWhereHas('requestable', function ($query) use ($user) {
        //         $query->where('pi', $user->employee->id)
        //             ->orWhere('co_pi', $user->employee->id);
        //     });

        //     // Check if the logged-in user is the requester of the procurement request
        //     // $query->orWhere('created_by', $user->id);
        // }) ->where('step_order','>=',2)
        // ->when($this->from_date != '' && $this->to_date != '', function ($query) {
        //     $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
        // }, function ($query) {
        //     return $query;
        // });

        $this->procurementRequestIds = $procurementRequests->pluck('id')->toArray();

        return $procurementRequests;
    }

    public function render()
    {
        $data['procurementRequests'] = $this->filterProcurementRequests()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.procurement.requests.supervisor.supervisor-panel-component',$data);
    }
}
