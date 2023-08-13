<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Normalizer;
use function Laravel\Prompts\search;

//use Patchwork\Utf8\Normalizer;

class Hadis extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['arabic_search'];


    public function scopeFilter($query, array $filters)
    {


        $query->when($filters['search'] ?? false, function ($query, $search) {

//            $normalizedSearchQuery = Normalizer::normalize($search, Normalizer::FORM_D);
            $query
                ->where('arabic_search', 'like', "%{$search}%")
                ->orWhere('kurdish', 'like', "%{$search }%")
                ->orWhere('hadis_number', 'like', "%{$search}%");

        }); // $search = $filters['search']

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
