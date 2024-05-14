<?php

namespace Database\Factories;

use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Diagnose;
use Domain\Assignments\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assignment>
 */
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_id' => Patient::factory(),
            'observation' => $this->faker->text(),
            'diagnose_id' => Diagnose::factory(),
            'date' => $this->faker->date(),
        ];
    }
}
