<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\UserPost;

class UserPostComments extends Model
{
    use HasFactory;

    protected $table = 'user_post_comments';

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
