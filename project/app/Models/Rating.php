<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = "ratings";

    public function professor(){

        return $this->belongsTo(Professor::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    //only varialbes in DB that are allowed to have data entered
    protected $fillable = [
        'rating','rated_by','professor_rated','comments','class_taken'
    ];

    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;
}
