<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryComponent extends Model
{
    use HasFactory;

    protected $table = 'salary_components';

    protected $fillable = [
        'salary_structure_id',
        'type',
        'name',
        'amount',
        'is_percentage',
    ];

    protected $casts = [
        'is_percentage' => 'boolean',
    ];

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }
}
