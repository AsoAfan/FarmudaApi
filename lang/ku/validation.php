<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute دامەزراوەی تایبەتە',
    'accepted_if' => ':attribute پێویستە دامەزراوەی بە کردنەوەی :other بە :value بێت',
    'active_url' => ':attribute پێویستە بەستەرێکی ڕاست بێت',
    'after' => ':attribute پێویستە واژۆی داتای بەتاچیتەی :date بێت',
    'after_or_equal' => ':attribute پێویستە واژۆی داتای بەتاچیتەی :date بەبێت یان بەتاچیتەی هەمان :date',
    'alpha' => ':attribute پێویستە تەنیا پیتەیەک بەشی هیچ پیتەیەکی دیکە بێت',
    'alpha_dash' => ':attribute پێویستە تەنیا پیتەیەک بەشی وشە، ژمارە، خشتە و ئوندەرلاین بێت',
    'alpha_num' => ':attribute پێویستە تەنیا پیتەیەک بەشی وشە و ژمارە بێت',
    'array' => ':attribute پێویستە وێنەیه‌ک بێت',
    'ascii' => ':attribute پێویستە تەنیا تایبەتەکانی پیتەیەکی ئەندامی ناوخواندنی نووی هیچ پیتەیەکی دیکە بێت',
    'before' => ':attribute پێویستە واژۆی داتای پێش :date بێت',
    'before_or_equal' => ':attribute پێویستە واژۆی داتای پێش :date بێت یان بەتاچیتەی هەمان :date',
    'between' => [
        'array' => ':attribute پێویستە بەینی :min و :max ڕزگاری هەبێت',
        'file' => ':attribute پێویستە بەینی :min و :max کیلۆبایت بێت',
        'numeric' => ':attribute پێویستە بەینی :min و :max ژمارە هەبێت',
        'string' => ':attribute پێویستە بەینی :min و :max پیتە هەبێت',
    ],
    'boolean' => ':attribute پێویستە بیت واژۆی ڕاست یان ڕووداو بێت',
    'can' => ':attribute نرخی ناسنامەکان دیاری بکە',
    'confirmed' => ':attribute پشتڕاستی هاوشێوە نیشان نادراو',
    'current_password' => 'وشەی تێپەڕەوشە نادروستە',
    'date' => ':attribute پێویستە واژۆی داتا بێت',
    'date_equals' => ':attribute پێویستە واژۆی داتای بەراوردی بە :date بێت',
    'date_format' => ':attribute پێویستە واژۆی داتا بە فۆرماتی :format بێت',
    'decimal' => ':attribute پێویستە واژۆی دیسمالێکی بەرزی بێت',
    'declined' => ':attribute پێویستە ناپشتڕا بێت',
    'declined_if' => ':attribute پێویستە ناپشتڕا بێت کاتێک :other بە :value بێت',
    'different' => ':attribute و :other پێویستە جیاواز بێن',
    'digits' => ':attribute پێویستە :digits ژمارە هەبێت',
    'digits_between' => ':attribute پێویستە بەینی :min و :max ژمارە هەبێت',
    'dimensions' => ':attribute دامەزراوەی بەرز و بەرزی وێنە هەیە',
    'distinct' => ':attribute پێویستە نرخی کۆپییەکی بێت',
    'doesnt_end_with' => ':attribute پێویستە دووگمەی نادروست بێت: :values',
    'doesnt_start_with' => ':attribute پێویستە دووگمەی نادروست بێت: :values',
    'email' => ':attribute پێویستە واژۆی ئیمەیلێکی ڕاست بێت',
    'ends_with' => ':attribute پێویستە لە پایان بە :values بێت',
    'enum' => ':attribute دیاریکراوە گونجاو نییە',
    'exists' => ':attribute دیاریکراوە ناسنامەییە',
    'file' => ':attribute پێویستە واژۆی فایلێکی بێت',
    'filled' => ':attribute پێویستە دانەدانی بەرز هەبێت',
    'gt' => [
        'array' => ':attribute پێویستە زیاتر لە :value چاوەڕێیەک هەبێت',
        'file' => ':attribute پێویستە زیاتر لە :value کیلۆبایت هەبێت',
        'numeric' => ':attribute پێویستە زیاتر لە :value ژمارە هەبێت',
        'string' => ':attribute پێویستە زیاتر لە :value پیتە هەبێت',
    ],
    'gte' => [
        'array' => ':attribute پێویستە :value چاوەڕێیەک هەبێت یان زیاتر',
        'file' => ':attribute پێویستە :value کیلۆبایت هەبێت یان بەبێت',
        'numeric' => ':attribute پێویستە :value ژمارە هەبێت یان بەبێت',
        'string' => ':attribute پێویستە :value پیتە هەبێت یان بەبێت',
    ],
    'image' => ':attribute پێویستە واژۆی وێنە بێت',
    'in' => ':attribute دیاریکراوە گونجاو نییە',
    'in_array' => ':attribute پێویستە لە خشتەی :other هەبێت',
    'integer' => ':attribute پێویستە واژۆی ژمارەیی بێت',
    'ip' => ':attribute پێویستە واژۆی ئایپی ڕاست بێت',
    'ipv4' => ':attribute پێویستە واژۆی ئایپی ڕاستی IPv4 بێت',
    'ipv6' => ':attribute پێویستە واژۆی ئایپی ڕاستی IPv6 بێت',
    'json' => ':attribute پێویستە واژۆی جەی‌سوون بێت',
    'lowercase' => ':attribute پێویستە واژۆی کچی بێت',
    'lt' => [
        'array' => ':attribute پێویستە کەمتر لە :value چاوەڕێیەک هەبێت',
        'file' => ':attribute پێویستە کەمتر لە :value کیلۆبایت هەبێت',
        'numeric' => ':attribute پێویستە کەمتر لە :value ژمارە هەبێت',
        'string' => ':attribute پێویستە کەمتر لە :value پیتە هەبێت',
    ],
    'lte' => [
        'array' => ':attribute پێویستە زیاتر لە :value چاوەڕێیەک هەبێت یان کەمتر',
        'file' => ':attribute پێویستە زیاتر لە :value کیلۆبایت هەبێت یان کەمتر',
        'numeric' => ':attribute پێویستە زیاتر لە :value ژمارە هەبێت یان کەمتر',
        'string' => ':attribute پێویستە زیاتر لە :value پیتە هەبێت یان کەمتر',
    ],
    'mac_address' => ':attribute پێویستە واژۆی MAC ڕاست بێت',
    'max' => [
        'array' => ':attribute پێویستە کەمتر لە :max چاوەڕێیەک هەبێت',
        'file' => ':attribute پێویستە کەمتر لە :max کیلۆبایت هەبێت',
        'numeric' => ':attribute پێویستە کەمتر لە :max ژمارە هەبێت',
        'string' => ':attribute پێویستە کەمتر لە :max پیتە هەبێت',
    ],
    'max_digits' => ':attribute پێویستە کەمتر لە :max ژمارەی دیاریکراو هەبێت',
    'mimes' => ':attribute پێویستە واژۆی فایلی جۆری :values بێت',
    'mimetypes' => ':attribute پێویستە واژۆی فایلی جۆری :values بێت',
    'min' => [
        'array' => ':attribute پێویستە کەمتر لە :min چاوەڕێیەک هەبێت',
        'file' => ':attribute پێویستە کەمتر لە :min کیلۆبایت هەبێت',
        'numeric' => ':attribute پێویستە کەمتر لە :min ژمارە هەبێت',
        'string' => ':attribute پێویستە کەمتر لە :min پیتە هەبێت',
    ],
    'min_digits' => ':attribute پێویستە کەمتر لە :min ژمارەی دیاریکراو هەبێت',
    'missing' => ':attribute پێویستە بەتاچیتەی ناپێکهەر بێت',
    'missing_if' => ':attribute پێویستە بەتاچیتەی ناپێکهەر بێت کاتێک :other بە :value بێت',
    'missing_unless' => ':attribute پێویستە بەتاچیتەی ناپێکهەر بێت هەروەها :other بە :value بێت',
    'missing_with' => ':attribute پێویستە بەتاچیتەی ناپێکهەر بێت کاتێک :values لێدەبێت',
    'missing_with_all' => ':attribute پێویستە بەتاچیتەی ناپێکهەر بێت کاتێک :values لێدەبێت',
    'multiple_of' => ':attribute پێویستە واژۆی چاوەڕێیی لەسەر :value بێت',
    'not_in' => ':attribute دیاریکراوە ناسنامەییە',
    'not_regex' => 'فۆرماتی :attribute نادروستە',
    'numeric' => ':attribute پێویستە واژۆی ژمارەیی بێت',
    'password' => [
        'letters' => ':attribute پێویستە هەیەک پیتەیەکی تایبەتی هەبێت',
        'mixed' => ':attribute پێویستە هەیەک پیتەیەکی بەستەر و یەکێک پیتەیەکی کچی هەبێت',
        'numbers' => ':attribute پێویستە هەیەک پیتەیەکی ژمارە هەبێت',
        'symbols' => ':attribute پێویستە هەیەک پیتەیەکی نموونە هەبێت',
        'uncompromised' => ':attribute ناسنامەکانی نرخی دیاریکراو لە زانیارییەکی هەناسراو بەنرخی تایبەتی بکە. تکایە نرخی تایبەتی دیکە دیاری بکە.',
    ],
    'present' => ':attribute پێویستە واژۆی حاضر بێت',
    'prohibited' => ':attribute نادروستی دەکرێت',
    'prohibited_if' => ':attribute نادروستی دەکرێت کاتێک :other بە :value بێت',
    'prohibited_unless' => ':attribute نادروستی دەکرێت هەروەها :other بە :value بێت',
    'prohibits' => ':attribute نادروستی :other دەکرێت کاتێک :values حاضر بێن',
    'regex' => 'فۆرماتی :attribute نادروستە',
    'required' => ':attribute پێویستە',
    'required_array_keys' => ':attribute پێویستە هاوپێچەیەکانی خشتەی :values بێت',
    'required_if' => ':attribute پێویستە کاتێک :other بە :value بێت',
    'required_if_accepted' => ':attribute پێویستە کاتێک :other پەیوەندیدراوە بێت',
    'required_unless' => ':attribute پێویستە هەروەها :other بە :values نەبێت',
    'required_with' => ':attribute پێویستە کاتێک :values حاضر بێت',
    'required_with_all' => ':attribute پێویستە کاتێک هەروەها :values حاضر بێت',
    'required_without' => ':attribute پێویستە کاتێک :values نەبێت',
    'required_without_all' => ':attribute پێویستە کاتێک هەروەها :values نەبێت',
    'same' => ':attribute پێویستە هاوشێوە بێت لە :other',
    'size' => [
        'array' => ':attribute پێویستە واژۆی :size ئاوەرەکانی بێت',
        'file' => ':attribute پێویستە واژۆی :size کیلۆبایت بێت',
        'numeric' => ':attribute پێویستە واژۆی :size ژمارە بێت',
        'string' => ':attribute پێویستە واژۆی :size پیتە بێت',
    ],
    'starts_with' => ':attribute پێویستە لەسەر :values دەستپێکرێت',
    'string' => ':attribute پێویستە واژۆی پیتە بێت',
    'timezone' => ':attribute پێویستە واژۆی ناوخۆیی ڕاست بێت',
    'unique' => ':attribute پێویستە پێشتر بەکارهێناوە',
    'uploaded' => ':attribute نەگۆڕی کردنەوە ناکرا',
    'uppercase' => ':attribute پێویستە واژۆی بزووتن بێت',
    'url' => ':attribute پێویستە واژۆی بەستەری ڕاست بێت',
    'ulid' => ':attribute پێویستە واژۆی ULID بێت',
    'uuid' => ':attribute پێویستە واژۆی UUID بێت',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'email' => "ئیمەیڵ",
        'password' => "وشەی نهێنی"
    ],

];
