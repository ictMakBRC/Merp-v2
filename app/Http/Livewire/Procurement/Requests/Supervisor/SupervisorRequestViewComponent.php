<?php

namespace App\Http\Livewire\Procurement\Requests\Supervisor;

use Response;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Enums\ProcurementRequestEnum;
use App\Models\Documents\FormalDocument;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestApproval;

class SupervisorRequestViewComponent extends Component
{
    public $request_id;
    public $comment;

    public function mount($id){
        $this->request_id=$id;
    }

    public function forwardToSupervisor(ProcurementRequest $procurementRequest)
    {
        if ($procurementRequest->step_order==1) {
            
            $this->validate([
                'comment'=>'required|string',
            ]);

            DB::transaction(function () use($procurementRequest) {
                $nextStepOrder = $procurementRequest->step_order+1;
                
                $procurementRequest->update([
                    'status'=>ProcurementRequestEnum::PENDING,
                    'step_order'=>$nextStepOrder,
                ]);

                ProcurementRequestApproval::create([
                    'procurement_request_id' => $procurementRequest->id,
                    'approver_id' => auth()->user()->id,
                    'comment' => $this->comment,
                    'status' => ProcurementRequestEnum::SUBMITTED,
                    'step' => ProcurementRequestEnum::step($nextStepOrder-1),
                ]);

                ProcurementRequestApproval::create([
                    'procurement_request_id' => $procurementRequest->id,
                    'approver_id' => null,
                    'comment' => null,
                    'status' => ProcurementRequestEnum::PENDING,
                    'step' => ProcurementRequestEnum::step($nextStepOrder),
                ]);
            });

        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Operation failed!',
                'text' => 'This operation can no be performed!',
            ]);
        }
      
        // Notify the next approver (e.g., the supervisor)
    }


    public function approveAndFowardRequest(ProcurementRequest $procurementRequest,$status)
    {
        // dd('yes');
        $this->validate([
            'comment'=>'required|string',
        ]);
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
       
    }

    public function processBidDocs(ProcurementRequest $procurementRequest){
        $procurementRequest->update(['status'=>'Bid Docs Processing']);
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

    public function render()
    {
        $data['request'] = ProcurementRequest::with('items','documents','requester','approvals','approvals.approver')->findOrFail($this->request_id);
        return view('livewire.procurement.requests.supervisor.supervisor-request-view-component',$data);
    }
}
