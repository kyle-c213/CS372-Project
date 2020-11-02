<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profilePic()
    {
        $picPath = ($this->picture) ?  $this->picture : '/profile/default.png';
        return 'storage/' . $picPath;
    }
}
