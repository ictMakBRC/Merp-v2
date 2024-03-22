<?php

namespace App\Http\Livewire\Inventory\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Grants\Project\Project;
use App\Models\Inventory\Item\InvDepartmentItem;
use App\Models\HumanResource\Settings\Department;
use App\Models\Inventory\Requests\InvUnitRequest;
use App\Models\inventory\Requisitions\invRequest;

class InventoryMainDashboardComponent extends Component
{

  public $department_id,$department_namename;
  public $userid, $my_department;
  public $filter = false;
  public $from_date;

  public $to_date;

  public $perPage = 10;

  public $search = '';

  public $orderBy = 'id';
    public $request_type = 'Normal';
    public $unit_type = 'department';
    public $description;
    public $unit_id = 0;
    public $unitable_type;
    public $unitable_id;
    public $unitable;
    public function mount($type)
    {
        if ($type == 'all') {
            $this->unit_type = 'all';
            $this->unit_id = '0';
        } else {
            if (session()->has('unit_type') && session()->has('unit_id') && session('unit_type') == 'project') {
                $this->unit_id = session('unit_id');
                $this->unit_type = session('unit_type');
                $this->unitable = $unitable = Project::find($this->unit_id);
            } else {
                $this->unit_id = auth()->user()->employee->department_id ?? 0;
                $this->unit_type = 'department';
                $this->unitable = $unitable = Department::find($this->unit_id);
            }

            if ($unitable) {
                $this->unitable_type = get_class($unitable);
                $this->unitable_id = $this->unit_id;
            } else {
                abort(403, 'Unauthorized access or action.');
            }
        }
    }

  public function selectDepartment()
  {

    if (session()->has('department')) {
      session()->forget('department');
    }
    $this->userid = auth()->user()->id;
    $this->validate([
      'my_department' => 'required',
    ]);
    // $unit = invUserdeparment::with('department')->where(['user_id'=> $this->userid, 'department_id' => $this->my_department])->first();

    // dd($unit);
    // session(['department_name' => $unit->department->department_name??'']);
    // session(['department' => $unit->department_id]);
    return redirect(request()->header('Referer'));
  }

  function requests()  {
    return InvUnitRequest::with('unitable', 'createdBy')->when($this->unitable_id && $this->unitable_type, function ($query) {
      $query->where(['unitable_id' => $this->unitable_id, 'unitable_type' => $this->unitable_type]);})
      ->when($this->from_date != '' && $this->to_date != '', function ($query) {
          $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
      }, function ($query) {
          return $query;
      });
  }
  public function stockQuery()
  {
      $services = InvDepartmentItem::search($this->search)->when($this->unitable_id && $this->unitable_type, function ($query) {
          $query->where(['unitable_id' => $this->unitable_id, 'unitable_type' => $this->unitable_type]);})
          ->when($this->from_date != '' && $this->to_date != '', function ($query) {
              $query->whereBetween('created_at', [$this->from_date, $this->to_date]);
          }, function ($query) {
              return $query;
          });

      return $services;
  }
  public function render()
  {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        // if (session()->has('department')) {
      $this->department_id = session('department');
      $this->department_namename = session('department_name');

      $data['items'] = InvDepartmentItem::where('department_id', session('department'))->get();
      $data['requests'] = $this->requests()->get();
      $data['requestsPendingCount'] = $this->requests()->where(['status' => 'Submitted'])->count();
      $data['pendingRequests'] = $this->requests()->with('unitable')->where(['status' => 'Submitted'])->limit(10)->offset(0)->orderBy('id', 'DESC')->get();
      $data['stockwarning'] = $this->stockQuery()->where('qty_left','<',1)->get();
      // $data['stockwarningb'] = DB::select(DB::raw("SELECT  *, inv_items.id as item_id
      //   FROM `inv_department_items`
      //   left join `inv_items` on `inv_department_items`.`inv_item_id` = `inv_items`.`id`
      //   left join `inv_subunits` on `inv_items`.`inv_subunit_id` = `inv_subunits`.`id`
      //   left join `inv_uoms` on `inv_items`.`inv_uom_id` = `inv_uoms`.`id`
      //   WHERE inv_department_items.qty_left - inv_items.min_qty <= 0 AND inv_department_items.department_id = '$this->department_id'"));
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
      // }
      $data['departments'] = collect([]);
      $data['subunits'] = collect([]);
      $data['values'] = collect([]);




      return view('livewire.inventory.dashboard.inventory-main-dashboard-component',$data);
    }
  }
