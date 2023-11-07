<?php

namespace App\Http\Livewire\Finance\Requests;

use App\Jobs\SendNotifications;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsPaymentRequestAttachment;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;
use App\Models\Finance\Requests\FmsPaymentRequestDetail;
use App\Models\Finance\Transactions\FmsTransaction;
use App\Models\User;
use App\Services\GeneratorService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class FmsPaymentPreviewComponent extends Component
{
    use WithFileUploads;
    public $request_id;
    public $request_code;
    public $expenditure;
    public $quantity = 1;
    public $unit_cost = 1;
    public $amount;
    public $amountRemaining;
    public $description;
    public $created_by;
    public $updated_by;

    public $name;
    public $reference;
    public $file;
    public $disk = 'Finance';
    public $iteration;

    public $position;
    public $approver_id;
    public $position_exists = false;

    public $signatory_level;

    public $confirmingDelete = false;
    public $itemToRemove;
    public $totalAmount = 0;
    public $currency;
    public $requestData;
    public $requestCode;
    public $comment;
    public $click_action;
    public function mount($code)
    {
        $this->requestCode = $code;

    }
    public function payRequest($id)
    {

        try {
            DB::transaction(function () use ($id) {
                $requestData = FmsPaymentRequest::where(['request_code' => $this->requestCode, 'id' => $id, 'status' => 'Approved'])->first();

                if ($requestData) {

                    $trans = new FmsTransaction();
                    $trans->trx_no = 'TRE' . GeneratorService::getNumber(7);
                    $trans->trx_ref = $requestData->request_code ?? 'TRF' . GeneratorService::getNumber(7);;
                    $trans->trx_date = date('Y-m-d');
                    $trans->total_amount = $requestData->total_amount;
                    $trans->from_account = $requestData->from_account;
                    $trans->rate = $requestData->rate;
                    $trans->department_id = $requestData->department_id;
                    $trans->project_id = $requestData->project_id;
                    $trans->budget_line_id = $requestData->budget_line_id;
                    $trans->currency_id = $requestData->currency_id;
                    $trans->trx_type = 'Expense';
                    $trans->status = 'Approved';
                    $trans->entry_type = 'Internal';
                    if ($requestData->project_id != null) {
                        $trans->is_department = false;
                    }                    
                    $trans->requestable_type = $requestData->requestable_type;
                    $trans->requestable_id = $requestData->requestable_id;
                    $trans->save();
                    if ($requestData->request_type == 'Internal Transfer') {
                        $incomeTrans = new FmsTransaction();
                        $incomeTrans->trx_no = 'TRI' . GeneratorService::getNumber(7);
                        $incomeTrans->trx_ref = $requestData->request_code ?? 'TRF' . GeneratorService::getNumber(7);;
                        $incomeTrans->trx_date = date('Y-m-d');
                        $incomeTrans->total_amount = $requestData->total_amount;
                        $incomeTrans->to_account = $requestData->to_account;
                        $incomeTrans->rate = $requestData->rate;
                        $incomeTrans->department_id = $requestData->to_department_id;
                        $incomeTrans->project_id = $requestData->to_project_id;
                        $incomeTrans->budget_line_id = $requestData->to_budget_line_id;
                        $incomeTrans->currency_id = $requestData->currency_id;
                        $incomeTrans->trx_type = 'Income';
                        $incomeTrans->status = 'Approved';
                        $incomeTrans->entry_type = 'Internal';
                        if ($requestData->to_project_id != null) {
                            $incomeTrans->is_department = false;
                        }
                        $incomeTrans->requestable_type = $requestData->requestable_type;
                        $incomeTrans->requestable_id = $requestData->requestable_id;
                        $incomeTrans->save();
                        $baseAmount = $requestData->total_amount * $requestData->rate;
                        $creditAccount = FmsLedgerAccount::where('id',$requestData->to_account)->with('currency')->first(); 
                        $cur = $creditAccount->currency->code??'';                      
                        $income = exchangeCurrency($cur, 'foreign', $baseAmount);
                        $creditAccount->current_balance += $income;
                        $creditAccount->save();
                    }
                    // FmsLedgerAccount::where('id', $this->from_account)->update(['current_balance' => DB::raw('current_balance - '.$this->ledgerExpense)]);

                    $ledgerAccount = FmsLedgerAccount::find($requestData->from_account);
                    $ledgerAccount->current_balance -= $requestData->ledger_amount;
                    $ledgerAccount->amount_held -= $requestData->ledger_amount;
                    $ledgerAccount->save();

                    // FmsBudgetLine::where('id', $this->budget_line_id)->update(['primary_balance' => DB::raw('primary_balance - '.$this->budgetExpense)]);

                    $budget = FmsBudgetLine::find($requestData->budget_line_id);
                    $budget->primary_balance -= $requestData->budget_amount;
                    $budget->amount_held -= $requestData->budget_amount;
                    $budget->save();

                    $requestData->status = 'Completed';
                    $requestData->date_paid = date('Y-m-d');
                    $requestData->update();
                    $body = 'Hello, Your request #' . $this->requestCode . ' has been paid, please login to view more details and comments';
                    $this->SendMail($requestData->created_by, $body);

                    $this->dispatchBrowserEvent('close-modal');
                    $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Transaction created successfully!']);
                }});
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! NOT YOUR TURN',
                'text' => 'You do not have permission to authorize this request now ' . $e->getMessage(),
            ]);
            // $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Transfer failed!' . $e->getMessage()]);

        }
    }
    public function downloadAttachment(FmsPaymentRequestAttachment $attachment)
    {

        $file = $attachment->file;

        // Check if the file exists
        if ($file && Storage::disk($this->disk)->exists($file)) {
            return Storage::disk($this->disk)->download($file, $attachment->request_code . '_Attachment');
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment successfully downloaded!']);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        }

    }

    public function close()
    {

    }

    public function approveRejectRequest($id)
    {
        if ($this->click_action == 'Signed') {
            $this->validate([
                'comment' => 'nullable|string',
            ]);
            DB::transaction(function () use ($id) {
                $signed = FmsPaymentRequestAuthorization::Where(['request_id' => $id, 'approver_id' => auth()->user()->id, 'status' => 'Active'])->first();
                // dd($signed);
                if ($signed) {

                    $signed->status = 'Signed';
                    $signed->signature = generateInitials(auth()->user()->employee->empName ?? auth()->user()->name) . '_' . GeneratorService::getNumber(8);
                    $signed->signature_date = date('Y-m-d');
                    $signed->update();
                    $signatory = FmsPaymentRequestAuthorization::Where(['request_id' => $id, 'status' => 'Pending'])
                        ->orderBy('level', 'asc')->first();
                    if ($signatory) {
                        $signatory->update(['status' => 'Active']);
                        $body = 'Hello, You have a pending request #' . $this->requestCode . ' to sign, please login to view more details';
                        $this->SendMail($signatory->approver_id, $body);
                    }
                    $pendingSignatory = FmsPaymentRequestAuthorization::where(['request_id' => $id])->where('status', '!=', 'Signed')->first();
                    // dd($pendinSignatory);
                    if ($pendingSignatory == null) {
                        $this->markRequestApproved();
                    }

                } else {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Oops! NOT YOUR TURN',
                        'text' => 'You do not have permission to authorize this request now',
                    ]);
                }
            });
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Request approved successfully! ']);
        } elseif ($this->click_action == 'Declined') {
            $this->validate([
                'comment' => 'required|string',
            ]);
            DB::transaction(function () use ($id) {
                $signed = FmsPaymentRequestAuthorization::Where(['request_id' => $id, 'approver_id' => auth()->user()->id, 'status' => 'Active'])->first();
                // dd($signed);
                if ($signed) {

                    $signed->status = 'Declined';
                    $signed->signature = 'SN_' . GeneratorService::getNumber(8);
                    $signed->signature_date = date('Y-m-d');
                    $signed->update();
                    $data = FmsPaymentRequest::where('request_code', $this->requestCode)->first();
                    $data->status = 'Declined';
                    $data->date_approved = date('Y-m-d');
                    $data->update();
                    $body = 'Hello, Your request #' . $this->requestCode . ' has been declined, please login to view more details and comments';
                    $this->SendMail($signed->created_by, $body);

                } else {
                    $this->dispatchBrowserEvent('swal:modal', [
                        'type' => 'warning',
                        'message' => 'Oops! NOT YOUR TURN',
                        'text' => 'You do not have permission to authorize this request now',
                    ]);
                }
            });
            $this->dispatchBrowserEvent('close-modal');
            $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Request decline successfully! ']);

        }

    }

    public function markRequestApproved()
    {
        $data = FmsPaymentRequest::where('request_code', $this->requestCode)->with(['fromAccount', 'budgetLine'])->first();
        $data->status = 'Approved';
        $data->date_approved = date('Y-m-d');
        $data->update();
        $body = 'Hello, Your request #' . $this->requestCode . ' has been approved, please login to view more details';
        $this->SendMail($data->created_by, $body);
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Document request has been successfully marked complete! ']);
    }

    public function SendMail($id, $body)
    {
        try {
            $user = User::where('id', $id)->first();
            $link = URL::signedRoute('finance-request_preview', $this->requestCode);
            $notification = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'MERP payment Request',
                'greeting' => 'Dear ' . $user->title . ' ' . $user->name,
                'body' => $body,
                'thanks' => 'Thank you, incase of any question, please reply to support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => $link,
                'department_id' => $this->requestData->created_by,
                'user_id' => $this->requestData->created_by,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
            $mm = SendNotifications::dispatch($notification)->delay(Carbon::now()->addSeconds(20));
            //   dd($mms);
        } catch (Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Document has been successfully marked complete! ']);
    }

    public function render()
    {
        $data['request_data'] = $requestData = FmsPaymentRequest::where('request_code', $this->requestCode)->with(['department', 'project', 'currency', 'requestable', 'budgetLine', 'fromAccount'])->first();
        if ($requestData) {
            $this->requestData = $requestData;
            $this->currency = $requestData->currency->code ?? 'UG';
            $data['items'] = FmsPaymentRequestDetail::where('request_id', $data['request_data']->id)->get();
            $data['attachments'] = FmsPaymentRequestAttachment::where('request_id', $data['request_data']->id)->get();
            $data['authorizations'] = FmsPaymentRequestAuthorization::where('request_id', $data['request_data']->id)->with(['authPosition', 'user', 'approver'])->orderBy('level', 'ASC')->get();
        } else {
            $data['items'] = collect([]);
            $data['attachments'] = collect([]);
            $data['authorizations'] = collect([]);
        }
        $this->totalAmount = $data['items']->sum('amount');
        return view('livewire.finance.requests.fms-payment-preview-component', $data);
    }
}
