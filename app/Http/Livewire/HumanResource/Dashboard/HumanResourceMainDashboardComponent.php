<?php

namespace App\Http\Livewire\HumanResource\Dashboard;

use Livewire\Component;

class HumanResourceMainDashboardComponent extends Component
{
    public $activeDashboard='';

    public function mount($dash=null){

        if ($dash){
            $this->activeDashboard=$dash;
        }else{
            $this->activeDashboard='Admin';
        }

    }

    public function render()
    {
        return view('livewire.human-resource.dashboard.human-resource-main-dashboard-component')->layout('layouts.app');
    }
}
