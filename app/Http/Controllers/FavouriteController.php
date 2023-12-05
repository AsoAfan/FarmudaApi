<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Hadith;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class FavouriteController extends Controller
{

    public function index()
    {


        return Favourite::with('hadis')
            ->filter(
                array_filter(
                    request(['lang', 'search', 'hukim', 'teller', 'category', 'book', 'chapter']),
                    fn($value) => $value !== [null])
            )
            ->get()->map(fn($user) => $user->hadis);


    }

    public function store(Hadith $hadis)
    {
        try {
            auth()->user()->favourites()->create(['hadis_id' => $hadis->id]);


            return response()->json(['success' => Str::take($hadis->arabic, 10) . " Added to " . auth()->user()->name . "'s favourite list"]);
        } catch (QueryException $exception) {
            return response(["errors" => $exception->getMessage()], 400);
        }


    }


}
