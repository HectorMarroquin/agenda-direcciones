<?php
namespace Database\Factories;

use App\Models\Direccion;
use Illuminate\Database\Eloquent\Factories\Factory;

class DireccionFactory extends Factory
{
    protected $model = Direccion::class;

    public function definition()
    {
        return [
            'direccion' => $this->faker->address,
            'contacto_id' => function () {
                return \App\Models\Contacto::factory()->create()->id;
            },
        ];
    }
}
