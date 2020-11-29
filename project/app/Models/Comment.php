<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = "comments";
    //primary key
    protected $primaryKey = "id";
    //makes primary key increment
    public $incrementing = true;

    protected $fillable = ['body', 'user_id', 'post_id'];
    protected $guarded = [];


    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
