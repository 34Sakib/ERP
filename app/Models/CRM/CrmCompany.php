<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmCompany extends Model
{
    use HasFactory;

    protected $table = 'crm_companies';

    protected $fillable = [
        'name',
        'industry',
        'website',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}
