<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $with = ['messages'];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        $this->belongsTo(User::class, 'reciver_id');
    }

    public function messages()
    {

        return $this->hasMany(Message::class);

    }
}
