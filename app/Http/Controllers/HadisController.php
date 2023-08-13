<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Hadis;
use App\Rules\ArabicChars;
use App\Rules\AtLeastOne;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HadisController extends Controller
{

    public function show()
    {
        return Hadis::with('categories', 'buxariChapters')->filter(request(['search']))->get();
    }

    public function store(Request $request)
    {
        $atLeastOne = (!$request->get('muslim_chapter_ids') && !$request->get('buxari_chapter_ids') ? 'required' : '');

        $validator = Validator::make($request->all(), [
            'hadis_arabic' => ['unique:hadis,arabic', 'required', new ArabicChars],
            'hadis_kurdish' => ['unique:hadis,kurdish', 'required', new KurdishChars],
            'hadis_description' => [new KurdishChars],
            'hadis_number' => ['required', 'unique:hadis,hadis_number'],
            'hadis_teller_id' => ['required', 'exists:tellers,id'], // TODO: MUST BE NUMBER
            'buxari_chapter_ids' => [$atLeastOne, 'array', 'exists:buxari_chapters,id'],
            'muslim_chapter_ids' => [$atLeastOne, 'array', 'exists:muslim_chapters,id'],
            'hadis_category_ids' => ['array', 'exists:categories,id']

        ]);


        if ($validator->fails()) return Response(['errors' => $validator->errors()->all()]);


        $newHadis = Hadis::create([
            'arabic' => $request->get('hadis_arabic'),
            'kurdish' => $request->get('hadis_kurdish'),
            'description' => $request->get('hadis_description'),
            'hadis_number' => $request->get('hadis_number'),
            'teller_id' => $request->get('hadis_teller_id'),
            "arabic_search" => preg_replace('/\p{M}/u', '', $request->get('hadis_arabic'))
//            'buxari_chapter_id' => $request->get('buxari_chapter_id'),
//            'muslim_chapter_id' => $request->get('muslim_chapter_id'),
//            'category_id' => $request->get('hadis_category_id')
        ]);

        $newHadis->buxariChapters()->attach($request->get('buxari_chapter_ids'));

        $newHadis->categories()->attach($request->get('hadis_category_ids'));


        return ['success' => "Hadis added successfully", 'hadis' => $newHadis];

    }
}
