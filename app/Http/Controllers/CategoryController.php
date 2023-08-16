<?php

namespace App\Http\Controllers;

use App\Http\Requests\NameSlugRequestValidator;
use App\Models\Category;
use App\Rules\KurdishChars;
use App\Rules\SlugValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

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
    // Deleted


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required_without:slug', 'unique:categories,name,' . $category->id, new KurdishChars],
            'slug' => ['required_without:name', 'unique:categories,slug,' . $category->id, new SlugValidator]
        ]);


        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 422);

        $category->update($request->all());

        return ['success' => "Data updated successfully", "newCategory" => $category]; // TODO: Optimize returned data
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return ["success" => $category->name . " deleted successfully"];

    }
}
