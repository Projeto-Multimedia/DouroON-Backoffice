<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\EndUser;

class CompanyPlaces extends Model
{
    use HasFactory;


    protected $table = 'company_places';
    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name',
    //     'address',
    //     'location',
    //     'phone',
    //     'description',
    //     'image',
    //     'profile_id',
    // ];


    public function profile()
    {
        return $this->belongsTo(ProfileAccount::class);
    }
    
    public function companyInfo()
    {
        return $this->hasOne(EndUser::class, 'profile_id', 'profile_id');
    }
}
