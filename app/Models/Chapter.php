<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'book_id'];

    protected $hidden = ['pivot'];



    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function hadises()
    {
        return $this->belongsToMany(Hadis::class);
    }
}
