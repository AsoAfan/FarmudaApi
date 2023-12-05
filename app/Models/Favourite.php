<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory, HasFilters;

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id', 'hadis_id'];


    protected $fillable = ['hadis_id', "user_id"];

    public function hadis()
    {
        return $this->belongsTo(Hadith::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
