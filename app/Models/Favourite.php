<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id', 'hadis_id'];

    protected $with = ['hadis'];

    protected $fillable = ['hadis_id', "user_id"];

    public function hadis()
    {
        return $this->belongsTo(Hadis::class);
    }

    public function user()
    {
       return $this->belongsTo(User::class);
    }
}
