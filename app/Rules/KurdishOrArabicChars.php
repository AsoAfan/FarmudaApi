<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KurdishOrArabicChars implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
//        $is = preg_match('/[\p{Arabic}\s/^[ئاأبپتثجچحخدرڕزژسشعغفڤقكگلڵمنهیوۆؤێەۍەو]/]/', $value)
        if (!preg_match('/^[\p{Arabic}\sئابپتجچحخدرڕزژسشعغفڤقكگلڵمنهیوۆێەۍەو]+$/u', $value))
            $fail(":attribute must be kurdish or arabic");
    }
}
