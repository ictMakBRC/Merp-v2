<?php

namespace App\Http\Livewire\HumanResource\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Leave;

class LeavesComponent extends Component
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

    public $is_active = 1;

    public $duration;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    public  $notice_days, $details, $payment_type;
    public $given_to, $is_payable, $carriable;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public function updatedCreateNew()
    {
        $this->resetInputs();
        $this->toggleForm = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updated($fields)
    {
        $this->validateOnly($fields, [
            'name' => 'required|string',
            'is_active' => 'required|numeric',
            'duration' => 'nullable|numeric',
            'is_payable' => 'required|string',
            'carriable' => 'required|string',
            'given_to' => 'required|string',
            'details' => 'nullable|integer',
            'notice_days' => 'required|integer',
            'payment_type' => 'required|string',
        ]);
    }

    public function storeLeave()
    {
        $this->validate([
            'name' => 'required|string|unique:leaves',
            'is_active' => 'required|numeric',
            'duration' => 'nullable|numeric',
            'is_payable' => 'required|string',
            'carriable' => 'required|string',
            'given_to' => 'required|string',
            'details' => 'nullable|integer',
            'notice_days' => 'required|integer',
            'payment_type' => 'required|string',

        ]);

        $leave = new Leave();
        $leave->name = $this->name;
        $leave->is_active = $this->is_active;
        $leave->duration = $this->duration;
        $leave->is_payable = $this->is_payable;
        $leave->carriable = $this->carriable;
        $leave->given_to = $this->given_to;
        $leave->details = $this->details;
        $leave->notice_days = $this->notice_days;
        $leave->payment_type = $this->payment_type;
        $leave->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['is_payable' => 'success',  'message' => 'Leave created successfully!']);
    }
    
    public function editData(Leave $leave)
    {
        $this->edit_id = $leave->id;
        $this->name = $leave->name;
        $this->is_active = $leave->is_active;
        $this->duration = $leave->duration;
        $this->is_payable = $leave->is_payable;
        $this->carriable = $leave->carriable;
        $this->given_to = $leave->given_to;
        $this->details = $leave->details;
        $this->notice_days = $leave->notice_days;
        $this->payment_type = $leave->payment_type;
        $this->createNew = true;
        $this->toggleForm = true;
    }

    public function close()
    {
        $this->createNew = false;
        $this->toggleForm = false;
        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->reset(['name', 'duration', 'carriable', 'is_payable', 'payment_type', 'given_to', 'notice_days', 'details', 'is_active']);
    }

    public function updateLeave()
    {
        $this->validate([
            'name' => 'required|unique:Leaves,name,'.$this->edit_id.'',
            'is_active' => 'required|numeric',
            'duration' => 'nullable|numeric',
            'is_payable' => 'required|string',
            'carriable' => 'required|string',
            'given_to' => 'required|string',
            'details' => 'nullable|integer',
            'notice_days' => 'required|integer',
            'payment_type' => 'required|string',
        ]);

        $leave = Leave::find($this->edit_id);
        $leave->name = $this->name;
        $leave->is_active = $this->is_active;
        $leave->duration = $this->duration;
        $leave->is_payable = $this->is_payable;
        $leave->carriable = $this->carriable;
        $leave->given_to = $this->given_to;
        $leave->details = $this->details;
        $leave->notice_days = $this->notice_days;
        $leave->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['is_payable' => 'success',  'message' => 'Leave updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->leaveIds) > 0) {
            // return (new LeavesExport($this->leaveIds))->download('Leaves_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'is_payable' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Leaves selected for export!',
            ]);
        }
    }

    public function filterLeaves()
    {
        $leaves = Leave::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->leaveIds = $leaves->pluck('id')->toArray();

        return $leaves;
    }

    public function render()
    {
        $data['leaves'] = $this->filterLeaves()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.admin.leaves-component',$data)->layout('layouts.app');
    }
}
