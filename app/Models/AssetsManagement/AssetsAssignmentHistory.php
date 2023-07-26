<?php

namespace App\Models\AssetsManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetsAssignmentHistory extends Model
{
    use HasFactory;

    public $table = 'assignment_history';

    protected $fillable = [
        'asset_id',
        'from',
        'to',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function fromuser()
    {
        return $this->belongsTo(User::class, 'from', 'id');
    }

    public function touser()
    {
        return $this->belongsTo(User::class, 'to', 'id');
    }
}
