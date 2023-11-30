<?php

namespace Database\Factories;

use App\Models\UserMeta;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserMetaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserMeta::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'rt' => $this->faker->text(255),
            'rw' => $this->faker->text(255),
            'longlat' => $this->faker->text(255),
            'province_id' => $this->faker->text(255),
            'province_name' => $this->faker->text(255),
            'regencies_id' => $this->faker->text(255),
            'regencies_name' => $this->faker->text(255),
            'district_id' => $this->faker->text(255),
            'district_name' => $this->faker->text(255),
            'ward_id' => $this->faker->text(255),
            'ward_name' => $this->faker->text(255),
            'status' => $this->faker->word(),
            'package_id' => \App\Models\Package::factory(),
        ];
    }
}
