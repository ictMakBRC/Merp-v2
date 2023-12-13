<?php

namespace App\Http\Livewire\Finance\Requests;

use App\Models\Finance\Requests\FmsPaymentRequestPosition;
use App\Models\User;
use Livewire\Component;

class FmsPaymentRequestSettingComponent extends Component
{
        public $name;
        public $assigned_to;
        public $is_active;
        public $createNew = true;
        public $toggleForm = true;
        public $edit_id;
    public function editData(FmsPaymentRequestPosition $position)
    {
        $this->edit_id = $position->id;
        $this->name = $position->name;
        $this->assigned_to = $position->assigned_to;
        $this->is_active = $position->is_active;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active','assigned_to']);
    }

    public function updateFmsPosition()
    {
        $this->validate([
            'name' => 'required|unique:fms_currencies,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'assigned_to' => 'required|integer',
        ]);

        $position = FmsPaymentRequestPosition::find($this->edit_id);
        $position->assigned_to = $this->assigned_to;
        $position->is_active = $this->is_active;
        $position->update();
        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'position updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }
    public function render()
    {
        $data['users'] = User::where('is_active', 1)->with(['employee'])->get();
        $data['positions'] = FmsPaymentRequestPosition::where('is_active', 1)->with(['assignedTo'])->get();
        return view('livewire.finance.requests.fms-payment-request-setting-component', $data);
    }
}
