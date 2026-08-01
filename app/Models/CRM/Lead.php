<?php

namespace App\Models\CRM;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = [
        'crm_company_id',
        'name',
        'email',
        'phone',
        'source',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(CrmCompany::class, 'crm_company_id');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }
}
