<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SlugValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if (!(preg_match('/^[a-z0-9\-_]+$/', $value))) {
            $fail("inputted :attribute format is not valid for a slug");
        }
    }
}
