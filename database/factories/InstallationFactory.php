<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Installation;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Installation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->word(),
            'date_install' => $this->faker->dateTime(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
