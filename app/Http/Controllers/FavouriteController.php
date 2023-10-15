<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Hadis;
use Illuminate\Database\QueryException;

class FavouriteController extends Controller
{

    public function index()
    {


        return response()->json([
                "data" => Favourite::where('user_id', auth()->id())->get(),
            ]
        );

    }

    public function store(Hadis $hadis)
    {
        try {
            auth()->user()->favourites()->create(['hadis_id' => $hadis->id]);

            return response()->json(['success' => "{$hadis->arabic} Added to " . auth()->user()->name . "'s favourite list"]);
        } catch (QueryException $exception) {
            return response()->json(["errors" => "Duplicated entry"], 400);
        }


    }


}
