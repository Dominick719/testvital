<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Favorite;
use Faker\Generator;

class FavoriteSeeder extends Seeder
{
   
    public function run()
    {
        $faker = app(Generator::class);

        foreach (range(1, 10) as $index) {
            // Asegúrate de que los pares user_id y publicacion_id sean únicos
            do {
                $user_id = $faker->numberBetween($min = 7, $max = 11);
                $publicacion_id = $faker->numberBetween($min = 1, $max = 10);
            } while (Favorite::where('user_id', $user_id)->where('publicacion_id', $publicacion_id)->exists());

            Favorite::create([
                'user_id' => $user_id,
                'publicacion_id' => $publicacion_id,
                'calificacion' =>$faker->numberBetween($min = 1, $max = 5),
                'feedback' => $faker->realtext(255),

            ]);

        }
    }
}
