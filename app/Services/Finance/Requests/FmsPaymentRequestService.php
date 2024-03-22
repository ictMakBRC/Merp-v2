<?php

namespace App\Services\Finance\Requests;

use App\Jobs\SendNotifications;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;
use App\Models\User;
use App\Services\GeneratorService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FmsPaymentRequestService
{

    public function createPaymentRequest(array $requestData)
    {

        // Validation rules

        // Common validation rules
        $rules = [
            'requestable' => 'required',
            'request_type' => 'required',
            'request_description' => 'required',
            'currency_id' => 'required|integer',
            'rate' => 'required|numeric',
            'ledger_account' => 'required|integer',
            'budget_line_id' => 'required|integer',
        ];

        // Additional rules based on request type
        if ($requestData['request_type'] === 'Salary') {
            $rules += [
                'month' => 'required|integer',
                'year' => 'required|integer',
            ];
        } elseif ($requestData['request_type'] === 'Procurement') {
            $rules += [
                'procurement_request_id' => 'required|integer',
                'net_payment_terms' => 'required',
            ];
        } elseif ($requestData['request_type'] === 'Internal Transfer') {
            $rules += [
                'to_department_id' => 'required|integer',
                'to_project_id' => 'required|integer',
                'to_budget_line_id' => 'required|integer',
                'to_account' => 'required|integer',
                'invoice_id' => 'nullable|integer',
            ];
        }

        // Run the validation
        $validator = Validator::make($requestData, $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // Handle validation errors (throw exception, log, etc.)
            // throw new \Exception($validator->errors()->first());
            return $validator->errors()->first();
        }

        $total_amount = (float) str_replace(',', '', $requestData['total_amount'] ?? 0);
        $paymentRequest = new FmsPaymentRequest();
        $paymentRequest->request_code = 'PRE' . GeneratorService::getNumber(7);
        $paymentRequest->request_description = $requestData['request_description'];
        $paymentRequest->request_type = $requestData['request_type'];
        $paymentRequest->total_amount = $total_amount ?? 0;
        $paymentRequest->ledger_amount = $requestData['ledgerExpense'] ?? 0;
        $paymentRequest->budget_amount = $requestData['budgetExpense'] ?? 0;
        $paymentRequest->amount_in_words = $requestData['amount_in_words'] ?? 'NA';
        $paymentRequest->rate = $requestData['rate'];
        $paymentRequest->currency_id = $requestData['currency_id'];
        $paymentRequest->notice_text = $requestData['notice_text'] ?? null;
        $paymentRequest->department_id = $requestData['department_id'];
        $paymentRequest->project_id = $requestData['project_id'];
        $paymentRequest->budget_line_id = $requestData['budget_line_id'];
        $paymentRequest->ledger_account = $requestData['ledger_account'];
        if ($requestData['request_type'] === 'Salary') {
            $paymentRequest->month = $requestData['month'];
            $paymentRequest->year = $requestData['year'];
        }if ($requestData['request_type'] === 'Procurement') {
            $paymentRequest->procurement_request_id = $requestData['procurement_request_id'];
            $paymentRequest->net_payment_terms = $requestData['net_payment_terms'];
        }if ($requestData['request_type'] === 'Internal Transfer') {
            $paymentRequest->to_department_id = $requestData['to_department_id'] ?? null;
            $paymentRequest->to_project_id = $requestData['to_project_id'] ?? null;
            $paymentRequest->to_budget_line_id = $requestData['to_budget_line_id'] ?? null;
            $paymentRequest->to_account = $requestData['to_account'] ?? null;
            $paymentRequest->invoice_id = $requestData['invoice_id'] ?? null;
        }
        $paymentRequest->requestable()->associate($requestData['requestable']);
        $paymentRequest->save();

        if ($paymentRequest->request_type == 'Salary') {
            return redirect()->SignedRoute('finance-payroll_unit_details', $paymentRequest->request_code);
        } else {
            return redirect()->SignedRoute('finance-request_detail', $paymentRequest->request_code);
        }
        // return $paymentRequest;
    }

    public static function submitRequest($id)
    {
        DB::transaction(function () use ($id) {
            $requestData = FmsPaymentRequest::where(['id' => $id])->with('currency')->first();
            $reqCur = $requestData->currency_id;
            $totalAmt = $requestData->total_amount;
            $baseAmount = getCurrencyRate($reqCur, 'base', $totalAmt);
            $ledgerExpense = 0;
            $budgetExpense = 0;
            $dataBudget = FmsBudgetLine::Where('id', $requestData->budget_line_id)->with('budget', 'budget.currency')->first();
            // if ($dataBudget) {
            $budgetLineCur = $dataBudget->budget->currency_id ?? null;
            $budgetExpense = getCurrencyRate($budgetLineCur, 'foreign', $baseAmount);
            $budgetAmountHeld = $dataBudget->amount_held;
            $newBudgetAmountHeld = $budgetAmountHeld + $budgetExpense;
            $dataBudget->amount_held = $newBudgetAmountHeld;
            $dataBudget->update();
            // }

            $dataLeger = FmsLedgerAccount::Where('id', $requestData->ledger_account)->with('currency')->first();

            // if ($dataLeger) {
            $ledgerCur = $dataLeger->currency_id ?? null;
            $ledgerExpense = getCurrencyRate($ledgerCur, 'foreign', $baseAmount);
            $currentAmountHeld = $dataLeger->amount_held;
            $newAmountHeld = $currentAmountHeld + $ledgerExpense;
            $dataLeger->amount_held = $newAmountHeld;
            $dataLeger->update();
            // }
                
            $requestData->requester_signature = 'SN_' . GeneratorService::getNumber(8);
            $requestData->ledger_amount = $ledgerExpense;
            $requestData->budget_amount = $budgetExpense;
            $requestData->status = 'Submitted';
            $requestData->date_submitted = date('Y-m-d');
            // dd($requestData);
            $signatory = FmsPaymentRequestAuthorization::Where(['request_code' => $requestData->request_code, 'request_id' => $id, 'status' => 'Pending'])->with(['approver'])
                ->orderBy('level', 'asc')->first();
            if (!$signatory) {
                return 'Please add all signatories';
            }
            $signatory->update(['status' => 'Active']);
            $requestData->update();
            if ($signatory) {
                $body = 'Hello, You have a pending request #' . $requestData->request_code . ' to sign, please login to view more details';
                self::SendMail($signatory->approver_id, $body, $requestData);
            }
            return redirect()->SignedRoute('finance-request_preview', $requestData->request_code);
            return $requestData;
        });
    }

    public static function SendMail($id, $body, $requestData)
    {
        try {
            $user = User::where('id', $id)->first();
            $link = URL::signedRoute('finance-request_preview', $requestData->request_code);
            $notification = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'MERP ' . $requestData->request_type . ' payment Request',
                'greeting' => 'Dear ' . $user->title . ' ' . $user->name,
                'body' => $body,
                'thanks' => 'Thank you, incase of any question, please reply to support@makbrc.org',
                'actionText' => 'View Details',
                'actionURL' => $link,
                'department_id' => $requestData->created_by,
                'user_id' => $requestData->created_by,
            ];
            // WhatAppMessageService::sendReferralMessage($referral_request);
            $mm = SendNotifications::dispatch($notification)->delay(Carbon::now()->addSeconds(20));
            //   dd($mms);
        } catch (Throwable $error) {
            // $this->dispatchBrowserEvent('alert', ['type' => 'success',  'message' => 'Referral Request '.$error.'!']);
        }
    }

}
