<?php

namespace App\Services\Finance\Requests;

use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendNotifications;
use App\Services\GeneratorService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Models\Finance\Budget\FmsBudgetLine;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Models\Finance\Accounting\FmsLedgerAccount;
use App\Models\Finance\Requests\FmsPaymentRequestAuthorization;

class FmsPaymentRequestService
{

    public function createPaymentRequest($requestData)
    {

        $total_amount = (float) str_replace(',', '', $requestData['total_amount']);
        $paymentRequest = new FmsPaymentRequest();
        $paymentRequest->request_code = 'PRE' . GeneratorService::getNumber(7);
        $paymentRequest->request_description = $requestData['request_description'];
        $paymentRequest->request_type = $requestData['request_type'];
        $paymentRequest->total_amount = $total_amount;
        $paymentRequest->ledger_amount = $requestData['ledgerExpense'];
        $paymentRequest->budget_amount = $requestData['budgetExpense'];
        $paymentRequest->amount_in_words = $requestData['amount_in_words'] ?? null;
        $paymentRequest->rate = $requestData['rate'];
        $paymentRequest->currency_id = $requestData['currency_id'];
        $paymentRequest->notice_text = $requestData['notice_text'];
        $paymentRequest->department_id = $requestData['department_id'];
        $paymentRequest->project_id = $requestData['project_id'];
        $paymentRequest->budget_line_id = $requestData['budget_line_id'];
        $paymentRequest->ledger_account = $requestData['ledger_account'];
        if ($requestData['request_type'] === 'Salary') {
            $paymentRequest->month = $requestData['month'];
            $paymentRequest->year = $requestData['year'];
        }if ($requestData['request_type'] === 'Procurement') {
            $paymentRequest->month = $requestData['procurement_request_id'];
            $paymentRequest->year = $requestData['payment_method'];
        }if ($requestData['request_type'] === 'Internal Transfer') {
            $paymentRequest->to_department_id = $requestData['to_department_id'];
            $paymentRequest->to_project_id = $requestData['to_project_id'];
            $paymentRequest->to_budget_line_id = $requestData['to_budget_line_id'];
            $paymentRequest->to_account = $requestData['to_account'];
            $paymentRequest->invoice_id = $requestData['invoice_id'];
        }

        $paymentRequest->requestable()->associate($requestData['requestable']);
        $paymentRequest->save();
        // $paymentRequest = FmsPaymentRequest::create($requestData);

        // Additional logic based on request type
        // if ($requestData['request_type'] === 'salary') {
        // Handle salary-specific logic
        // $paymentRequest->salarySpecificField = $requestData['salary_specific_field'];
        // } elseif ($requestData['request_type'] === 'procurement') {
        // Handle procurement-specific logic
        // $paymentRequest->procurementSpecificField = $requestData['procurement_specific_field'];
        // }

        // Save the model
        // $paymentRequest->save();

        return $paymentRequest;
    }

    public function submitRequest($id)
    {
        DB::transaction(function () use ($id) {
            $requestData = FmsPaymentRequest::where(['id' => $id])->first();
            $dataBudget = FmsBudgetLine::Where('id', $requestData->budget_line_id)->with('budget', 'budget.currency')->first();
            // if ($dataBudget) {
                $budgetAmountHeld = $dataBudget->amount_held;
                $newBudgetAmountHeld = $budgetAmountHeld + $requestData->budget_amount;
                $dataBudget->amount_held = $newBudgetAmountHeld;
                $dataBudget->update();
            // }

            $dataLeger = FmsLedgerAccount::Where('id', $requestData->ledger_account)->with('currency')->first();              

            // if ($dataLeger) {
                $currentAmountHeld = $dataLeger->amount_held;
                $newAmountHeld = $currentAmountHeld + $requestData->ledger_amount;
                $dataLeger->amount_held = $newAmountHeld;
                $dataLeger->update();
            // }
            $requestData->update(['status' => 'Submitted', 'date_submitted' => date('Y-m-d')]);
            $signatory = FmsPaymentRequestAuthorization::Where(['request_code' => $requestData->request_code, 'request_id' => $id, 'status' => 'Pending'])->with(['approver'])
                ->orderBy('level', 'asc')->first();
            //    dd($signatory);
            $signatory->update(['status' => 'Active']);
            if ($signatory) {
                $body = 'Hello, You have a pending request #' . $requestData->request_code . ' to sign, please login to view more details';
                $this->SendMail($signatory->approver_id, $body, $requestData);
            }
            return redirect()->SignedRoute('finance-request_preview', $requestData->request_code);
            return $requestData;
        });
    }

    public function SendMail($id, $body, $requestData)
    {
        try {
            $user = User::where('id', $id)->first();
            $link = URL::signedRoute('finance-request_preview', $requestData->request_code);
            $notification = [
                'to' => $user->email,
                'phone' => $user->contact,
                'subject' => 'MERP '.$requestData->request_type.' payment Request',
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
