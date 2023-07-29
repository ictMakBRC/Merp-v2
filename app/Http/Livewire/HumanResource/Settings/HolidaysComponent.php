<?php

namespace App\Http\Livewire\HumanResource\Settings;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HumanResource\Holiday;

class HolidaysComponent extends Component
{
   
   
    use WithPagination;

    //Filters
    public $from_date;

    public $to_date;

    public $holidayIds;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $title;

    public $is_active =1;

    public $details;

    public $totalMembers;

    public $delete_id;

    public $edit_id;

    protected $paginationTheme = 'bootstrap';

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $end_date;

    public $holiday_type;

    public $start_date;

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
            'title' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active' => 'required|numeric',
            'details' => 'required|string',
            'holiday_type' => 'required|string',
        ]);
    }

    public function storeHoliday()
    {
        $this->validate([
            'title' => 'required|string|unique:Holidays',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active' => 'required|numeric',
            'details' => 'required|string',
            'holiday_type' => 'required|string',
        ]);

        $holiday = new Holiday();
        $holiday->title = $this->title;
        $holiday->is_active = $this->is_active;
        $holiday->details = $this->details;
        $holiday->holiday_type = $this->holiday_type;
        $holiday->start_date = $this->start_date;
        $holiday->end_date = $this->end_date;
        $holiday->save();
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Holiday created successfully!']);
    }

    public function editData(Holiday $holiday)
    {
        $this->edit_id = $holiday->id;
        $this->title = $holiday->title;
        $this->is_active = $holiday->is_active;
        $this->details = $holiday->details;
        $this->start_date = $holiday->start_date;
        $this->end_date = $holiday->end_date;
        $this->holiday_type = $holiday->holiday_type;
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
        $this->reset(['title', 'details', 'start_date', 'end_date', 'holiday_type','is_active']);
    }

    public function updateHoliday()
    {
        $this->validate([
            'title' => 'required|unique:Holidays,title,'.$this->edit_id.'',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active' => 'required|numeric',
            'details' => 'required|string',
            'holiday_type' => 'required|string',
        ]);

        $holiday = Holiday::find($this->edit_id);
        $holiday->title = $this->title;
        $holiday->is_active = $this->is_active;
        $holiday->details = $this->details;
        $holiday->holiday_type = $this->holiday_type;
        $holiday->start_date = $this->start_date;
        $holiday->end_date = $this->end_date;
        $holiday->update();

        $this->resetInputs();
        $this->createNew = false;
        $this->toggleForm = false;
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Holiday updated successfully!']);
    }

    public function refresh()
    {
        return redirect(request()->header('Referer'));
    }

    public function export()
    {
        if (count($this->holidayIds) > 0) {
            // return (new HolidaysExport($this->HolidayIds))->download('Holidays_'.date('d-m-Y').'_'.now()->toTimeString().'.xlsx');
        } else {
            $this->dispatchBrowserEventBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Not Found!',
                'text' => 'No Holidays selected for export!',
            ]);
        }
    }

    public function filterHolidays()
    {
        $holidays = Holiday::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->holidayIds = $holidays->pluck('id')->toArray();

        return $holidays;
    }

    public function render()
    {
        $data['holidays'] = $this->filterHolidays()
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.human-resource.settings.holidays-component', $data)->layout('layouts.app');
    }
}
