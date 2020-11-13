<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";
    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;

    protected $fillable = [
        'first_user', 'second_user'
    ];

}
