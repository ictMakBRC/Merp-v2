<?php

namespace App\Http\Livewire\HumanResource\Dashboard;

use Livewire\Component;

class HumanResourceMainDashboardComponent extends Component
{
    public function render()
    {
        return view('livewire.human-resource.dashboard.human-resource-main-dashboard-component')->layout('layouts.human-resource');
    }
}
