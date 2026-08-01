<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $table = 'applicants';

    protected $fillable = [
        'job_post_id',
        'name',
        'email',
        'phone',
        'resume_path',
        'source',
        'status',
    ];

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}
