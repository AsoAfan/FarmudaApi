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
                "fav" => Favourite::where('user_id', auth()->id())->get(),
                'status' => 200
            ]
        );

    }

    public function store(Hadis $hadis)
    {
        try {
            auth()->user()->favourites()->create(['hadis_id' => $hadis->id]);

            return response()->json(['success' => "{$hadis->arabic} Added to " . auth()->user()->name . "'s favourite list", 'status' => 200]);
        } catch (QueryException $exception) {
            return response()->json(["errors" => "Duplicated entry", "status" => 422], 422);
        }


    }


}