<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KurdishChars implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if (!preg_match('/[\x{0621}-\x{06FF}\x{0750}-\x{077F}\x{08A0}-\x{08FF}]/u', $value) || preg_match('/[a-zA-Z]/', $value))
            $fail($attribute . " must be Kurdish");
    }
}
