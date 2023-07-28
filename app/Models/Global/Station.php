<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Station extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = ['station_name', 'description', 'status'];

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()           
                ->where('station_name', 'like', '%'.$search.'%')
                ->orWhere('description', 'like', '%'.$search.'%');
               
    }
}
