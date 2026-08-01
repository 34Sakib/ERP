<?php

namespace App\Models\Leave;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Company;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_types';

    protected $fillable = [
        'company_id',
        'name',
        'color',
        'days_per_year',
        'carry_forward',
        'max_carry_forward_days',
        'gender_restriction',
        'requires_approval',
        'is_paid',
        'status',
    ];

    protected $casts = [
        'carry_forward' => 'boolean',
        'requires_approval' => 'boolean',
        'is_paid' => 'boolean',
        'status' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function balances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function applications()
    {
        return $this->hasMany(LeaveApplication::class);
    }
}
