<?php

namespace App\Http\Livewire\HumanResource\Performance\Resignations;

use App\Models\HumanResource\Performance\Resignation;
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

    public $resignationIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedResignation;

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
        if (count($this->resignationIds) > 0) {
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Resignations selected for export!',
            ]);
        }
    }

    public function filterResignations()
    {
        $resignations = Resignation::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->resignationIds = $resignations->pluck('id')->toArray();

        return $resignations;
    }

    public function deleteData($resignationId)
    {
        $this->selectedResignation = $resignationId;
    }

    public function delete()
    {
        $resignation = Resignation::findOrFail($this->selectedResignation);
        $resignation->delete();

        return redirect()->to(route('resignations'));
    }

    public function render()
    {
        $this->authorize('viewAny', Resignation::class);
        $data['resignations'] = $this->filterResignations()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.human-resource.performance.resignations.index', $data)->layout('layouts.app');
    }
}
