<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportantDates extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'course_id', 'title', 'body', 'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];
}
