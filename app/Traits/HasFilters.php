<?php

namespace App\Traits;
trait HasFilters
{


    public function scopeFilter($query, array $filters)
    {

        /**
         *
         *  Must-have filters for hadiths
         * 1. Language
         * 2. Search (arabic, hawramy, kurdish, badiny OR badiny and hadith_number => PartialMatch)
         * 3. Hukim (option [s, h, z, m] => MustExists)
         * 4. Teller (name => ExactMatch)
         * 5. Categories (name => ExactMatch)
         * 6. Books (name => ExactMatch)
         * 7. Chapters (name => ExactMatch)
         *
         * */


        $language = match ($filters['lang'] ?? null) {
            'hr' => 'hawramy',
            'bd' => 'badiny',
            default => 'kurdish'
        };


        // callbacks can be modified to arrow functions


        // 1. language
        // TODO: Return only specified language column not all three


        // 2. Search
        $query->when($filters['s'] ?? false, function ($query, $search) use ($language, $filters) {

            if (is_numeric($filters['s'])) $query->Where('hadith_number', 'like', "{$search}%");
            else
                $query->where(function ($query) use ($language, $search, $filters) {
                    $query
                        ->where('arabic_search', 'like', "%{$search}%")
//                ($filters['lang'] ?? "ku") == "bd" ? 'badiny' : "kurdish"
                        ->orWhere(
                            $language,
                            'like', "%{$search}%");


//                    ->orWhereHas('chapters', function ($query) use ($search){
//                        $query->where('name', 'like', "%$search%"); }); Search in Chapters also
                })->orderByRaw("CASE WHEN arabic_search LIKE ? THEN 1 ELSE 2 END", ["%$search%"]);


        });


        // 3. hukim
        $query->when($filters['hukim'] ?? false, function ($query, $hukim) {
            $query->where('hukim', $hukim);
        });

        // 4. teller
        $query->when($filters['teller'] ?? false, function ($query, $teller) {
            $query->whereHas('teller', function ($query) use ($teller) {
                $query->where('id', $teller);
            });
        });

        // 5. categories
        $query->when(($filters['category'] ?? false), function ($query, $category) {
            $query
                ->withCount('categories')
                ->whereHas('categories', function ($query) use ($category) {
                    $query->distinct()->whereIn('id', $category); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME
                }, '=', count($category));
        });

        // 6. books
        $query->when(($filters['book'] ?? false), function ($query, $book) {
            $query
                ->withCount('books')
                ->whereHas('chapters.books', function ($query) use ($book) {
                    $query->distinct()->whereIn('id', $book); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME
                }, '=', count($book));
        });

        // 7. chapters
        $query->when(($filters['chapter'] ?? false), function ($query, $chapter) {
            $query
                ->withCount('chapters')
                ->whereHas('chapters', function ($query) use ($chapter) {
                    $query->distinct()->whereIn('id', $chapter); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME: DONE
                }, '=', count($chapter));
        });


    }


}
