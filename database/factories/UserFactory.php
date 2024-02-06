<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UserFactory extends Factory
{
    
    protected $model = User::class;

    
    public function definition()
    {
        return [
            //'role_id'=>$this->faker->randomElement([1,2,3,4]),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'username' => $this->faker->name(),
            'personal_phone' => '09' . $this->faker->randomNumber(8),
            'home_phone' => '02' . $this->faker->randomNumber(7),
            'address' => $this->faker->streetAddress,
            'password' => Hash::make('secret'),
            'email' => $this->faker->unique()->safeEmail(),
            'birthdate' => $this->faker->dateTimeBetween('-50 years', 'now'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
