<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\BuxariChapter;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Hadis;
use App\Models\Teller;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create();

         Book::factory(5)->create();

         Chapter::factory(5)->create();
        Category::factory(5)->create();


       Teller::factory(5)->create();



        Hadis::factory(25)->create();



        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
