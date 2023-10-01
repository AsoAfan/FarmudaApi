<?php

return [
    "max_otp_attempts" => env('OTP_MAX_ATTEMPTS', 3),
    "otp_expiry_minutes" => env('OTP_EXPIRY_MINUTES', 5),

    "featured_max_length" => 50

];