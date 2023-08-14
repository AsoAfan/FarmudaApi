<?php

namespace App\Http\Requests;

use App\Models\Category;
use App\Rules\KurdishChars;
use App\Rules\SlugExists;
use App\Rules\SlugValidator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;

class NameSlugRequestValidator extends FormRequest
{


//    protected $stopOnFirstFailure = true;


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)

    {


        throw new HttpResponseException(response()->json([

            'errors' => $validator->errors()->all()
        ]));

    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $categorySlug = Route::current()->parameter('slug');

        $category = Category::where('slug', $categorySlug)->first();

        if (!$category) {
            return [""];
        }



        return [
            'name' => ['required_without:slug', 'unique:categories,name,' . $category->id, new KurdishChars],
            'slug' => ['required_without:name', 'unique:categories,slug,' . $category->id, new SlugValidator]
        ];
    }
}
