<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class SalaryStructure extends Model
{
    use HasFactory;

    protected $table = 'salary_structures';

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'effective_date',
        'status',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'status' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function components()
    {
        return $this->hasMany(SalaryComponent::class);
    }
}
