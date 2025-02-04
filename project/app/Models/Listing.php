<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $table = "listings";
    // primary key of the table
    protected $primaryKey = 'id';
    // indicates that the primary key auto increments
    public $incrementing = true;

    protected $fillable = [
        'posted_by', 'course_id', 'title', 'description', 'price', 'sold', 'deleted'
    ];

    public function getPicture()
    {
        $picPath = $this->picture;
        return 'storage/' . $picPath;
    }
}
