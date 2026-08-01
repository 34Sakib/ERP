<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeBankDetail extends Model
{
    protected $fillable = [
        'employee_id',
        'bank_name',
        'account_title',
        'account_number',
        'iban',
        'branch_code',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
