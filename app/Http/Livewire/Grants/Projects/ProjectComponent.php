<?php

namespace App\Http\Livewire\Grants\Projects;

use Livewire\Component;

class ProjectComponent extends Component
{
    public $grant_code;
    public $name;
    public $project_category;
    public $project_type;
    public $grant_profile_id;
    public $funding_source;
    public $funding_amount;
    public $currency;
    public $start_date;
    public $end_date;
    public $pi;
    public $co_pi;
    public $project_summary;
    public $progress_status;

    public function storeGrantProfile(){
        
    }
    public function render()
    {
        return view('livewire.grants.projects.project-component');
    }
}
