<?php

namespace App\Models\inventory\Requisitions;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invRequest extends Model
{
    use HasFactory;


    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id', 'id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function borrower()
    {
        return $this->belongsTo(Department::class, 'borrower_id', 'id');
    }
}
