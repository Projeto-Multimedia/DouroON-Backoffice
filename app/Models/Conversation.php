<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProfileAccount;
use App\Models\Message;

class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';
    protected $guarded = ['id'];


    public function userOne()
    {
        return $this->belongsTo(ProfileAccount::class, 'user_one');
    }

    public function userTwo()
    {
        return $this->belongsTo(ProfileAccount::class, 'user_two');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getOtherUser($user)
    {
        if ($user->id == $this->userOne->id) {
            return $this->userTwo;
        } else {
            return $this->userOne;
        }
    }
}
