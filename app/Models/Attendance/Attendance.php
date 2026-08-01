<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'check_in_source',
        'check_in_lat',
        'check_in_lng',
        'device_id',
        'status',
        'late_minutes',
        'early_leave_minutes',
        'overtime_minutes',
        'total_worked_minutes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function regularizations()
    {
        return $this->hasMany(AttendanceRegularization::class);
    }
}
