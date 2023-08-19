<?php

namespace App\Http\Requests;

use App\Rules\KurdishOrArabicChars;
use Illuminate\Foundation\Http\FormRequest;

class QuestionStoreRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->id() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'min:10', new KurdishOrArabicChars]
        ];
    }

    public function messages(): array
    {
        return [
            'body.required' => 'The body field is required.',
            'body.min' => 'The body must be at least :min characters.',
            'body' => 'The body must contain either Kurdish or Arabic characters.',
        ];
    }
}
