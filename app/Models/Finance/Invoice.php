<?php

namespace App\Models\Finance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'client_name',
        'invoice_number',
        'issue_date',
        'due_date',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
