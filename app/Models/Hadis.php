<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Hadis extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query
                ->where(
                    'arabic', 'like', "%" . request('search') . "%"
                )->orWhere(
                    'kurdish', 'like', "%" . request('search') . "%"
                )->orWhere(
                    'hadis_number', 'like', "%" . request('search') . "%"
                );

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
