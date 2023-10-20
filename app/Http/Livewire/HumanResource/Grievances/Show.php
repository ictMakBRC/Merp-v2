<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use App\Models\HumanResource\Grievance;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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
                'acknowledged_at' => now(),
            ]);
            if ($this->additional_comment != null) {
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
        $this->authorize('view', Grievance::class);

        return view('livewire.human-resource.grievances.show');
    }
}
