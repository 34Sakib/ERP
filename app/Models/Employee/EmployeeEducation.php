<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeEducation extends Model
{
    protected $table = 'employee_education';

    protected $fillable = [
        'employee_id',
        'institution',
        'degree',
        'field_of_study',
        'start_year',
        'end_year',
        'grade',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
