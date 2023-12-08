<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Teller extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    public function activities()
    {

        return $this->morphMany(Activity::class, 'model');

    }

    public function hadiths()
    {
        return $this->hasMany(Hadith::class);
    }
}
