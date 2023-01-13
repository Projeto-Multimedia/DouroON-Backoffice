<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;
use App\Models\ProfileAccount;

class Messages extends Model
{
    use HasFactory;

    protected $table = 'messages';
    protected $guarded = ['id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(ProfileAccount::class, 'sender_id');
    }

}
