<?php

namespace App\Http\Controllers;

use App\Models\Hadith;
use App\Services\PaginationService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FavouriteController extends Controller
{


    /*    function temp()
        {
            $filename = "Laravel API Server Full Course - Beginner to Intermediate.mp4";
            $file = Storage::path($filename);

            if (!Storage::exists($filename)) {
                return "File not found";
            }

            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            return response()->download($file, $filename, $headers);
        }*/

    public function index(PaginationService $paginator)
    {


        return $paginator->paginate(
            auth()->user()->hadiths(),
            with(['teller', 'categories', 'chapters'])
        );

    }

    public function search()
    {


        return auth()->user()->hadiths()
            ->filter(
                array_filter(
                    request(['lang', 'search', 'hukim', 'teller', 'category', 'book', 'chapter']),
                    fn($value) => $value !== [null])
            )
            ->take(25)
            ->with(['teller', 'categories', 'chapters'])->get();

    }

    public function store(Hadith $hadith)
    {
        try {
            auth()->user()->hadiths()->syncWithoutDetaching($hadith);


            return response()->json([
                'success' => "فەرموودەکە بۆ بەشی دڵخوازت زیادکرا",
                'data' => $hadith->id
            ]);
        } catch (QueryException) {

            return response(['errors' => "Bad request", 'status' => 400], 400);

        }

    }

    public function destroy(Hadith $hadith)
    {
        try {

            auth()->user()->hadiths()->detach($hadith);

            return response()->json([
                'success' => "فەرموودەکە لە بەشی دڵخوازت سڕایەوە",
                'data' => $hadith->id
            ]);

        } catch (Exception) {
            return response(['errors' => "Bad request", 'status' => 400], 400);
        }


    }


}
