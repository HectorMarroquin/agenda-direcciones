<?php

namespace App\Http\Controllers;

use App\Models\Telefono;
use App\Models\Contacto;
use Illuminate\Http\Request;

class TelefonoController extends Controller
{
    public function store(Request $request, Contacto $contacto)
    {
        $request->validate([
            'numero' => 'required|string',
        ]);

        $telefono = new Telefono([
            'numero' => $request->numero,
        ]);

        $contacto->telefonos()->save($telefono);

        return response()->json($telefono, 201);
    }

    public function update(Request $request, Contacto $contacto, Telefono $telefono)
    {
        $request->validate([
            'numero' => 'required|string',
        ]);

        $telefono->update($request->all());

        return response()->json($telefono, 200);
    }

    public function destroy(Contacto $contacto, Telefono $telefono)
    {
        $telefono->delete();

        return response()->json(null, 204);
    }
}
