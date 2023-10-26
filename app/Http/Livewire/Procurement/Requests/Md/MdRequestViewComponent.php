<?php

namespace App\Http\Livewire\Procurement\Requests\Md;

use Response;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Enums\ProcurementRequestEnum;
use App\Models\Documents\FormalDocument;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestApproval;

class MdRequestViewComponent extends Component
{
    public $request_id;
    public $comment;
    public $contracts_manager_id;

    public function mount($id){
        $this->request_id=$id;
    }

    public function approveAndFowardRequest(ProcurementRequest $procurementRequest,$status)
    {
        // dd('yes');
        $this->validate([
            'comment'=>'required|string',
        ]);

        if ($status==ProcurementRequestEnum::APPROVED) {
            $this->validate([
                'contracts_manager_id'=>'required|integer',
            ]);
        }

        DB::transaction(function () use($procurementRequest,$status) {
            $procurementRequestApproval=ProcurementRequestApproval::where(['procurement_request_id'=>$procurementRequest->id,'step'=>ProcurementRequestEnum::step($procurementRequest->step_order)])->latest()->first();

            if($procurementRequest->step_order < ProcurementRequestEnum::TOTAL_STEPS){
                $procurementRequestApproval->update([
                    'approver_id' => auth()->user()->id,
                    'comment' => $this->comment,
                    'status' => $status,
                ]);
            
                if ($status!=ProcurementRequestEnum::REJECTED) {
                    $currentStepOrder = $procurementRequest->step_order;
                    $nextStepOrder = $currentStepOrder+1;

                    $procurementRequest->update([
                        'status'=>ProcurementRequestEnum::PENDING,
                        'step_order'=>$nextStepOrder,
                        'contracts_manager_id'=>$this->contracts_manager_id,
                    ]);

                    ProcurementRequestApproval::create([
                        'procurement_request_id' => $procurementRequest->id,
                        'approver_id' => null,
                        'comment' => null,
                        'status' => ProcurementRequestEnum::PENDING,
                        'step' => ProcurementRequestEnum::step($nextStepOrder),
                    ]);
                }else{
                    $procurementRequest->update([
                        'status'=>$status,
                    ]);
                }

            }else{
                $procurementRequest->update([
                    'status'=>$status,
                ]);

                $procurementRequestApproval->update([
                    'approver_id' => auth()->user()->id,
                    'comment' => $this->comment,
                    'status' => $status,
                ]);

            }
        });
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Procurement Request updated successfully']);
    }

    public function downloadDocument(FormalDocument $formalDocument)
    {
        $file = storage_path('app/').$formalDocument->document_path;
        $path_parts = pathinfo($file);
        $filename = $formalDocument->document_name.'.'.$path_parts['extension'];

        if (file_exists($file)) {
            return Response::download($file, $filename);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Document not found!',
            ]);
        }
    }

    public function resetInputs(){
        $this->reset(['comment','contracts_manager_id']);
    }

    public function render()
    {
        $data['contract_managers'] = User::where('id','!=',auth()->user()->id)->get(); 
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver','decisions','procurement_method','providers')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.md.md-request-view-component',$data);
    }
}
