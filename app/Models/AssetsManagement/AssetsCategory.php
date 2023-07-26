<?php

namespace App\Models\AssetsManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AssetsCategory extends Model
{
    use HasFactory;

    protected $fillable = ['category_name'];

    public function Subcategories()
    {
        return $this->hasMany(AssetsSubcategory::class);
    }

    public function asset()
    {
        return $this->hasMany(Asset::class);
    }

    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
        }
    }
}
