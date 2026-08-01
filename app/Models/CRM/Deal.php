<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Deal extends Model
{
    use HasFactory;

    protected $table = 'deals';

    protected $fillable = [
        'lead_id',
        'title',
        'value',
        'stage',
        'owner_id',
        'expected_close_date',
    ];

    protected $casts = [
        'expected_close_date' => 'date',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function crmTasks()
    {
        return $this->hasMany(CrmTask::class);
    }
}
