<?php

namespace App\Http\Livewire\HumanResource\Performance\Warnings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\Performance\Warning;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{

    use WithPagination;
    use AuthorizesRequests;

    //Filters
    public $from_date;

    public $to_date;

    public $warningIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedWarning;

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
        if (count($this->warningIds) > 0) {
            // return (new DesignationsExport($this->warningIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Warnings selected for export!',
            ]);
        }
    }

    public function filterWarnings()
    {
        $warnings = Warning::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->warningIds = $warnings->pluck('id')->toArray();

        return $warnings;
    }

    public function deleteData($warningId)
    {
        $this->selectedWarning = $warningId;
    }

    public function delete()
    {
        $grievance = Warning::findOrFail($this->selectedWarning);
        $grievance->delete();

        return redirect()->to(route('warnings'));
    }

    public function render()
    {
        // $this->authorize('viewany', Warning::class);
        $data['warnings'] = $this->filterWarnings()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.performance.warnings.index', $data)->layout('layouts.app');
    }
}
