<?php

namespace App\Models\NoticeBoard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyDocument extends Model
{
    use HasFactory;

    protected $table = 'policy_documents';

    protected $fillable = [
        'title',
        'category',
        'file_size',
        'file_path',
    ];
}
