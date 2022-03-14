<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = rand(1, 3);
        return [
            "unique_id" => generateNewUniqueId(),
            "user_unique_id" => User::inRandomOrder()->first()->unique_id,
            "operator" => $type,
            "recipient_number" => generatePhoneNumber($type),
            "type" =>rand(1,2),
            "amount" => random_int(10000, 1000000),
            "added_at" => $this->faker->date(),
            "time" => $this->faker->time(),
        ];
    }
}
