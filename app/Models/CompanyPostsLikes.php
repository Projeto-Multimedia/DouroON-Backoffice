<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\CompanyPost;

class CompanyPostsLikes extends Model
{
    use HasFactory;

    protected $table = 'company_posts_likes';

    protected $guarded = ['id'];

    public function profile()
    {
        return $this->belongsTo(ProfileAccount::class, 'profile_id');
    }

    public function post()
    {
        return $this->belongsTo(CompanyPost::class, 'post_id');
    }
}
