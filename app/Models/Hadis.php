<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


//use Patchwork\Utf8\Normalizer;

class Hadis extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['arabic_search', 'pivot'];


    public function scopeFilter($query, array $filters)
    {

//        dd($filters);

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('arabic_search', 'like', "%{$search}%")
                    ->orWhere('kurdish', 'like', "%{$search}%")
                    ->orWhere('hadis_number', 'like', "%{$search}%");
//                    ->orWhereHas('buxariChapters', function ($query) use ($search){
//                        $query->where('name', 'like', "%$search%"); }); Search in BuxariChapters also
            });
        });


//        $query->withCount('categories')
//            ->whereHas(
//                'tags',
//                fn ($query) => $query->whereIn('asset_tags.id', $tagIds),
//            )
//            ->having('tags_count', $tagIds->count());


        $query->when(($filters['category'] ?? false) , function ($query, $category) {
            $query->withCount()
            $query->whereHas('categories', function ($query) use ($category) {

                foreach ($category as $i) {

                    $query->where('name', $i); // TODO: FIX FILTER NOT WORKING FOR ALL IN A TIME

                }
            });
        });


        $query->when($filters['bchapter'] ?? false, function ($query, $chapter) {
            $query->whereHas('buxariChapters', function ($query) use ($chapter) {
                $query->whereIn('name', $chapter);
            });
        });

        $query->when($filters['teller'] ?? false, function ($query, $teller) {
            $query->whereHas('teller', function ($q) use ($teller) {
                $q->where('name', $teller);

            });

        });
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function buxariChapters()
    {
        return $this->belongsToMany(BuxariChapter::class);
    }


    public function teller()
    {
        return $this->belongsTo(Teller::class, 'teller_id');
    }

}
