<?php

namespace Database\Factories;

use App\Models\Teller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hadis>
 */
class HadisFactory extends Factory
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
            'hadis_number' => $this->faker->numerify,
            'teller_id' => Teller::factory()->create()
        ];
    }
}
