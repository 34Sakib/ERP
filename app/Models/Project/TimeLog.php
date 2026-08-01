<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class TimeLog extends Model
{
    use HasFactory;

    protected $table = 'time_logs';

    protected $fillable = [
        'task_id',
        'employee_id',
        'hours',
        'date',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
