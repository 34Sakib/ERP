<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Company;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'start_time',
        'end_time',
        'break_minutes',
        'grace_minutes',
        'is_night_shift',
    ];

    protected $casts = [
        'is_night_shift' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
