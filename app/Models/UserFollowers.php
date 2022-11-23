<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EndUser;

class UserFollowers extends Model
{
    use HasFactory;

    protected $table = 'user_followers';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(EndUser::class, 'account_id');
    }

    public function follower()
    {
        return $this->belongsTo(EndUser::class, 'account_loggedIn_id');
    }
}
