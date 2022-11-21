<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileAccount extends Model
{
    use HasFactory;

    protected $table = 'profile_accounts';  
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(EndUser::class);
    }
    

}
