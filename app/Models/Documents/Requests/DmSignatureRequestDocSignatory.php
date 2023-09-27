<?php

namespace App\Models\Documents\Requests;

use App\Models\User;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Documents\Requests\DmSignatureRequestDoc;

class DmSignatureRequestDocSignatory extends Model
{
    use HasFactory ,LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logFillable()
            ->useLogName('Document Signatory')
            ->dontLogIfAttributesChangedOnly(['created_by'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    protected $fillable =[
        'document_id',
        'signatory_id',
        'signatory_level',
        'signatory_status',
        'is_active',
        'acknowledgement',
        'signature',
        'comments',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'signatory_id', 'id');
    }
    public function document()
    {
        return $this->belongsTo(DmSignatureRequestDoc::class, 'document_id', 'id');
    }
}
