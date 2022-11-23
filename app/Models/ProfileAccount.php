<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EndUser;
use App\Models\UserFollowers;
use App\Models\CompanyFollowers;

class ProfileAccount extends Model
{
    use HasFactory;

    protected $table = 'profile_accounts';  
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(EndUser::class);
    }

    public function followers()
    {
        return $this->hasMany(UserFollowers::class, 'account_id');
    }

    public function following()
    {
        return $this->hasMany(UserFollowers::class, 'account_loggedIn_id');
    }

    public function Companyfollowers()
    {
        return $this->hasMany(CompanyFollowers::class, 'account_id');
    }

    public function Companyfollowing()
    {
        return $this->hasMany(CompanyFollowers::class, 'account_loggedIn_id');
    }
    

}
