<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ["name", "slug"];

    protected $hidden = ['pivot'];

    public function activities()
    {
        return $this->morphMany(Activity::class, 'model');
    }

    public function chapters()
    {
        return $this->belongsToMany(Chapter::class);
    }
}
