<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory, HasFilters;

    protected $hidden = ['id', 'created_at', 'updated_at', 'user_id', 'hadith_id'];


    protected $fillable = ['hadith_id', "user_id"];

    public function hadith()
    {
        return $this->belongsTo(Hadith::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
