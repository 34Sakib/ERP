<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;
use App\Models\User;

class AttendanceRegularization extends Model
{
    use HasFactory;

    protected $table = 'attendance_regularizations';

    protected $fillable = [
        'attendance_id',
        'employee_id',
        'requested_check_in',
        'requested_check_out',
        'reason',
        'status',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'requested_check_in' => 'datetime',
        'requested_check_out' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
