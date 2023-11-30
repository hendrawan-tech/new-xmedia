<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->text(255),
            'invoice_url' => $this->faker->text(255),
            'price' => $this->faker->text(255),
            'status' => $this->faker->word(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
