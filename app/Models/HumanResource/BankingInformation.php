<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingInformation extends Model
{
    use HasFactory;

    public $table = 'banking_information';

    protected $fillable = ['employee_id', 'bank_name', 'branch', 'account_name', 'currency', 'account_number'];
}
