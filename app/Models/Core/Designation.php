<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Employee\Employee;

class Designation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'title',
        'level',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'level' => 'integer',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
