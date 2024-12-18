<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paid = $this->faker->boolean();

        return [
            'user_id' => User::all()->random()->id,
            'type'=>$this->faker->randomElement(['b', 'c', 'p']),
            'paid'=>$paid,
            'value'=>$this->faker->numberBetween(100,99999),
            'payment_date'=>$paid ? $this->faker->randomElement([$this->faker->dateTimeThisMonth()]) : NULL,
        ];
    }
}
