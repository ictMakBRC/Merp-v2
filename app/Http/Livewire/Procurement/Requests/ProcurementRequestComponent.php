<?php

namespace App\Http\Livewire\Procurement\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grants\Project\Project;
use App\Models\Procurement\Request\ProcurementRequest;

class ProcurementRequestComponent extends Component
{
    use WithPagination;

    public $from_date;

    public $to_date;

    public $perPage = 10;

    public $search = '';

    public $orderBy = 'id';

    public $orderAsc = 0;

    public $createNew = false;

    public $toggleForm = false;

    public $filter = false;

    public $procurementRequestIds =[];

    public function loadRequest(ProcurementRequest $procurementRequest):void
    {
        $loadingInfo = 'For '.$procurementRequest->subject.' | '.$procurementRequest->reference_no;
            $this->emit('loadProcurementRequest', [
                'procurementRequestId' => $procurementRequest->id,
                'info'=>$loadingInfo,
            ]);

        $this->createNew = true;

        $this->toggleForm = true;
    }
 
    public function filterProcurementRequests()
    {
        $procurementRequests = ProcurementRequest::search($this->search)
            ->when($this->from_date != '' && $this->to_date != '', function ($query) {
                $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
            }, function ($query) {
                return $query;
            });

        $this->procurementRequestIds = $procurementRequests->pluck('id')->toArray();

        return $procurementRequests;
    }

    public function render()
    {
        $data['procurementRequests'] = $this->filterProcurementRequests()
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.procurement.requests.procurement-request-component',$data);
    }
}
