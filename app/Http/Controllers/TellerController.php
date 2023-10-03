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

        return ["success" => "Teller added successfully", "newTeller" => $newTeller];

    }

    public function update(Request $request, Teller $teller)
    {

        $validator = Validator::make($request->all(), [
            'name' => ["unique:tellers,name", new ArabicChars],
            'slug' => ['unique:tellers,slug', new SlugValidator]
        ]);


        if ($validator->fails()) return response()->json([$validator->errors()], 422);


        $teller->update($request->all());

        return ["success" => "Data updated success fully", "newTeller" => $teller];
    }

    public function destroy(Request $request, Teller $teller)
    {

        $teller->delete();
        return response()->json(['success' => $teller->name . " deleted successfully"]);

    }

}
