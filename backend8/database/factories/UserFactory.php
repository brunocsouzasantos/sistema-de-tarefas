<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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
            'name' => $this->faker->name,
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$6oRO7.PT3loG7Ppw4KyNS.5iIB26aRnHTEV3FlVB7FfEIGDvxYaTa', // password
            'permissao' => 'ADM',
            'remember_token' => Str::random(10),
        ];
    }
}
