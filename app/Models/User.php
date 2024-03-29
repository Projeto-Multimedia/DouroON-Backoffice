<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    use CrudTrait;
    use HasRoles; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setAvatarAttribute($value)
    {
        $attribute_name = "avatar";
        $disk = "uploads";
        $destination_path ="/uploads/avatar";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);

    }

    public function profile()
    {
        return $this->hasOne(ProfileAccount::class);
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'model_has_roles');
    // }

    // public function permissions()
    // {
    //     return $this->belongsToMany(Permission::class, 'model_has_permissions');
    // }

    // public function hasPermissionTo($permission)
    // {
    //     return $this->hasPermissionThroughRole($permission);
    // }

    // public function hasPermissionThroughRole($permission)
    // {
    //     foreach ($permission->roles as $role) {
    //         if ($this->roles->contains($role)) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }






}
