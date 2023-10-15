<?php

namespace App\Http\Controllers;

use App\Models\Teller;
use App\Rules\ArabicChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TellerController extends Controller
{


    public function show()
    {
        return Teller::all();
    }


    public function store(Request $request)
    {
        // TODO: CUT THIS FUNCTION INTO A CONTROLLER
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:tellers,name', new ArabicChars],
        ]);

        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 400);


        $newTeller = Teller::create([
            'name' => $request->get('name'),
        ]);

        return ["success" => "Teller added successfully", "data" => $newTeller];

    }

    public function update(Request $request, Teller $teller)
    {

        $validator = Validator::make($request->all(), [
            'name' => ["unique:tellers,name", new ArabicChars],

        ]);


        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);


        $teller->update($request->all());

        return ["success" => "Data updated success fully", "data" => $teller];
    }

    public function destroy(Teller $teller)
    {

        $delete = $teller->delete();
        if (!$delete) return response(['errors' => ['An error occurred while deleting teller']], 400);
        return ['success' => $teller->name . " deleted successfully", 'data' => $teller->id];

    }

}
