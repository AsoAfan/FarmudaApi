<?php

namespace Database\Factories;

use App\Models\Hadith;
use App\Models\Teller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hadith>
 */
class HadithFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'arabic' => $this->faker->paragraph,
            'kurdish' => $this->faker->paragraph,
            'description' => $this->faker->paragraph,
            'arabic_search' => $this->faker->paragraph,
            'hadith_number' => $this->faker->numerify,
            'teller_id' => Teller::factory()->create()
        ];
    }
}
