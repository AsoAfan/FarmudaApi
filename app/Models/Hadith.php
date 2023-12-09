<?php

namespace App\Models;

use App\Traits\HasFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


//use Patchwork\Utf8\Normalizer;

class Hadith extends Model
{
    use HasFactory, HasFilters, SoftDeletes;

    protected $guarded = [];


//    protected $with = ['teller', 'categories', 'chapters.books']; // TODO: return books of chapters(chapters.books)

    protected $hidden = ['arabic_search', 'pivot', 'teller_id', 'categories_count'];


    public function activity()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function user()
    {
        $this->belongsToMany(User::class, 'favourites');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class);
    }


    public function teller()
    {
        return $this->belongsTo(Teller::class, 'teller_id');
    }

}
