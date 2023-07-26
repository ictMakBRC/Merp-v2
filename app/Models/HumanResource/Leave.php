<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'duration', 'carriable', 'is_payable', 'payment_type', 'given_to', 'notice_days', 'details', 'status'];
}
