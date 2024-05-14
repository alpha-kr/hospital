<?php

namespace Database\Factories;

use Domain\Assignments\Enums\PatientGenre;
use Domain\Assignments\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'document' => $this->faker->unique()->randomNumber(8).'',
            'email' => $this->faker->unique()->safeEmail,
            'phone' => substr($this->faker->phoneNumber(), 0, 19),
            'genre' => $this->faker->randomElement(PatientGenre::getValues()),
            'birth_date' => $this->faker->date(),
        ];
    }
}
