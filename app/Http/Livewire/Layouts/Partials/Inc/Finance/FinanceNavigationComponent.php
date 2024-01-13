<?php

namespace App\Http\Livewire\Layouts\Partials\Inc\Finance;

use Livewire\Component;

class FinanceNavigationComponent extends Component
{
    public $unit_type ='department';
    public $unit_id=0;
    public function mount(){
        if (session()->has('unit_type') && session()->has('unit_id')) {
            $this->unit_id = session('unit_id');
            $this->unit_type = session('unit_type');
        }else{
            $this->unit_id = auth()->user()->employee->department_id??0;
            $this->unit_type = 'department';
        }
    }
    public function checkOut(){
        // if (session()->has('unit')) {
            session()->forget('unit');
            session()->forget('unit_type');
            session()->forget('unit_id');
            return to_route('finance-project_list');
        // }
    }
    public function render()
    {
        return view('livewire.layouts.partials.inc.finance.finance-navigation-component');
    }
}
