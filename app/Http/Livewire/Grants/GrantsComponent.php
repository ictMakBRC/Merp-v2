<?php

namespace App\Http\Livewire\Grants;

use Livewire\Component;
use App\Models\Grants\Grant;
use Livewire\WithPagination;

class GrantsComponent extends Component
{

    use WithPagination;

    //Filters
    public $grant_id;
    public $grantIds;
    public $user_category;

    public $from_date;

    public $to_date;

    public $perPage = 50;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    protected $listeners = [
        'grantCreated',
    ];

    public function grantCreated($details)
    {
        $this->grant_id = $details['grantId'];
    }

    public function updatedCreateNew()
    {
        // $this->reset();
        $this->toggleForm = !$this->toggleForm;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    
    public function filterGrants()
    {
        $grants = Grant::search($this->search)->with('principalInvestigator')->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->grantIds = $grants->pluck('id')->toArray();

        return $grants;
    }

    public function render()
    {
        $data['grants'] = $this->filterGrants()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.grants.grants-component',$data);
    }
}
