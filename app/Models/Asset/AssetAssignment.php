<?php

namespace App\Models\Asset;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee\Employee;

class AssetAssignment extends Model
{
    use HasFactory;

    protected $table = 'asset_assignments';

    protected $fillable = [
        'asset_id',
        'employee_id',
        'assigned_date',
        'returned_date',
        'condition_on_assign',
        'condition_on_return',
    ];

    protected $casts = [
        'assigned_date' => 'date',
        'returned_date' => 'date',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
