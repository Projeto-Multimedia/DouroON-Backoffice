<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\UserPost;
use App\Models\EndUser;
use App\Models\ProfileAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EndUser extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'end_users';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 
        'username',
        'email',
        'avatar',
        'password',
        'profile',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function setAvatarAttribute($value)
    {
        $attribute_name = "avatar";
        $disk = "uploads";
        $destination_path ="/uploads/avatar";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    }


    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->token = Str::random(60);
        });

        static::created(function ($endUser) {
            $endUser->profileAccount()->create();
        });


        static::created(function ($endUser) {
            $endUser->profile_id = $endUser->profileAccount->id;
            $endUser->save();
        });
    }

    //hash password when creating user
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

     
     //Get the posts for the user.
    public function posts()
    {
        return $this->hasMany(UserPost::class);
    }

    //Get posts by end user id
    public function EndUserPosts($id)
    {
        return $this->posts()->where('enduser_id', $id)->get();
    }

    //Get the profile account for the user.
    public function profileAccount()
    {
        return $this->hasOne(ProfileAccount::class);
    }


  


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
