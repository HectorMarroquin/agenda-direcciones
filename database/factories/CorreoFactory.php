<?php

namespace Database\Factories;

use App\Models\Correo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CorreoFactory extends Factory
{
    protected $model = Correo::class;

    public function definition()
    {
        return [
            'correo' => $this->faker->unique()->safeEmail,
            'contacto_id' => function () {
                return \App\Models\Contacto::factory()->create()->id;
            },
        ];
    }
}
