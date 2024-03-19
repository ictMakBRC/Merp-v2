<?php

namespace App\Http\Livewire\Grants;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Exports\Projects\GrantListExport;

class GrantsComponent extends Component
{

    use WithPagination;

    //Filters
    public $projectIds;
    public $progress_status;
    public $project_type;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $filter = false;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    
    public function filterProjects()
    {
        $projects = Project::search($this->search)->where('project_category','Grant')
        ->when($this->project_type != '', function ($query){
            $query->where('project_type',$this->project_type);
        })
        ->when($this->progress_status != '', function ($query){
            $query->where('progress_status',$this->progress_status);
        })
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            })
            ->addSelect([
                'projects.*',
                DB::raw('DATEDIFF(end_date, CURRENT_DATE()) as days_to_expire')
            ]);

        $this->projectIds = $projects->pluck('id')->toArray();

        return $projects;
    }

    public function export()
    {
        if (count($this->projectIds) > 0) {
            return (new GrantListExport($this->projectIds))->download('Grants_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'info',
                'message' => 'Oops! Not Found!',
                'text' => 'No Grants selected for export!',
            ]);
        }
    }

    public function render()
    {
        $data['projects'] = $this->filterProjects()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.grants.grants-component',$data);
    }
}
