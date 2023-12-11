<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Settings\ProcurementMethod;

class ProcurementMethodComponent extends Component
{
    use WithPagination;
    public $method;
    public $description;
    
    public $createNew = false;
    public $toggleForm = false;

    public $procurementMethod;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function storeProcurementMethod(){
        
        $this->validate([
            'method' => 'required|string|unique:procurement_methods',
            'description' => 'nullable|string',
        ]);

        $method = ProcurementMethod::create([
            'method' => $this->method,
            'description' => $this->description,

            ]
        );

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement method created successfully']);

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
    }

    public function editData(ProcurementMethod $procurementMethod)
    {
        $this->procurementMethod = $procurementMethod;

        $this->method = $procurementMethod->method;
        $this->description = $procurementMethod->description;
        
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateProcurementMethod()
    {
        $this->validate([
            'method' => 'required|string|unique:procurement_methods,method,'. $this->procurementMethod->id,
            'description' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () {
 
                $this->procurementMethod->update([
                    'method' => $this->method,
                    'description' => $this->description,
        
                    ]
                );

                $this->resetInputs();
                $this->createNew = false;
                $this->toggleForm = false;
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Method updated successfully,']);
            });
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Operation Failed!',
                'text' => 'Something went wrong and the operation could not be completed. Please try again',
            ]);
        }
    }

    public function resetInputs(){
        $this->reset([
            'method',
            'description',
        ]);
    }


    public function render()
    {
        $data['procurementMethods'] = ProcurementMethod::all();
        return view('livewire.procurement.settings.procurement-method-component',$data);
    }
}
