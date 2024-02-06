<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use app\Models\Publication;
use Faker\Generator;

class PublicationFactory extends Factory
{
    protected $model = Publication::class;

    public function definition()
    {
        return [
            'titulo' => $this->faker->sentence(),
            'descripcion' => $this->faker->realtext(255),
            'beneficios' => $this->faker->realtext(255),
            'procedimiento' => $this->faker->realtext(255),
        ];
    }
}
