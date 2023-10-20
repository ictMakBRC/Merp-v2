<?php

namespace App\Http\Livewire\HumanResource\Performance\ExitInterviews;

use App\Models\HumanResource\Performance\ExitInterview;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    //Filters
    public $from_date;

    public $to_date;

    public $exitInterviewIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedExitInterview;

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
        if (count($this->exitInterviewIds) > 0) {
            // return (new DesignationsExport($this->exitInterviewIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Warnings selected for export!',
            ]);
        }
    }

    public function filterExitInterviews()
    {
        $exitInterviews = ExitInterview::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->exitInterviewIds = $exitInterviews->pluck('id')->toArray();

        return $exitInterviews;
    }

    public function deleteData($exitInterviewId)
    {
        $this->selectedExitInterview = $exitInterviewId;
    }

    public function delete()
    {
        $exitInterview = ExitInterview::findOrFail($this->selectedExitInterview);
        $exitInterview->delete();

        return redirect()->to(route('exit-interviews'));
    }

    public function render()
    {
        $this->authorize('viewAny', ExitInterview::class);
        $data['exitInterviews'] = $this->filterExitInterviews()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.human-resource.performance.exit-interviews.index', $data)->layout('layouts.app');
    }
}
