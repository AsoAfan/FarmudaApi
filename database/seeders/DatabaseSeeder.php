<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\BuxariChapter;
use App\Models\Category;
use App\Models\Hadis;
use App\Models\Teller;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Category::create([
            'name' => "Kind",
            'slug' => 'c'
        ]);



        Teller::create([
            'name' => 'ابو هريرة',
            'slug' => 'a'


        ]);

        Hadis::create([
            'arabic' => "رَحِمَ اللهُ مَنْ سَمِعَ مِنِّي حَديثاً ، فَبَلَّغَهُ كَمَا سَمِعَهُ",
            'kurdish' => "ڕەحمەتی خوا لەو کەسە بێ , کە فەرموودەیەک لە من دەبیستێ , وە دەیگەیەنێ وەک چۆن بیستوویەتی.",
            'hadis_number' => 1,
            'teller_id' => 1,
            'arabic_search' => preg_replace('/\p{M}/u', '', 'رَحِمَ اللهُ مَنْ سَمِعَ مِنِّي حَديثاً ، فَبَلَّغَهُ كَمَا سَمِعَهُ')

        ]);


        Book::create([
            'name' => "Buxari",
            'slug' => "buxary"
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
