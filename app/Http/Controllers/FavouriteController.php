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


        return Favourite::with('hadith')
            ->filter(
                array_filter(
                    request(['lang', 'search', 'hukim', 'teller', 'category', 'book', 'chapter']),
                    fn($value) => $value !== [null])
            )
            ->get()->map(fn($user) => $user->hadith);


    }

    public function store(Hadith $hadith)
    {
        try {
            auth()->user()->favourites()->create(['hadith_id' => $hadith->id]);


            return response()->json([
                'success' => Str::take($hadith->arabic, 10) . " Added to " . auth()->user()->name . "'s favourite list",
                'data' => $hadith
            ]);
        } catch (QueryException $exception) {
            return response(["errors" => $exception->getMessage()], 400);
        }


    }


}
