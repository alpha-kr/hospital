<?php

namespace Database\Factories;

use Domain\Assignments\Models\Diagnose;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnose>
 */
class DiagnoseFactory extends Factory
{
    protected $model = Diagnose::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text(),
        ];
    }
}
