<?php

namespace App\Models\Inventory\Requisitions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Inventory\Item\InvItem;
use \App\Models\HumanResource\Settings\Department;
use App\Models\HumanResource\EmployeeData\Employee;

class InvDepartmentRequest extends Model
{
  use HasFactory;

  public function department()
  {
    return $this->belongsTo(Department::class, 'department_id', 'id');
  }

  public function item()
  {
    return $this->belongsTo(InvItem::class, 'item_id', 'id');
  }

  public function approver()
  {
    return $this->belongsTo(Employee::class, 'approver_id', 'id');
  }

  public static function search($search)
  {
    return empty($search) ? static::query()
    : static::query()
    ->where('request_code', 'like', '%'.$search.'%')
    ->orWhereHas('item', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    })
    ->orWhereHas('department', function ($query) use ($search) {
      $query->where('name', 'like', '%'.$search.'%');
    });
  }

}
