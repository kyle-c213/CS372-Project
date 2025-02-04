<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table = "professors";

    public function ratings(){
        return $this->hasMany(Ratings::class);
    }

    //only varialbes in DB that are allowed to have data entered
    //might not need
    protected $fillable = [
        'faculty','name'
    ];

    // primary key of the table
    protected $primaryKey = 'id';

    // indicates that the primary key auto increments
    public $incrementing = true;

    public $timestamps = false;
}
