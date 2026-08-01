<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class Payslip extends Model
{
    use HasFactory;

    protected $table = 'payslips';

    protected $fillable = [
        'payroll_run_id',
        'employee_id',
        'basic_salary',
        'total_allowances',
        'total_deductions',
        'total_bonuses',
        'tax_amount',
        'net_salary',
        'pdf_path',
        'status',
    ];

    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
