<?php

namespace App\Http\Livewire\Procurement\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Procurement\Settings\Provider;
use App\Models\Finance\Settings\FmsFinancialYear;
use App\Models\Procurement\Request\ProcurementRequest;
use App\Models\Procurement\Request\ProcurementRequestApproval;

class ProcurementMainDashboardComponent extends Component
{
    public function grantsAndProjectsPerYear(){

        $distinctYearsProjects = DB::table('projects')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

        // Eloquent query to get distinct years from grants
        $distinctYearsGrants = DB::table('grants')
        ->select(DB::raw('YEAR(created_at) as year'))
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

        // Combine distinct years from both projects and grants
        $distinctYears = array_unique(array_merge($distinctYearsProjects, $distinctYearsGrants));

        // Limit the distinct years to the last ten years
        $lastTenYears = array_slice($distinctYears, 0, 10);

        // Eloquent query to get the number of projects per year
        $projectsPerYear = DB::table('projects')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as projects_count'))
            ->whereIn(DB::raw('YEAR(created_at)'), $lastTenYears)
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->get()
            ->keyBy('year');

        // Eloquent query to get the number of grants per year
        $grantsPerYear = DB::table('grants')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('count(*) as grants_count'))
            ->whereIn(DB::raw('YEAR(created_at)'), $lastTenYears)
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at)'))
            ->get()
            ->keyBy('year');

        // Prepare data for Apex line chart
        $chartData = [];

        foreach ($lastTenYears as $year) {
            $chartData[$year] = [
                'grants_count' => isset($grantsPerYear[$year]) ? max(0, $grantsPerYear[$year]->grants_count) : 0,
                'projects_count' => isset($projectsPerYear[$year]) ? max(0, $projectsPerYear[$year]->projects_count) : 0,
            ];
        }

        return $chartData;
    }

    public function getData(){

        $procurementRequests=ProcurementRequest::get();
        
        $data['totalRequests']= $procurementRequests->count();
        $data['totalRequestsCompleted']= $procurementRequests->whereNotNull('delivered_at')->count();

        $data['providersCount'] = Provider::where('is_active', true)->count();

        $data['totalExpenditure']= round($procurementRequests->whereNotNull('delivered_at')->sum(function ($request) {
            return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
        })/1000000,2);

        $data['avgTat']= ProcurementRequest::whereNotNull('delivered_at')->avg(DB::raw('DATEDIFF(delivered_at, created_at)'))??'N/A';

        $data['lateDelivery']= ProcurementRequest::whereColumn('delivered_at','>','delivery_deadline')->count();
        $data['countLateDelivery']=$data['lateDelivery']/($data['totalRequestsCompleted']>0?$data['totalRequestsCompleted']:1)*100;

        $data['countsPerYear'] = FmsFinancialYear::with('procurement_requests')
        ->get()
        ->map(function ($year) {
            return [
                'year' => $year->name.'('.$year->procurement_requests->count().')',
                'count' => $year->procurement_requests->count(),
                'contract_total' => round($year->procurement_requests->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        });

        $data['steps'] = ProcurementRequest::select('step_order', DB::raw('count(*) as count'))
        ->groupBy('step_order')
        ->orderBy('step_order','asc')
        ->get();

        $data['countsPerCategorization'] = ProcurementRequest::withWhereHas('procurement_categorization')
        ->get()
        ->groupBy('procurement_categorization.method')
        ->map(function ($group) {
            return [
                'name' => $group->first()->procurement_categorization->categorization,
                'count' => $group->count(),
                'contract_total' => round($group->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        })
        ->sortByDesc('count')
        ->values();

        $data['chainOfCustodyTat'] = ProcurementRequestApproval::select('step', \DB::raw('avg(TIMESTAMPDIFF(DAY,created_at, updated_at)) as average_tat'))
        ->groupBy('step')
        ->get();;

        $data['countsPerSector'] = ProcurementRequest::get()
        ->groupBy('procurement_sector')
        ->map(function ($group) {
            return [
                'sector' => $group->first()->procurement_sector,
                'count' => $group->count(),
                'contract_total' => round($group->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        })
        ->sortByDesc('contract_total')->values();

        $data['countsPerSubcategory'] = ProcurementRequest::withWhereHas('subcategory')
        ->get()
        ->groupBy('subcategory.name')
        ->map(function ($group) {
            return [
                'name' => $group->first()->subcategory->name,
                'count' => $group->count(),
                'contract_total' => round($group->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        })
        ->sortByDesc('count')
        ->values();

        $data['countsPerProvider'] = ProcurementRequest::withWhereHas('selected_provider')
        ->get()
        ->groupBy('selected_provider.name')
        ->map(function ($group) {
            return [
                'name' => $group->first()->selected_provider->name,
                'count' => $group->count(),
                'contract_total' => round($group->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        })
        ->sortByDesc('count')
        ->take(10)
        ->values();

        $data['countsPerMethod'] = ProcurementRequest::withWhereHas('procurement_method')
        ->get()
        ->groupBy('procurement_method.method')  // Group by the name attribute on the Provider relationship
        ->map(function ($group) {
            return [
                'name' => $group->first()->procurement_method->method,
                'count' => $group->count(),
                'contract_total' => round($group->sum(function ($request) {
                    return exchangeToDefaultCurrency($request->currency_id, $request->contract_value);
                })/1000000,2),
            ];
        })
        ->sortByDesc('count')
        ->values();

        return $data;
    }

    public function render()
    {
        return view('livewire.procurement.dashboard.procurement-main-dashboard-component',$this->getData())->layout('layouts.app');
    }
}
