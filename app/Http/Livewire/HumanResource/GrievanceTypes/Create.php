<?php

namespace App\Http\Livewire\HumanResource\GrievanceTypes;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\HumanResource\GrievanceType;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;

    public $name;
    public $slug;
    public $description;

    protected $rules = [
        'name' => 'required',
        'slug' => 'required|unique:hr_grievance_types',
        'description' => 'nullable'
    ];

    /**
     * updating name
     */
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function store()
    {
        $this->authorize('create', GrievanceType::class);

        $this->validate();

        GrievanceType::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description
        ]);

        return redirect()->to(route('grievance-types'));
    }

    public function render()
    {
        $this->authorize('create', GrievanceType::class);
        return view('livewire.human-resource.grievance-types.create');
    }
}
