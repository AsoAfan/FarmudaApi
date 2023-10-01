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


        Hadis::factory(25)->create();


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
