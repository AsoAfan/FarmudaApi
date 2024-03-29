<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

    public function activities()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function hadiths()
    {
        return $this->belongsToMany(Hadith::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

}
