<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameSlugRequestValidator;
use App\Models\Category;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use App\Rules\SlugValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Category::with('hadises')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:categories,name', new KurdishChars],
            'slug' => ['required', 'unique:categories,slug', new SlugValidator]
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all()]);

        $newCategory = Category::create([
            'name' => $request->get('name'),
            'slug' => $request->get('slug')
        ]);

        if (!$newCategory) return ['errors' => response()->status()];

        return ["success" => 'Category created successfully', "newCategory" => $newCategory];


    }

    /**
     * Display the specified resource.
     */
//    public function show(string $id)
//    {
//        //
//    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NameSlugRequestValidator $request, string $slug)
    {
        $category = Category::where('slug', $slug)->first();

        if (!$category) {
            return response()->json(['errors' => ["Category not found"]], 404);
        }
//
        $validator = $request->validated();
//        dd($validator);/**/

        $category->update($validator);

        return ['success' => "Data updated successfully", "newCategory" => $category]; // TODO: Optimize returned data
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        //

        $category = Category::where('slug', $slug)->first();

        if (!$category) return response()->json(["errors" => "Category not found"], 404);

        $category->delete();
        return ["success" => $category->name . " deleted successfully"];

    }
}
