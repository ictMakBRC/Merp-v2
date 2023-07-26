<?php

namespace App\Models\HumanResource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notice extends Model
{
    use HasFactory;

    protected $fillable = ['notice', 'audience', 'expires_on', 'created_by'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'created_by', 'id');
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = Auth::user()->employee->id;
            });
        }
    }
}
