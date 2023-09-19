<?php

namespace App\Http\Livewire\HumanResource\Performance\Appraisals;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Grievance;
use App\Models\HumanResource\Performance\Appraisal;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Index extends Component
{

    use WithPagination;
    use AuthorizesRequests;

    //Filters
    public $from_date;

    public $to_date;

    public $appraisalIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedApraisal;

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
        if (count($this->appraisalIds) > 0) {
            // return (new DesignationsExport($this->appraisalIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Appraisals selected for export!',
            ]);
        }
    }

    public function filterAppraisals()
    {
        $appraisals = Appraisal::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->appraisalIds = $appraisals->pluck('id')->toArray();

        return $appraisals;
    }

    public function deleteData($appraisalId)
    {
        $this->selectedApraisal = $appraisalId;
    }

    public function delete()
    {
        $grievance = Appraisal::findOrFail($this->selectedApraisal);
        $grievance->delete();

        return redirect()->to(route('appraisals'));
    }

    public function render()
    {
        // $this->authorize('viewany', Appraisal::class);
        $data['appraisals'] = $this->filterAppraisals()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.performance.appraisals.index', $data)->layout('layouts.app');
    }
}
