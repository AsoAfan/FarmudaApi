<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teller extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function hadises()
    {
        return $this->hasMany(Hadis::class);
    }
}
