<?php

namespace App\Http\Controllers;

use App\Models\Hadis;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HadisController extends Controller
{


    public function index()
    {

        $validator = Validator::make(request()->all(), [
            // Validation if needed for incoming filters
        ]);
        return Hadis::all()->skip(5)->take(10);

    }

    public function latest()
    {
        return Hadis::latest()->get()->take('2');
    }

    public function show(Hadis $hadis)
    {

        return $hadis;

    }

    public function showShorts()
    {

//        return Hadis::whereRaw("char_length(arabic) < " . request('chars'))->get()->take($num);

        return Hadis::where('is_featured', 1)->whereRaw('char_length(arabic) <= ' . (request('chars') ?? 80))->get();
    }

    public function toggleFeature(Hadis $hadis)
    {
        $is_featured = $hadis->is_featured;


        $validator = Validator::make($hadis->attributesToArray(), [
            'arabic' => ['string', 'max:80']
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()]);

        $hadis->update(['is_featured' => !$is_featured]);

        return ['success' => $hadis->arabic . (!$is_featured ? " will be shown soon" : " won't be shown anymore")];
    }

    public function update(Hadis $hadis, Request $request)
    {
        $validator = Validator::make($request->all(), [ // TODO: Separate into a new Request class
            'hadis_arabic' => ['required_without_all:kurdish,description,hadis_number,hadis_teller_id,category_ids, book_ids, chapter_ids', "unique:hadis,arabic,{$hadis->id}", new ArabicChars],
            'hadis_kurdish' => ['required_without_all:arabic,description,hadis_number,hadis_teller_id,category_ids, book_ids, chapter_ids', "unique:hadis,kurdish,{$hadis->id}", new KurdishChars],
            'hadis_description' => ['required_without_all:arabic,kurdish,hadis_number,hadis_teller_id,category_ids, book_ids, chapter_ids', new KurdishChars],
            'hadis_number' => ['required_without_all:arabic,kurdish,description,hadis_teller_id,category_ids, book_ids, chapter_ids', "unique:hadis,hadis_number,{$hadis->id}", 'numeric'],
            'hadis_teller_id' => ['required_without_all:arabic,kurdish,description,hadis_number,category_ids,book_ids,chapter_ids', 'numeric', 'exists:tellers,id'],

            'category_ids' => ['array', 'exists:categories,id', 'required_without_all:arabic,kurdish,description,hadis_number,hadis_teller_id,book_ids,chapter_ids'],
            'book_ids' => ['array', 'exists:books,id', 'required_without_all:arabic,kurdish,description,hadis_number,hadis_teller_id, category_ids, chapter_ids'],
            'chapter_ids' => ['array', 'exists:chapters,id', 'required_without_all:arabic,kurdish,description,hadis_number,hadis_teller_id, category_ids, book_ids']
        ]);

        if ($validator->fails()) {

            if (key_exists('hadis_number', $validator->errors()->messages()) && $request->get('hadis_number') != $hadis->hadis_number) {
                $duplicated_hadis_number = $request->get('hadis_number');
                $hadis_with_hadis_number = Hadis::where('hadis_number', $duplicated_hadis_number)->first();
                return response()
                    ->json(
                        [
                            'errors' => "Hadis number: {$duplicated_hadis_number} is already assigned to another hadis",
                            'duplicated_hadis_id' => $hadis_with_hadis_number?->id
                        ],
                        422
                    );
            }


            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        $hadis->update(
            [
                "arabic" => $request->get('hadis_arabic') ?? $hadis->arabic,
                "kurdish" => $request->get('hadis_kurdish') ?? $hadis->kurdish,
                "description" => $request->get("hadis_description") ?? $hadis->description,
                "hadis_number" => $request->get('hadis_number') ?? $hadis->hadis_number,
                "teller_id" => $request->get('hadis_teller_id') ?? $hadis->teller_id,
                "arabic_search" => preg_replace('/\p{M}/u', '', $request->get('hadis_arabic'))

            ]);

        $hadis->categories()->syncWithoutDetaching($request->get('category_ids') ?? $hadis->categories->pluck('id')->toArray());
        $hadis->books()->syncWithoutDetaching($request->get('book_ids') ?? $hadis->books->pluck('id')->toArray());
        $hadis->chapters()->syncWithoutDetaching($request->get('chapter_ids') ?? $hadis->chapters->pluck('id')->toArray());


        return ["success" => "Hadis updated successfully", "updatedHadis" => $hadis];
    }

    public function store(Request $request)
    {
        $atLeastOne = (!$request->get('muslim_chapter_ids') && !$request->get('buxari_chapter_ids') ? 'required' : '');

        $validator = Validator::make($request->all(), [
            'hadis_arabic' => ['unique:hadis,arabic', 'required', new ArabicChars],
            'hadis_kurdish' => ['unique:hadis,kurdish', 'required', new KurdishChars],
            'hadis_description' => [new KurdishChars],
            'hadis_number' => ['required', 'unique:hadis,hadis_number', 'numeric'],
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


        return ['success' => "Hadis added successfully", 'newHadis' => $newHadis];

    }

    public function destroyRelated(Hadis $hadis, Request $request)
    {
//        dd($request->all(),$hadis);

        $hadis->categories()->detach($request->get('category_id') ?? []);
        $hadis->books()->detach($request->get('book_id') ?? []);
        $hadis->chapters()->detach($request->get('chapter_id') ?? []);

//        if ($request->has('category_id'))
//            $hadis->categories()->detach($request->get('category_id'));
//
//        if ($request->has('book_id'))
//            $hadis->books()->detach($request->get('book_id'));
//
//        if ($request->has('chapter_id'))
//            $hadis->chapters()->detach($request->get('chapter_id'));


    }

    public function destroy(Hadis $hadis)
    {
        $hadis->delete();
        return ["success" => "$hadis->arabic deleted successfully"];
    }
}
