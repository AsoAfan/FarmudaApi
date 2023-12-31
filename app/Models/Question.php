<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];

//    protected $with = ['user'];

    public function answer()
    {
        return $this->hasOne(Answer::class);

    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
