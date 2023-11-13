<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Hadis;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class FavouriteController extends Controller
{

    public function index()
    {


        return Favourite::with('hadis')->join('hadis', 'favourites.hadis_id', '=', 'hadis.id')
            ->filter(
                array_filter(
                    request(['lang', 'search', 'hukim', 'teller', 'category', 'book', 'chapter']),
                    fn($value) => $value !== [null])
            )
            ->get()->map(fn($user) => $user->hadis);


    }

    public function store(Hadis $hadis)
    {
        try {
            auth()->user()->favourites()->create(['hadis_id' => $hadis->id]);

            $shortHadis = Str::take($hadis->arabic, 10);

            return response()->json(['success' => "{$shortHadis} Added to " . auth()->user()->name . "'s favourite list"]);
        } catch (QueryException $exception) {
            return response(["errors" => "Duplicated entry"], 400);
        }


    }


}
