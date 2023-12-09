<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Hadith;
use Exception;
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
            auth()->user()->hadiths()->syncWithoutDetaching($hadith);


            return response()->json([
                'success' => Str::take($hadith->arabic, 10) . " Added to " . auth()->user()->name . "'s favourite list",
                'data' => $hadith->id
            ]);
        } catch (QueryException $exception) {

            return response(['errors' => "Bad request", 'status' => 400], 400);

        }

    }

    public function destroy(Hadith $hadith)
    {
        try {

            auth()->user()->hadiths()->detach($hadith);

            return response()->json([
                'success' => Str::take($hadith->arabic, 10) . " removed from " . auth()->user()->name . "'s favourite list",
                'data' => $hadith->id
            ]);

        } catch (Exception $exception) {
            return response(['errors' => "Bad request", 'status' => 400], 400);
        }


    }


}
