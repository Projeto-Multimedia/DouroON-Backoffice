<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\UserRoute;
use App\Models\CompanyPlace;

class SavePlace extends Model
{
    use HasFactory;


    protected $table = 'save_place';
    protected $guarded = ['id'];



    public function profile()
    {
        return $this->belongsTo(ProfileAccount::class, 'profile_id');
    }

    public function route()
    {
        return $this->belongsTo(UserRoute::class, 'route_id');
    }

    public function place()
    {
        return $this->belongsTo(CompanyPlace::class, 'place_id');
    }
}
