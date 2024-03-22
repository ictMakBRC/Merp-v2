<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\Performance\ExitInterview;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $employee_id;

    public $reason_for_exit;

    public $factors_for_exit;

    public $processes_procedures_systems_for_exit;

    public $can_recommend_us;

    public $experiences;

    public $improvements;

    public $reason_for_recommendation;

    public $employees;

    public function rules()
    {
        return [
            'employee_id' => 'nullable',
            'reason_for_exit' => 'required',
            'factors_for_exit' => 'nullable',
            'processes_procedures_systems_for_exit' => 'nullable',
            'can_recommend_us' => 'required',
            'experiences' => 'nullable',
            'improvements' => 'nullable',
            'reason_for_recommendation' => [Rule::requiredIf(fn () => $this-> can_recommend_us == 'no')],
        ];
    }

    public function mount()
    {
        $this->employees = User::all();
    }


    public function store()
    {
        $this->validate();

        $warning = ExitInterview::create([
                'employee_id' => auth()->user()->employee->id??50,
                'reason_for_exit' => $this->reason_for_exit,
                'factors_for_exit' => $this->factors_for_exit,
                'processes_procedures_systems_for_exit' => $this->processes_procedures_systems_for_exit,
                'can_recommend_us' => $this->can_recommend_us == 'yes' ? true : false,
                'experiences' => $this->experiences,
                'reason_for_recommendation' => $this->reason_for_recommendation
           ]);

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        $this->authorize('create', ExitInterview::class);
        return view('livewire.human-resource.performance.exit-interviews.create');
    }
}
