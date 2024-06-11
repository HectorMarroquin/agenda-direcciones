<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contacto;
use App\Models\Telefono;
use App\Models\Correo;
use App\Models\Direccion;

class ContactosSeeder extends Seeder
{
    public function run()
    {
        // Crear 50 contactos
        $contactos = Contacto::factory()
            ->count(50)
            ->create([
                'user_id' => 1, // Siempre el user_id 1
            ]);

        // Para cada contacto, crear entre 1 y 3 teléfonos, 1 o 2 correos y 1 dirección
        foreach ($contactos as $contacto) {
            Telefono::factory()
                ->count(rand(1, 3))
                ->create([
                    'contacto_id' => $contacto->id,
                ]);

            Correo::factory()
                ->count(rand(1, 2))
                ->create([
                    'contacto_id' => $contacto->id,
                ]);

            Direccion::factory()
                ->create([
                    'contacto_id' => $contacto->id,
                ]);
        }
    }
}
