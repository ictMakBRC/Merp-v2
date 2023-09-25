<?php

namespace App\Models\Documents\Requests;

use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Documents\Settings\DmCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DmSignatureRequestDoc extends Model
{
    use HasFactory,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Request Documents')
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable = [
        'name',
        'description',
        'created_by',
        'code',
        'parent_id',
        'is_active',
    ];
    public function signatories()
    {
        return $this->hasMany(DmSignatureRequestDocSignatory::class, 'document_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(DmCategory::class, 'category_id', 'id');
    }
    public function supportDocuments()
    {
        return $this->hasMany(DmSignatureRequestSupportDoc::class, 'parent_id', 'id');
    }
    public function documentRequest()
    {
        return $this->belongsTo(DmSignatureRequest::class, 'request_id', 'id');
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
    public static function search($search)
    {
        return empty($search) ? static::query()
            : static::query()
                ->where('title', 'like', '%'.$search.'%')
                ->where('request_code', 'like', '%'.$search.'%')
                ->orWhereHas('category', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
    }
}
