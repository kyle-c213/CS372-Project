<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = "courses";
    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;
    
    protected static function boot()
    {
        parent::boot();

        static::created(function($class) {
            $class->course()->create([
                'school' => 'University of Regina',
                'class' => '',
                'prof' => '',
            ]);
        });
    }

    public function course()
    {
        return $this->hasOne(Classes::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }
}
