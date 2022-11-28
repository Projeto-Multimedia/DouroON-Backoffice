<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\UserPost;

class UserPostLikes extends Model
{
    use HasFactory;
    
    protected $table = 'user_post_likes';

    protected $guarded = ['id'];

    public function profile()
    {
        return $this->belongsTo(ProfileAccount::class, 'profile_id');
    }

    public function post()
    {
        return $this->belongsTo(UserPost::class, 'post_id');
    }

    
}
