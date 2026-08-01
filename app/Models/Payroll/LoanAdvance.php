<?php

namespace App\Models\Payroll;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\User;

class LoanAdvance extends Model
{
    use HasFactory;

    protected $table = 'loans_advances';

    protected $fillable = [
        'employee_id',
        'type',
        'amount',
        'installments',
        'remaining_amount',
        'status',
        'requested_at',
        'approved_by',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
