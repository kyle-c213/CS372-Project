<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = "courses";
    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
