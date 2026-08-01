<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class EmployeeHistory extends Model
{
    protected $table = 'employee_history';

    protected $fillable = [
        'employee_id',
        'field_changed',
        'old_value',
        'new_value',
        'effective_date',
        'changed_by',
        'reason',
    ];

    protected $casts = [
        'effective_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
