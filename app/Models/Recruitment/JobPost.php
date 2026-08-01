<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Company;
use App\Models\Core\Department;

class JobPost extends Model
{
    use HasFactory;

    protected $table = 'job_posts';

    protected $fillable = [
        'company_id',
        'department_id',
        'title',
        'description',
        'employment_type',
        'status',
        'closing_date',
    ];

    protected $casts = [
        'closing_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }
}
