<?php

namespace App\Http\Livewire\HumanResource\Grievances;

use App\Models\HumanResource\Grievance;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Settings\Designation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{

    use WithPagination;
    use AuthorizesRequests;

    //Filters
    public $from_date;

    public $to_date;

    public $designationIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $addressee;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedGrievance;

    public $filter = false;



    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|numeric',
            'description' => 'nullable|string',
        ]);
    }

    public function resetInputs()
    {
        $this->reset(['name', 'is_active', 'description']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->DesignationIds) > 0) {
            // return (new DesignationsExport($this->DesignationIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Designations selected for export!',
            ]);
        }
    }

    public function filterGrievances()
    {
        $designations = Grievance::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->designationIds = $designations->pluck('id')->toArray();

        return $designations;
    }

    public function deleteData($grievanceId)
    {
        $this->selectedGrievance = $grievanceId;
    }

    public function delete()
    {
        $grievance = Grievance::findOrFail($this->selectedGrievance);
        $grievance->delete();

        return redirect()->to(route('grievances'));
    }

    public function render()
    {
        $this->authorize('viewAny', Grievance::class);

        $data['grievances'] = $this->filterGrievances()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.grievances.index', $data)->layout('layouts.app');
    }
}
