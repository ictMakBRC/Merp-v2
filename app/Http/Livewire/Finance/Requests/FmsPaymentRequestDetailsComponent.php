<?php

namespace App\Http\Livewire\Finance\Requests;

use Throwable;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Jobs\SendNotifications;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Grants\Project\EmployeeProject;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Requests\FmsRequestEmployee;
use App\Models\HumanResource\EmployeeData\Employee;
use App\Models\Finance\Requests\FmsPaymentRequestDetail;
use App\Models\Finance\Requests\FmsPaymentRequestPosition;
use App\Services\Finance\Requests\FmsPaymentRequestService;
use App\Models\Finance\Requests\FmsPaymentRequestAttachment;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;
use App\Models\HumanResource\EmployeeData\OfficialContract\OfficialContract;

class FmsPaymentRequestDetailsComponent extends Component
{
    use WithFileUploads;
    public $requestCode;
    public $requestData;
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
    public $currency;

    public $name;
    public $reference;
    public $file;
    public $disk = 'Finance';
    public $iteration;

    public $position;
    public $approver_id;
    public $position_exists = false;
    public $requestable_type;

    public $employee_id;
    public $currency_id;
    public $month;
    public $year;
    public $entry = 'Department';

    public $signatory_level;

    public $confirmingDelete = false;
    public $itemToRemove;
    public $totalAmount = 0;
    public function updatedUnitCost()
    {
        $this->updatedQuantity();
    }
    public function updatedQuantity()
    {
        if ($this->quantity != "" && $this->unit_cost != '') {
            $this->amount = $this->unit_cost * $this->quantity;

        }
    }
    public function mount($code)
    {
        $this->requestCode = $code;
        $this->month = now()->format('m');
        $this->year = now()->format('Y');

    }
    public function saveExpense($id)
    {
        $this->validate([
            'expenditure' => 'required',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric',
            'unit_cost' => 'required|numeric',
            'amount' => 'required|numeric',
        ]);
        if ($this->amount > $this->amountRemaining) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Low Line balance!',
                'text' => 'You don not have enough money on your request line, your expense is ' . $this->amount . ' but your available balance is ' . $this->amountRemaining,
            ]);
            return false;

        }
        $amount = $this->quantity * $this->unit_cost;
        $requestItem = new FmsPaymentRequestDetail();
        $requestItem->request_id = $id;
        $requestItem->request_code = $this->requestCode;
        $requestItem->expenditure = $this->expenditure;
        $requestItem->quantity = $this->quantity;
        $requestItem->unit_cost = $this->unit_cost;
        $requestItem->amount = $amount;
        $requestItem->description = $this->description;
        $requestItem->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item created successfully!']);
    }
    public function saveEmployee($id)
    {
        $this->validate([
            'employee_id' => 'required',
            'month' => 'required',
            'year' => 'required',
            'amount' => 'required|numeric',
        ]);
        $record = FmsRequestEmployee::where(['employee_id' => $this->employee_id, 'month' => $this->month,
            'year' => $this->year, 'requestable_type' => $this->requestData->requestable_type, 'requestable_id' => $this->requestData->requestable_id])->first();
        if ($record) {

            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'warning',
                'message' => 'Oops! Payment already exists!',
                'text' => 'Moths already paid or in queue',
            ]);
            return false;

        }
        $requestEmployee = new FmsRequestEmployee();
        $requestEmployee->request_id = $id;
        $requestEmployee->request_code = $this->requestCode;
        $requestEmployee->employee_id = $this->employee_id;
        $requestEmployee->month = $this->month;
        $requestEmployee->year = $this->year;
        $requestEmployee->currency_id = $this->requestData->currency_id;
        $requestEmployee->amount = $this->amount;
        $requestEmployee->requestable_type = $this->requestData->requestable_type;
        $requestEmployee->requestable_id = $this->requestData->requestable_id;
        $requestEmployee->save();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item created successfully!']);
    }
    public function saveAttachment($id)
    {
        $this->validate([
            'name' => 'required',
            'reference' => 'required|string',
            'file' => 'nullable|mimes:jpg,pdf,docx|max:10240|file|min:10', // 10MB Max
        ]);
        if ($this->file != null) {
            $name = date('Ymdhis') . '_' . $this->requestCode . '.' . $this->file->extension();
            $path = date('Y') . '/' . date('M') . '/Payments/Requests/Attachments';
            $file = $this->file->storeAs($path, $name, $this->disk);
        } else {
            $file = null;
        }
        $requestItem = new FmsPaymentRequestAttachment();
        $requestItem->request_id = $id;
        $requestItem->request_code = $this->requestCode;
        $requestItem->name = $this->name;
        $requestItem->reference = $this->reference;
        $requestItem->file = $file;
        $requestItem->save();
        $this->iteration = rand();
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment added successfully!']);
    }
    public function addSignatory($id)
    {
        $this->validate([
            'position' => 'required',
            'signatory_level' => 'required|integer',
            'approver_id' => 'required|integer',
        ]);
        $exists = FmsPaymentRequestAuthorization::where(['position' => $this->position, 'request_id' => $id])->first();
        // dd($exists);
        if ($exists) {
            $this->position_exists = true;
            $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => 'Signatory already exists on this particular document, please select another different person']);
            return false;
        }
        $requestAuth = new FmsPaymentRequestAuthorization();
        $requestAuth->request_id = $id;
        $requestAuth->request_code = $this->requestCode;
        $requestAuth->position = $this->position;
        $requestAuth->level = $this->signatory_level;
        $requestAuth->approver_id = $this->approver_id;
        $requestAuth->save();
        if ($this->requestData->request_type != 'Petty Cash') {
            $positions = FmsPaymentRequestPosition::where('name_lock', '!=', 'head')
                ->when($this->requestable_type == 'App\Models\HumanResource\Settings\Department', function ($query) {
                    $query->where('name_lock', '!=', 'grants');})
                ->when($this->requestData->request_type == 'Internal Transfer', function ($query) {
                    $query->where('name_lock', '!=', 'operations');})->get();
            foreach ($positions as $position) {
                $exists = FmsPaymentRequestAuthorization::where(['position' => $position->id, 'request_id' => $id])->first();
                if (!$exists) {
                    $requestAuth = new FmsPaymentRequestAuthorization();
                    $requestAuth->request_id = $id;
                    $requestAuth->request_code = $this->requestCode;
                    $requestAuth->position = $position->id;
                    $requestAuth->level = $position->level;
                    $requestAuth->approver_id = $position->assigned_to;
                    $requestAuth->save();
                }
            }
        }
        $this->resetInputs();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment added successfully!']);
    }
    public function resetInputs()
    {
        $this->reset([
            'expenditure',
            'quantity',
            'unit_cost',
            'amount',
            'description',
            'name',
            'reference',
            'position',
            'signatory_level',
            'approver_id',
            'employee_id',
        ]);
        $this->position_exists = false;
    }
    public function downloadAttachment(FmsPaymentRequestAttachment $attachment)
    {

        $file = $attachment->file;

        // Check if the file exists
        if (Storage::disk($this->disk)->exists($file)) {
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
    public function deleteFile($attachment)
    {
        $file = FmsPaymentRequestAttachment::where('id', $attachment)->first();
        if ($file) {
            if ($file->file != null) {
                Storage::disk($this->disk)->delete($file->file);
            }
            $file->delete();
            $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request attachment deleted successfully!']);
        } else {
            $this->dispatchBrowserEvent('swal:modal', [
                'type' => 'error',
                'message' => 'Not Found!',
                'text' => 'Attachment not found!',
            ]);
        }
    }
    public function confirmDelete($itemId)
    {
        $this->confirmingDelete = true;
        $this->itemToRemove = $itemId;
    }

    public function submitRequest($id)
    {
        $request = FmsPaymentRequest::where(['request_code' => $this->requestCode, 'id' => $id])->first();
        $submit = FmsPaymentRequestService::submitRequest($request->id);
        return $submit;
        // DB::transaction(function () use ($id) {
        //     $request = FmsPaymentRequest::where(['request_code' => $this->requestCode, 'id' => $id])->first();
        //     $dataBudget = FmsBudgetLine::where('id', $request->budget_line_id)->with('budget', 'budget.currency')->first();
        //     // if ($dataBudget) {
        //         $budgetAmountHeld = $dataBudget->amount_held;
        //         $newBudgetAmountHeld = $budgetAmountHeld + $request->budget_amount;
        //         $dataBudget->amount_held = $newBudgetAmountHeld;
        //         $dataBudget->update();
        //     // }

        //     $dataLeger = FmsLedgerAccount::where('id', $request->ledger_account)->with('currency')->first();              

        //     // if ($dataLeger) {
        //         $currentAmountHeld = $dataLeger->amount_held;
        //         $newAmountHeld = $currentAmountHeld + $request->ledger_amount;
        //         $dataLeger->amount_held = $newAmountHeld;
        //         $dataLeger->update();
        //     // }
        //     $request->update(['status' => 'Submitted', 'date_submitted' => date('Y-m-d')]);
        //     $signatory = FmsPaymentRequestAuthorization::where(['request_code' => $this->requestCode, 'request_id' => $id, 'status' => 'Pending'])->with(['approver'])
        //         ->orderBy('level', 'asc')->first();
        //     //    dd($signatory);
        //     $signatory->update(['status' => 'Active']);
        //     if ($signatory) {
        //         $body = 'Hello, You have a pending request #' . $this->requestCode . ' to sign, please login to view more details';
        //         $this->SendMail($signatory->approver_id, $body);
        //     }
        //     $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Request submitted successfully!']);
        //     return redirect()->SignedRoute('finance-request_preview', $this->requestCode);
        // });
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
        $this->dispatchBrowserEvent('alert', ['type' => 'Success', 'message' => 'Your request has been successfully sent! ']);
    }

    public function deleteRecord()
    {

        FmsPaymentRequestDetail::find($this->itemToRemove)->delete();
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'request item deleted successfully!']);
        $this->confirmingDelete = false;
        $this->itemToRemove = null;
    }
    public $selectedEmployee = null;
    public function updatedEmployeeId()
    {
        if ($this->employee_id) {
            $this->selectedEmployee = null;
            if ($this->entry == 'Project') {
                $this->selectedEmployee = EmployeeProject::where(['project_id' => $this->requestData->requestable_id, 'employee_id' => $this->employee_id])->with('employee')->first();
                $this->amount = $this->selectedEmployee->gross_salary ?? 0;
            } elseif ($this->entry == 'Department') {
                $this->selectedEmployee = OfficialContract::where('employee_id', $this->employee_id)->with('employee')->first();
                $this->amount = $this->selectedEmployee->gross_salary ?? 0;
            }
        }
    }
    public function render()
    {
        $data['request_data'] = $requestData = FmsPaymentRequest::where('request_code', $this->requestCode)->with(['department', 'project', 'toDepartment', 'toProject', 'currency', 'requestable', 'budgetLine','procurementRequest'])->first();
        if ($requestData) {
            $this->requestData = $requestData;
            $this->requestable_type = $requestData->requestable_type;
            $this->currency = $requestData->currency->code ?? 'UG';
            $data['items'] = FmsPaymentRequestDetail::where('request_id', $data['request_data']->id)->get();
            $data['attachments'] = FmsPaymentRequestAttachment::where('request_id', $data['request_data']->id)->get();
            $data['authorizations'] = FmsPaymentRequestAuthorization::where('request_id', $data['request_data']->id)->with(['authPosition', 'user', 'approver'])->get();
            // if ($requestData->request_type == 'Salary') {
                $data['req_employees'] = FmsRequestEmployee::where('request_id', $data['request_data']->id)->with('employee')->get();
                if ($requestData->requestable_type == 'App\Models\HumanResource\Settings\Department') {
                    $this->entry = 'Department';
                    $data['employees'] = Employee::where('department_id', $requestData->requestable_id)->get();
                    $data['signatories'] = User::where('is_active', 1)->where('employee_id', $requestData->requestable?->supervisor)->orWhere('employee_id', $requestData->requestable?->asst_supervisor)->get();
                } elseif ($requestData->requestable_type == 'App\Models\Grants\Project\Project') {
                    $data['employees'] = EmployeeProject::where('project_id', $requestData->requestable_id)->with('employee')->get();
                    $this->entry = 'Project';
                    $data['signatories'] = User::where('is_active', 1)->with('employee')->where('employee_id', $requestData->requestable?->pi)->orWhere('employee_id', $requestData->requestable?->co_pi)->get();
                } else {
                    $data['employees'] = collect([]);
                }
            // } else {
            //     $data['req_employees'] = collect([]);
            //     $data['employees'] = collect([]);
            // }
        } else {
            $data['items'] = collect([]);
            $data['attachments'] = collect([]);
            $data['authorizations'] = collect([]);
            $data['employees'] = collect([]);
            $data['req_employees'] = collect([]);
        }
        $data['positions'] = FmsPaymentRequestPosition::where('name_lock', 'head')
            ->when($requestData?->requestable_type == 'App\Models\HumanResource\Settings\Department', function ($query) {
                $query->where('name_lock', '!=', 'grants');
            })->get();
        $level = FmsPaymentRequestAuthorization::where('request_id', $data['request_data']?->id)->orderBy('id', 'DESC')->first();
        if ($level) {
            $this->signatory_level = $level->level + 1;
        } else {
            $this->signatory_level = 1;
        }
        $this->totalAmount = $data['items']->sum('amount');
        $this->amountRemaining = $requestData->total_amount - $this->totalAmount;

        return view('livewire.finance.requests.fms-payment-request-details-component', $data);
    }
}
