<?php

use Illuminate\Support\Facades\Route;
use App\Models\Finance\Requests\FmsPaymentRequest;
use App\Http\Livewire\Finance\Banking\FmsBanksComponent;
use App\Http\Livewire\Finance\Income\FmsIncomeComponent;
use App\Http\Livewire\Finance\Budget\FmsBudgetsComponent;
use App\Http\Livewire\Finance\Lists\FmsProjectsComponent;
use App\Http\Controllers\Finance\FinanceGeneralController;
use App\Http\Livewire\Finace\Payroll\FmsViewPayrollComponent;
use App\Http\Livewire\Finance\Expense\FmsExpenseComponent;
use App\Http\Livewire\Finance\Settings\CustomersComponent;
use App\Http\Livewire\Finance\Banking\FmsViewBankComponent;
use App\Http\Livewire\Finance\Payroll\FmsPayrollsComponent;
use App\Http\Livewire\Finance\Budget\FmsMainBudgetComponent;
use App\Http\Livewire\Finance\Budget\FmsViewBudgetComponent;
use App\Http\Livewire\Finance\Ledger\FmsViewLedgerComponent;
use App\Http\Livewire\Finance\Lists\FmsDepartmentsComponent;
use App\Http\Livewire\Finance\Settings\FmsCurrencyComponent;
use App\Http\Livewire\Finance\Settings\FmsServicesComponent;
use App\Http\Livewire\Finance\Budget\FmsBudgetLinesComponent;
use App\Http\Livewire\Finance\Transfers\FmsTransferComponent;
use App\Http\Livewire\Finance\Invoice\FmsViewInvoiceComponent;
use App\Http\Livewire\Finance\Invoice\FmsInvoiceItemsComponent;
use App\Http\Livewire\Finance\Invoice\FmsInvoiceListsComponent;
use App\Http\Livewire\Finance\Ledger\FmsGeneralLedgerComponent;
use App\Http\Livewire\Finance\Budget\FmsMainBudgetListComponent;
use App\Http\Livewire\Finance\Ledger\FmsLedgerAccountsComponent;
use App\Http\Livewire\Finance\Settings\FmsUnitServicesComponent;
use App\Http\Livewire\Finance\Accounting\ChartOfAccountsComponent;
use App\Http\Livewire\Finance\Dashboard\FmsUnitDashboardComponent;
use App\Http\Livewire\Finance\Invoice\FmsIncomingInvoiceComponent;
use App\Http\Livewire\Finance\Invoice\FmsOutGoingInvoiceComponent;
use App\Http\Livewire\Finance\Payroll\FmsGeneratePayrollComponent;
use App\Http\Livewire\Finance\Payroll\FmsPayrollRequestsComponent;
use App\Http\Livewire\Finance\Payroll\FmsPayrollScheduleComponent;
use App\Http\Livewire\Finance\Requests\FmsPaymentPreviewComponent;
use App\Http\Livewire\Finance\Settings\FmsFinancialYearsComponent;
use App\Http\Livewire\Finance\Requests\FmsPaymentRequestsComponent;
use App\Http\Livewire\Finance\Settings\FmsCurrencyUpdatesComponent;
use App\Http\Livewire\Finance\Transactions\FmsTransactionsComponent;
use App\Http\Livewire\Finance\Dashboard\FmsDirectorDasboardComponent;
use App\Http\Livewire\Finance\Requests\FmsInternalTransfersComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsTypesComponent;
use App\Http\Livewire\Finance\Settings\FmsServiceCategoriesComponent;
use App\Http\Livewire\Finance\Dashboard\FinanceMainDashboardComponent;
use App\Http\Livewire\Finance\Budget\FmsDepartmentBudgetLinesComponent;
use App\Http\Livewire\Finance\Customer\FmsDebtorReportComponent;
use App\Http\Livewire\Finance\Customer\FmsViewCustomerLedgerComponent;
use App\Http\Livewire\Finance\Settings\FmsFinanceInstitutionsComponent;
use App\Http\Livewire\Finance\Payroll\FmsPayrollRequestDetailsComponent;
use App\Http\Livewire\Finance\Settings\ChartOfAccountsSubTypesComponent;
use App\Http\Livewire\Finance\Requests\FmsPaymentRequestDetailsComponent;
use App\Http\Livewire\Finance\Requests\FmsPaymentRequestSettingComponent;
use App\Http\Livewire\Finance\Requests\Internal\FmsInternalTransferRequestsComponent;

Route::group(['prefix' => 'finance'], function () {
    Route::get('dashboard', FinanceMainDashboardComponent::class)->name('finance-dashboard');
    Route::get('dashboard/analytics', FmsDirectorDasboardComponent::class)->name('finance-md_dashboard');
    Route::get('dashboard/unit/{id}/{type}', FmsUnitDashboardComponent::class)->name('finance-dashboard_unit');

    Route::group(['prefix' => 'accounting'], function () {
        Route::get('chart-of-accounts', ChartOfAccountsComponent::class)->name('finance-chart_of_accounts');
       
        Route::get('budgets/{type}', FmsBudgetsComponent::class)->name('finance-budgets');
        Route::get('budgets/main/list', FmsMainBudgetListComponent::class)->name('finance-main_budget');
        Route::get('budgets/main/{year}', FmsMainBudgetComponent::class)->name('finance-main_budget_view');
        Route::get('budgets/lines/{budget}', FmsBudgetLinesComponent::class)->name('finance-budget_lines');
        Route::get('budgets/view/{budget}', FmsViewBudgetComponent::class)->name('finance-budget_view');
        Route::get('invoices', FmsInvoiceListsComponent::class)->name('finance-invoices');
        Route::get('invoices/incoming', FmsIncomingInvoiceComponent::class)->name('finance-invoices_in');
        Route::get('invoices/outgoing', FmsOutGoingInvoiceComponent::class)->name('finance-invoices_out');
        Route::get('invoice/items/{inv_no}', FmsInvoiceItemsComponent::class)->name('finance-invoice_items');
        Route::get('invoice/view/{inv_no}', FmsViewInvoiceComponent::class)->name('finance-invoice_view');
        
        
    });
    Route::group(['prefix' => 'ledger'], function () {
        Route::get('accounts/{type}', FmsLedgerAccountsComponent::class)->name('finance-ledger_accounts');
        Route::get('account/{id}', FmsViewLedgerComponent::class)->name('finance-ledger_view');
        Route::get('bank/account/{id}', FmsViewBankComponent::class)->name('finance-bank_view');
        Route::get('customer/account/{id}', FmsViewCustomerLedgerComponent::class)->name('finance-customer_view');
        Route::get('general', FmsGeneralLedgerComponent::class)->name('finance-general_ledger');
    });
    Route::group(['prefix' => 'transactions'], function () {
        Route::get('all/{type}', FmsTransactionsComponent::class)->name('finance-transactions');
        Route::get('expenses/{type}', FmsExpenseComponent::class)->name('finance-expenses');
        Route::get('income/{type}', FmsIncomeComponent::class)->name('finance-revenues');    
    });
    Route::group(['prefix' => 'requests'], function () {
        Route::get('list/{type}', FmsPaymentRequestsComponent::class)->name('finance-requests');
        Route::get('details/{code}', FmsPaymentRequestDetailsComponent::class)->name('finance-request_detail');
        Route::get('preview/{code}', FmsPaymentPreviewComponent::class)->name('finance-request_preview');
        Route::get('internal/{type}', FmsInternalTransferRequestsComponent::class)->name('finance-requests_internal');
        Route::get('internal/details/{code}', FmsInternalTransferRequestsComponent::class)->name('finance-request_detail_internal');
        Route::get('internal/preview/{code}', FmsPaymentPreviewComponent::class)->name('finance-request_preview_internal');
    });
    Route::group(['prefix' => 'settings'], function () {
        Route::get('chart-of-accounts/types', ChartOfAccountsTypesComponent::class)->name('finance-chart_of_account_types');
        Route::get('chart-of-accounts/subtypes', ChartOfAccountsSubTypesComponent::class)->name('finance-chart_of_account_sub_types');
        Route::get('customers', CustomersComponent::class)->name('finance-customers');
        Route::get('debtors', FmsDebtorReportComponent::class)->name('finance-aging');
        Route::get('currencies', FmsCurrencyComponent::class)->name('finance-currencies');
        Route::get('currencies/rates', FmsCurrencyUpdatesComponent::class)->name('finance-currency_rates');
        Route::get('categories', FmsServiceCategoriesComponent::class)->name('finance-categories');
        Route::get('services', FmsServicesComponent::class)->name('finance-services');
        Route::get('unit/services', FmsUnitServicesComponent::class)->name('finance-unit_services');
        Route::get('years', FmsFinancialYearsComponent::class)->name('finance-years');
        Route::get('positions', FmsPaymentRequestSettingComponent::class)->name('finance-req_settings');
        Route::get('banks', FmsBanksComponent::class)->name('finance-banks');
        Route::get('institutions', FmsFinanceInstitutionsComponent::class)->name('finance-institutions');
    });
    Route::group(['prefix' => 'lists'], function () {
        Route::get('departments', FmsDepartmentsComponent::class)->name('finance-department_list');
        Route::get('unit/lines', FmsDepartmentBudgetLinesComponent::class)->name('finance-unit_lines');
        Route::get('projects', FmsProjectsComponent::class)->name('finance-project_list');
        
    });
    Route::group(['prefix' => 'payroll'], function () {
        Route::get('requests/{type}', FmsPayrollRequestsComponent::class)->name('finance-payroll_unit_list');
        Route::get('payroll/{code}/employees', FmsPayrollRequestDetailsComponent::class)->name('finance-payroll_unit_details');
        Route::get('payroll/{code}/view', FmsViewPayrollComponent::class)->name('finance-payroll_view');
        Route::get('list', FmsPayrollsComponent::class)->name('finance-payroll_list');
        Route::get('create/{voucher}/add', FmsPayrollScheduleComponent::class)->name('finance-payroll_data');
        Route::get('generate/{voucher}/add', FmsGeneratePayrollComponent::class)->name('finance-payroll_generate');
        Route::get('payslip/{payroll_id}/download', [FinanceGeneralController::class, 'downloadPayslip'])->name('finance-pay_slip');
        Route::get('payslip/{payroll_id}/generate', [FinanceGeneralController::class, 'generatePayslip'])->name('finance-gen_pay_slip');
        
    });
});
