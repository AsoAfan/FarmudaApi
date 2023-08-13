<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ArabicChars implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //        return preg_match('/\p{Arabic}/u', $value) > 0;
        if (!preg_match('/\p{Arabic}/u', $value) || preg_match('/[a-zA-Z]/', $value) > 0)
            $fail($attribute . ' must be Arabic');
    }


}
