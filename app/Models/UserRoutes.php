<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;

class UserRoutes extends Model
{
    use HasFactory;

    protected $table = 'user_routes';
    protected $guarded = ['id'];



    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
