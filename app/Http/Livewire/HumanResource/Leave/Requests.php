<?php

namespace App\Http\Livewire\HumanResource\Leave;

use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Requests extends Component
{
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $leaveIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $name;

    public $description;

    public $totalMembers;

    protected $paginationTheme = 'bootstrap';

    public $selectedLeave;

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
        if (count($this->leaveIds) > 0) {
            // return (new DesignationsExport($this->leaveIds))->download('Designations_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No leaves selected for export!',
            ]);
        }
    }

    public function filterleaves()
    {
        $leaves = LeaveRequest::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->leaveIds = $leaves->pluck('id')->toArray();

        return $leaves;
    }

    public function deleteData($leaveId)
    {
        $this->selectedLeave = $leaveId;
    }

    public function delete()
    {
        $grievance = LeaveRequest::findOrFail($this->selectedLeave);
        $grievance->delete();

        return redirect()->to(route('leaves'));
    }

    public function render()
    {
        $data['leaves'] = $this->filterleaves()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.leave.requests', $data)->layout('layouts.app');
    }
}
