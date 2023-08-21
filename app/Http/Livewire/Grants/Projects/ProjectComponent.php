<?php

namespace App\Http\Livewire\Grants\Projects;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;

class ProjectComponent extends Component
{
    use WithPagination;

    //Filters

    public $user_category;

    public $from_date;

    public $to_date;

    public $user_status;

    public $userIds;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        // $this->reset();
        $this->toggleForm = !$this->toggleForm;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    
    public function render()
    {
        $data['projects'] = Project::all();
        return view('livewire.grants.projects.project-component', $data);
    }
}
