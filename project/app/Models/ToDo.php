<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToDo extends Model
{
    use HasFactory;

    protected $table = "to_dos";

    protected $fillable = [
        'user_id', 'title', 'body', 'due_date', 'complete', 'deleted'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    public $timestamps = false;
}
