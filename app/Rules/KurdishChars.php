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
        if (!preg_match('/^[ئاأبپتثجچحخدرڕزژسشعغفڤقكگلڵمنهیوۆؤێەۍەو]/u', $value) || preg_match('/[a-zA-Z]/', $value))
            $fail($attribute . " must be Kurdish");
    }
}
