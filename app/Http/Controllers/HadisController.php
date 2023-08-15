<?php

namespace App\Http\Controllers;

use App\Models\Hadis;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HadisController extends Controller
{


    public function index()
    {

        $validator = Validator::make(request()->all(), [
            // Validation if needed
        ]);
        return Hadis::with('teller', 'categories', 'books', 'chapters')->filter(request(['search', 'teller', 'category', 'book', 'chapter']))->paginate(3); // TODO: MAKE IT MORE READABLE

    }

    public function showShorts(int $num)
    {

//        return Hadis::whereRaw("char_length(arabic) < " . request('chars'))->get()->take($num);

        return Hadis::where('is_featured', 1)->whereRaw('char_length(arabic) <= ' . (request('chars') ?? 80 ))->get()->take($num);
    }

    public function toggleFeature(Hadis $hadis)
    {
        $is_featured = $hadis->is_featured;

//        dd($hadis->attributesToArray());
        $validator = Validator::make($hadis->attributesToArray(), [
            'arabic' => [ 'string', 'max:80']
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()]);

//        if (!$is_featured ) {
//            if (Str::length($hadis->arabic) > 80) return ["errors" => 'featured Hadises must be less than 80, current:' . Str::length($hadis->arabic)];
//        }

        $hadis->update(['is_featured' => ! $is_featured]);

        return ['success' => $hadis->arabic . (!$is_featured ? " will be shown soon" : " won't be shown anymore")];
    }

    public function latest()
    {
        return Hadis::latest()->get()->take('2');
    }

    public function store(Request $request)
    {
        $atLeastOne = (!$request->get('muslim_chapter_ids') && !$request->get('buxari_chapter_ids') ? 'required' : '');

        $validator = Validator::make($request->all(), [
            'hadis_arabic' => ['unique:hadis,arabic', 'required', new ArabicChars],
            'hadis_kurdish' => ['unique:hadis,kurdish', 'required', new KurdishChars],
            'hadis_description' => [new KurdishChars],
            'hadis_number' => ['required', 'unique:hadis,hadis_number'],
            'hadis_teller_id' => ['required', 'numeric', 'exists:tellers,id'],

            'category_ids' => ['array', 'exists:categories,id'],
            'book_ids' => ['array', 'exists:books,id'],
            'chapter_ids' => ['array', 'exists:chapters,id']

        ]);


        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()], 422);


        $newHadis = Hadis::create([
            'arabic' => $request->get('hadis_arabic'),
            'kurdish' => $request->get('hadis_kurdish'),
            'description' => $request->get('hadis_description'),
            'hadis_number' => $request->get('hadis_number'),
            'teller_id' => $request->get('hadis_teller_id'),

            "arabic_search" => preg_replace('/\p{M}/u', '', $request->get('hadis_arabic'))
        ]);

        $newHadis->books()->attach($request->get('book_ids'));
        $newHadis->chapters()->attach($request->get('chapter_ids'));
        $newHadis->categories()->attach($request->get('hadis_category_ids'));


        return ['success' => "Hadis added successfully", 'hadis' => $newHadis];

    }

    public function update(Hadis $hadis)
    {

    }

    public function destroy(Hadis $hadis)
    {
        $hadis->delete();
        return ["success" => "$hadis->name deleted successfully"];
    }
}
