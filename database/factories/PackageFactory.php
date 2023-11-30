<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Package::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->text(255),
            'month' => $this->faker->text(255),
            'speed' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
        ];
    }
}
