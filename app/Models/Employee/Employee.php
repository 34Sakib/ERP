<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\BelongsToCompany;
use App\Models\User;
use App\Models\Core\Company;
use App\Models\Core\Branch;
use App\Models\Core\Department;
use App\Models\Core\Designation;

class Employee extends Model
{
    use SoftDeletes, BelongsToCompany;

    protected $fillable = [
        'user_id',
        'company_id',
        'branch_id',
        'department_id',
        'designation_id',
        'employee_code',
        'first_name',
        'last_name',
        'gender',
        'dob',
        'marital_status',
        'phone',
        'personal_email',
        'address',
        'profile_photo',
        'signature_image',
        'joining_date',
        'probation_end_date',
        'confirmation_date',
        'employment_status',
        'termination_date',
        'termination_reason',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'probation_end_date' => 'date',
        'confirmation_date' => 'date',
        'termination_date' => 'date',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAvatarUrlAttribute(): string
    {
        if (!empty($this->profile_photo)) {
            return asset($this->profile_photo);
        }
        if ($this->user && !empty($this->user->avatar)) {
            return asset($this->user->avatar);
        }
        return 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmployeeEmergencyContact::class);
    }

    public function education(): HasMany
    {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function experience(): HasMany
    {
        return $this->hasMany(EmployeeExperience::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function bankDetail(): HasOne
    {
        return $this->hasOne(EmployeeBankDetail::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(EmployeeHistory::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(EmployeeNote::class);
    }
}
