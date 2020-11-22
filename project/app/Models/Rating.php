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


    protected $guarded = [];

    protected $fillable = [
        $table->id();
        $table->foreignId('rated_by')->constrained('users')->onDelete('cascade');
        $table->foreignId('professor_rated')->constrained('professors')->onDelete('cascade');
        $table->foreignId('course_taken')->constrained('courses')->onDelete('cascade');
        $table->float('rating');
        $table->string('body');
    ];

    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;
}
