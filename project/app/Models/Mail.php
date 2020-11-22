<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;

    protected $fillable = [
        'from', 'to', 'title', 'content', 'opened', 'from_deleted', 'to_deleted', 'child_of'
    ];
}
