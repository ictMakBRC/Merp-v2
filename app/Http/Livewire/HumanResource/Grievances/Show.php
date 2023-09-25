<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Models\HumanResource\Grievance;

class Show extends Component
{
    public $grievance;




    public function mount(Grievance $grievance)
    {
        $this->grievance = $grievance;
    }

    public function store()
    {
        $this->validate();

        return DB::transaction(function () {
            $this->grievance->update([
                'acknowledged_at' => now()
            ]);
            if($this->additional_comment != null) {
                $this->grievance->comments()->create([
                    'content' => $this->additional_comment,
                    'user_id' => auth()->id(),
                ]);
            }

            $this->grievance->fresh();

            return redirect()->back();
        });
    }


    public function render()
    {
        return view('livewire.human-resource.grievances.show');
    }
}
