<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CrmTask extends Model
{
    use HasFactory;

    protected $table = 'crm_tasks';

    protected $fillable = [
        'deal_id',
        'title',
        'due_date',
        'assigned_to',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
