<?php

namespace App\Models\Documents\Requests;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Documents\Settings\DmCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Documents\Requests\DmSignatureRequestDoc;

class DmSignatureRequest extends Model
{
    use HasFactory ,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Document Requests')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'request_code',
        'parent_id',
        'is_active',
    ];
    public function category()
    {
        return $this->belongsTo(DmCategory::class, 'category_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(DmSignatureRequestDoc::class, 'request_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = auth()->id();
            });
            self::creating(function ($model) {
                $model->updated_by = auth()->id();
            });
        }
    }

    public static function search($search)
    {
        return empty($search) ? static::query()
        : static::query()
            ->where('title', 'like', '%'.$search.'%')
            ->where('request_code', $search)
            ->orWhere('description', 'like', '%'.$search.'%');
    }
}
