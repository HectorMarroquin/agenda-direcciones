<?php

namespace Database\Factories;

use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactoFactory extends Factory
{
    protected $model = Contacto::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->name,
            'user_id' => 1, // Siempre el user_id 1
        ];
    }
}
