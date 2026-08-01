<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Employee\Employee;

class Team extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'name',
        'lead_employee_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'lead_employee_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'team_members');
    }
}
