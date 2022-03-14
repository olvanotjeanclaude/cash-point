<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "unique_id" =>generateNewUniqueId(),
            "status" => 1,
            "permission" => rand(1, 2),

            'name' => $this->faker->name(),
            'surname' => $this->faker->name(),
            "birth_date" => $this->faker->date(),
            "gender" => rand(1, 2),
            'email' => $this->faker->unique()->safeEmail(),
            "phone" => $this->faker->phoneNumber(),

            "orange" => generatePhoneNumber(1),
            "telma" => generatePhoneNumber(2),
            "airtel" => generatePhoneNumber(3),

            "image" => "https://source.unsplash.com/random",

            'password' => Hash::make("123456"), // password

            "description" => $this->faker->text(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
