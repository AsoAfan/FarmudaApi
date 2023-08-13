<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuxariChapter extends Model
{
    use HasFactory;

    protected $hidden = ['pivot', 'id'];

    public function hadises()
    {
        return $this->belongsToMany(Hadis::class);
    }
}
