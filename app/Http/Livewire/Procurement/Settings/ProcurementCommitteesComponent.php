<?php

namespace App\Http\Livewire\Procurement\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Settings\ProcurementCommittee;

class ProcurementCommitteesComponent extends Component
{
    use WithPagination;
    public $committee;
    public $name;
    public $email;
    public $contact;
    public $is_active;
    
    public $createNew = false;
    public $toggleForm = false;

    public $procurementCommittee;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function storeCommitteeMember(){
        

        $this->validate([
            'committee' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email:filter',
            'contact' => 'required|string',
            'is_active' => 'required|integer',
        ]);

        if(ProcurementCommittee::where(['email'=>$this->email,'committee'=>$this->committee])->first()){
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Oops! Operation Failed!',
                'text' => 'A member with this email, already exists on the specified committee',
            ]);
            return;
        }

        $member = ProcurementCommittee::create([
            'committee' => $this->committee,
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact,
            'is_active' => $this->is_active,

            ]
        );

        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Committee member created successfully']);

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
    }

    public function editData(ProcurementCommittee $procurementCommittee)
    {
        $this->procurementCommittee = $procurementCommittee;

        $this->committee = $procurementCommittee->committee;
        $this->name = $procurementCommittee->name;
        $this->email = $procurementCommittee->email;
        $this->contact = $procurementCommittee->contact;
        $this->is_active = $procurementCommittee->is_active;
        
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function updateCommitteeMember()
    {
        $this->validate([
            'committee' => 'required|string',
            'name' => 'required|string',
            'email' => 'required||email:filter',
            'contact' => 'required|string',
            'is_active' => 'required|integer',
        ]);

        try {
            DB::transaction(function () {
 
                $this->procurementCommittee->update([
                    'committee' => $this->committee,
                    'name' => $this->name,
                    'email' => $this->email,
                    'contact' => $this->contact,
                    'is_active' => $this->is_active,
        
                    ]
                );

                $this->resetInputs();
                $this->createNew = false;
                $this->toggleForm = false;
                $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Committee member updated successfully,']);
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
            'committee',
            'name',
            'email',
            'contact',
            'is_active',
        ]);
    }


    public function render()
    {
        $data['procurementCommittees'] = ProcurementCommittee::all();
        return view('livewire.procurement.settings.procurement-committees-component',$data);
    }
}
