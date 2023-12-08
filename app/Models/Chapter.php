<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'book_id'];

    protected $hidden = ['pivot'];


    public function activities()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function hadiths()
    {
        return $this->belongsToMany(Hadith::class);
    }
}
