<?php

namespace App\Http\Controllers;

use App\Models\Teller;
use App\Rules\ArabicChars;
use App\Rules\SlugValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TellerController extends Controller
{


    public function show()
    {
        return Teller::with('hadises')->get();
    }


    public function store(Request $request)
    {
        // TODO: CUT THIS FUNCTION INTO A CONTROLLER
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => ['required', 'unique:tellers,name', new ArabicChars],
            "slug" => ["required", "unique:tellers,slug", new SlugValidator]
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()], 422);


        $newTeller = \App\Models\Teller::create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug')
        ]);

        return ["success" => "Teller added successfully", $newTeller];

    }

    public function update($slug, Request $request)
    {
        $teller = Teller::where('slug', $slug)->first();

        if (!$teller) return response()->json(["errors" => "Teller not found"], 404);


        $validator = Validator::make($request->all(), [
            'name' => ["unique:tellers,name", new ArabicChars],
            'slug' => ['unique:tellers,slug', new SlugValidator]
        ]);


        if ($validator->fails()) return response()->json([ $validator->errors()], 422);


        $teller->update($request->all());

        return ["success" => "Data updated success fully", "newTeller" => $teller];
    }

    public function destroy($slug, Request $request)
    {

        $teller = Teller::where('slug', $slug)->first();

        if (!$teller) return response()->json(["errors" => "user not found"], 404);

        $teller->delete();
        return response()->json(['success' => $teller->name . " deleted successfully"]);

    }

}
