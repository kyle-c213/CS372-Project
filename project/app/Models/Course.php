<?php

namespace App\Models;

use \App\Models\ClassMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'created_by', 'class_name', 'year', 'semester', 'taught_by'
    ];

    public function posts()
    {
        return $this->hasMany(Post::Class);
    }
}
