<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\EndUser;

class CompanyFollowers extends Model
{
    use HasFactory;

    protected $table = 'company_followers';
    protected $guarded = ['id'];


    public function company()
    {
        return $this->belongsTo(Company::class, 'account_id');
    }

    public function follower()
    {
        return $this->belongsTo(EndUser::class, 'account_loggedIn_id');
    }


}
