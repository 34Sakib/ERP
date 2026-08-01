<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Department;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';

    protected $fillable = [
        'department_id',
        'category',
        'allocated_amount',
        'year',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
