<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//use Patchwork\Utf8\Normalizer;

class Hadis extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['teller', 'categories', 'chapters.books']; // TODO: return books of chapters(chapters.books)

    protected $hidden = ['arabic_search', 'pivot', 'teller_id', 'categories_count'];


    public function scopeFilter($query, array $filters)
    {

        /**
         *
         *  Must-have filters for hadises
         * 1. search (arabic, kurdish OR badini and hadis_number => PartialMatch)
         * 2. teller (name => ExactMatch)
         * 3. categories (name => ExactMatch)
         * 4. Books (name => ExactMatch)
         * 5. Chapters (name => ExactMatch)
         *
         * */


        // 1. Search
        $query->when($filters['search'] ?? false, function ($query, $search) use ($filters) {
            $query->where(function ($query) use ($search, $filters) {
                $query->where('arabic_search', 'like', "%{$search}%")
                    ->orWhere(
                        ($filters['lang'] ?? "ku") == "bd" ? 'badini' : "kurdish",
                        'like', "%{$search}%")
                    ->orWhere('hadis_number', 'like', "%{$search}%");
//                    ->orWhereHas('chapters', function ($query) use ($search){
//                        $query->where('name', 'like', "%$search%"); }); Search in Chapters also
            });
        });


        // 2. teller
        $query->when($filters['teller'] ?? false, function ($query, $teller) {
            $query->whereHas('teller', function ($q) use ($teller) {
                $q->where('name', $teller);
            });
        }); // Teller Done


        // 3. categories
        $query->when(($filters['category'] ?? false), function ($query, $category) {
            $query
                ->withCount('categories')
                ->whereHas('categories', function ($query) use ($category) {
                    $query->distinct()->whereIn('name', $category); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME
                }, '=', count($category));
        });


        // 4. books
        $query->when(($filters['book'] ?? false), function ($query, $book) {
            $query
                ->withCount('books')
                ->whereHas('chapters.books', function ($query) use ($book) {
                    $query->distinct()->whereIn('name', $book); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME
                }, '=', count($book));
        });


        // 5. chapters
        $query->when(($filters['chapter'] ?? false), function ($query, $chapter) {
            $query
                ->withCount('chapters')
                ->whereHas('chapters', function ($query) use ($chapter) {
                    $query->distinct()->whereIn('name', $chapter); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME
                }, '=', count($chapter));
        });

    }


    public function activity()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function favourites()
    {
        $this->hasMany(Favourite::class);
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
