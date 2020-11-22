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

    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;
}
