<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use App\Services\PaginationService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HadithController extends Controller
{


    public function index(PaginationService $paginator)
    {

        return $paginator->paginate(
            Hadith::query(),
            ['teller', 'categories', 'chapters']
        );
    }


    public function search()
    {
        $validator = Validator::make(request()->all(), [
            "teller" => "numeric",
            'category' => 'array',
            'book' => 'array',
            'chapter' => 'array',
            'hukim' => 'string'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all(), "code" => 422], 422);

//        dd(array_filter(request(["search", 'teller', 'category', 'book', 'chapter',]),
//            fn($value) => $value !== [null]));

        $search_items = array_filter(
            request(['lang', 'search', 'hukim', 'teller', 'category', 'book', 'chapter']),
            fn($value) => $value !== [null]);

        if (!$search_items) return [];

        return HadFith::query()
            ->filter(
                array_filter(
                    request(['lang', 's', 'hukim', 'teller', 'category', 'book', 'chapter']),
                    fn($value) => $value !== [null])
            )
            ->take(25)
            ->with(['teller', 'categories', 'chapters.books'])
            ->get();
        // TODO: Double check for skipping algorithm => DONE

//        $validator = Validator::make(request()->all(), [
//            // Validation if needed for incoming filters
//        ]);
//        return hadith::all();

    }

    public function latest()
    {

        return Hadith::query()
            ->latest()
            ->take(2)
            ->with(['teller', 'categories', 'chapters'])
            ->get();
    } // DONE

    public function show(string $id)
    {

        return Hadith::where("id", $id)->with(["teller", "chapters.books", "categories"])->first();

    } // DONE

    public function count()
    {
        return Hadith::count();
    }

    public function showFeatures()
    {

//        return hadith::whereRaw("char_length(arabic) < " . request('chars'))->get()->take($num);

        return Hadith::where('is_featured', 1)
            ->get(["arabic", "kurdish"]);
//        ->whereRaw('char_length(arabic) <= ' . 50)

    } // DONE

    public function toggleFeature(Hadith $hadith)
    {
        if ($this->showFeatures()->count() > 15)
            return response([
                'message' => "maximum featured hadiths exceed",
                'code' => 400
            ], 400);
        $is_featured = $hadith->is_featured;
        // CHeck again why I did that: using additional variable for $hadith->is_featured in line 84


        $validator = Validator::make($hadith->attributesToArray(), [
            'arabic' => ['string', 'max:50']
        ]);

        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 400);

        $hadith->update(['is_featured' => !$is_featured]);

        return ['success' => $hadith->arabic . (!$is_featured ? " added to featured list" : " removed from featured list")];
    } // DONE


    public function update(Hadith $hadith, Request $request)
    {
        /**
         * not sure if checking the role again rather than it was checked with middleware is necessary, remove for now
         * @TODO  Gate::authorize('update', $hadith);
         */

        $validator = Validator::make($request->all(), [ // TODO: Separate into a new Request class
            'arabic' => ['required_without_all:kurdish,description,hadith_number,hadith_teller_id,category_ids, book_ids, chapter_ids', "unique:hadiths,arabic,$hadith->id", new ArabicChars],
            'kurdish' => ['required_without_all:arabic,description,hadith_number,hadith_teller_id,category_ids, book_ids, chapter_ids', new KurdishChars],
            'badiny' => ['required_without_all:arabic,kurdish,description,hadith_number,hadith_teller_id,category_ids, book_ids, chapter_ids', new KurdishChars],
            'hawramy' => ['required_without_all:arabic,kurdish,badiny,description,hadith_number,hadith_teller_id,category_ids, book_ids, chapter_ids', new KurdishChars],
            'description' => ['required_without_all:arabic,kurdish,hadith_number,hadith_teller_id,category_ids, book_ids, chapter_ids', new KurdishChars],
            'number' => ['required_without_all:arabic,kurdish,description,hadith_teller_id,category_ids, book_ids, chapter_ids', "unique:hadiths,hadith_number,{$hadith->id}", 'numeric'],
            'teller_id' => ['required_without_all:arabic,kurdish,description,hadith_number,category_ids,book_ids,chapter_ids', 'numeric', 'exists:tellers,id'],

            'category_ids' => ['array', 'exists:categories,id', 'required_without_all:arabic,kurdish,description,hadith_number,hadith_teller_id,book_ids,chapter_ids'],
            'book_ids' => ['array', 'exists:books,id', 'required_without_all:arabic,kurdish,description,hadith_number,hadith_teller_id, category_ids, chapter_ids'],
            'chapter_ids' => ['array', 'exists:chapters,id', 'required_without_all:arabic,kurdish,description,hadith_number,hadith_teller_id, category_ids, book_ids']
        ]);

        if ($validator->fails()) {

            if (key_exists('hadith_number', $validator->errors()->messages()) && $request->get('hadith_number') != $hadith->hadith_number) {
                $duplicated_hadith_number = $request->get('hadith_number');
                $hadith_with_hadith_number = Hadith::where('hadith_number', $duplicated_hadith_number)->first();
                return response()
                    ->json(
                        [
                            'errors' => "hadith number: {$duplicated_hadith_number} is already assigned to another hadith",
                            'data' => $hadith_with_hadith_number?->id
                        ],
                        400
                    );
            }


            return response()->json(['errors' => $validator->errors()->all()], 400);
        }

        $hadith->update(
            [
                "arabic" => $request->get('arabic') ?? $hadith->arabic,
                "kurdish" => $request->get('kurdish') ?? $hadith->kurdish,
                "description" => $request->get("description") ?? $hadith->description,
                "hadith_number" => $request->get('number') ?? $hadith->hadith_number,
                "teller_id" => $request->get('teller_id') ?? $hadith->teller_id,
                "arabic_search" => preg_replace('/\p{M}/u', '', $request->get('arabic') ?? $hadith->arabic)

            ]);


        $hadith->categories()->syncWithoutDetaching($request->get('category_ids') ?? $hadith->categories->pluck('id')->toArray());
        $hadith->books()->syncWithoutDetaching($request->get('book_ids') ?? $hadith->books->pluck('id')->toArray());
        $hadith->chapters()->syncWithoutDetaching($request->get('chapter_ids') ?? $hadith->chapters->pluck('id')->toArray());


        return ["success" => "hadith updated successfully", "data" => $hadith->fresh()];
    } // DONE

    public function store(Request $request)
    {
        /**
         * not sure if checking the role again rather than it was checked with middleware is necessary, remove for now
         * @TODO  Gate::authorize('create');
         */


        $validator = Validator::make($request->all(), [
            'arabic' => ['unique:hadiths,arabic', 'required', new ArabicChars],
            'kurdish' => ['required', new ArabicChars],
            'badiny' => ['nullable', new ArabicChars],
            'hawramy' => ['nullable', new ArabicChars],
            'description' => ['nullable', new ArabicChars],
            'number' => ['required', 'numeric', 'unique:hadiths,hadith_number'],
            'teller_id' => ['required', 'numeric', 'exists:tellers,id'],

            'category_ids' => ['array', 'exists:categories,id'],
//            'book_ids' => ['array', 'exists:books,id'], // TODO: Check this remove if possible, get books of the hadith from associated chapter
            'chapter_ids' => ['required', 'array', 'exists:chapters,id']

        ]);


        if ($validator->fails()) {
            if (array_key_exists('hadith_number', $validator->errors()->messages())) {
                $duplicated_hadith = Hadith::where('hadith_number', $request->get('hadith_number'))->first();
                return response()->json([
                    "errors" => 'hadith number: ' . $request->get('hadith_number') . ' is already assigned to another hadith',
                    'duplicated_hadith_id' => $duplicated_hadith?->id,
                ], 400);
            }
            return response()->json(["errors" => $validator->errors()->all()], 422);
        }

        $newHadith = Hadith::create([
            'arabic' => $request->get('arabic'),
            'kurdish' => $request->get('kurdish'),
            "badiny" => $request->get('badiny'),
            "hawramy" => $request->get('hawramy'),
            'description' => $request->get('description'),
            'hadith_number' => $request->get('number'),
            'teller_id' => $request->get('teller_id'),

            "arabic_search" => preg_replace('/\p{M}/u', '', $request->get('arabic'))
        ]);

        $newHadith->books()->attach($request->get('hadith_book_ids'));
        $newHadith->chapters()->attach($request->get('hadith_chapter_ids'));
        $newHadith->categories()->attach($request->get('hadith_category_ids'));


        return ['success' => "hadith added successfully", 'data' => $newHadith];

    }

    public function destroyRelated(Hadith $hadith, Request $request): Application|Response|ResponseFactory
    {

        $validator = Validator::make($request->all(), [
            'category_ids' => ["array", "exists:categories,id"],
            'book_ids' => ["array", "exists:books,id"],
            'chapter_ids' => ["array", "exists:chapters,id"]
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all(), 'status' => 400], 406);

        $hadith->categories()->detach($request->get('category_ids') ?? []);
        $hadith->books()->detach($request->get('book_ids') ?? []);
        $hadith->chapters()->detach($request->get('chapter_ids') ?? []);

        return response(['success' => "Operation done successfully"]);


    }

    public function destroy(Hadith $hadith)
    {
        $delete = $hadith->delete();
        if (!$delete) return response(['errors' => 'Deleting hadith failed successfully'], 400);
        return ["success" => Str::take($hadith->arabic, 10) . "... deleted successfully", 'data' => $hadith->id];
    }

    public function forceDestroy(Hadith $hadith)
    {

        if (!$hadith->deleted_at) return $this->destroy($hadith);
        $isDeleted = $hadith->forceDelete();
        if ($isDeleted) return ['success' => Str::substr($hadith->arabic, 0, 10) . " deleted permanently "];
        else return \response(['errors' => "an error occurred while deleting hadith permanently", 'status' => request()
            ->status()], 400);

    }


}
