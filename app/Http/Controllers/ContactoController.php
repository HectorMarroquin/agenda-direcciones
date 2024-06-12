<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Contacto;
use App\Models\Telefono;
use App\Models\Correo;
use App\Models\Direccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreContactRequest;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contactos = Contacto::where('user_id', auth()->id())->get();
        return response()->json(['contactos' => $contactos], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        try {
            DB::beginTransaction();

            // Crear el contacto
            $contacto = new Contacto();
            $contacto->nombre = $request->nombre;
            $contacto->user_id = auth()->id();
            $contacto->save();

            // Guardar teléfonos
            if ($request->has('telefonos')) {
                foreach ($request->telefonos as $telefonoData) {
                    $telefono = new Telefono([
                        'numero' => $telefonoData['numero'],
                        'contacto_id' => $contacto->id,
                    ]);
                    $telefono->save();
                }
            }

            // Guardar correos electrónicos
            if ($request->has('emails')) {
                foreach ($request->emails as $emailData) {
                    $correo = new Correo([
                        'correo' => $emailData['correo'],
                        'contacto_id' => $contacto->id,
                    ]);
                    $correo->save();
                }
            }

            // Guardar direcciones
            if ($request->has('direcciones')) {
                foreach ($request->direcciones as $direccionData) {
                    $direccion = new Direccion([
                        'direccion' => $direccionData['direccion'],
                        'contacto_id' => $contacto->id,
                    ]);
                    $direccion->save();
                }
            }

            DB::commit();

            return response()->json(['message' => 'Contacto creado correctamente', 'contacto' => $contacto], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear el contacto', 'error' => $e->getMessage()], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            // Buscar el contacto por su ID
            $contacto = Contacto::with('telefonos', 'correos', 'direcciones')->findOrFail($id);

            // Construir la respuesta para enviar al frontend
            $response = [
                'contacto' => [
                    'id' => $contacto->id,
                    'nombre' => $contacto->nombre,
                    'telefonos' => $contacto->telefonos,
                    'emails' => $contacto->correos,
                    'direcciones' => $contacto->direcciones,
                ],
            ];

            return response()->json($response, 200);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Contacto no encontrado', 'error' => $e->getMessage()], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al obtener el contacto', 'error' => $e->getMessage()], 500);
        }

        // try {
        //     $contacto = Contacto::where('user_id', auth()->id())->findOrFail($id);

        //     return response()->json(['contacto' => $contacto], 200);

        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Contacto no encontrado', 'error' => $e->getMessage()], 404);
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreContactRequest $request, $id)
    {
        try {
            // Obtener el contacto
            $contacto = Contacto::with('telefonos', 'correos', 'direcciones')->findOrFail($id);

            // Actualizar el nombre
            $contacto->nombre = $request->nombre;
            $contacto->save();

            // Actualizar los teléfonos
            if ($request->has('telefonos')) {
                foreach ($request->telefonos as $telefonoData) {
                    $telefono = $contacto->telefonos()->updateOrCreate(
                        ['id' => $telefonoData['id']], // Busca por id
                        ['numero' => $telefonoData['numero']] // Actualiza el número
                    );
                }
            }

            // Actualizar los correos electrónicos
            if ($request->has('emails')) {
                foreach ($request->emails as $emailData) {
                    $correo = $contacto->correos()->updateOrCreate(
                        ['id' => $emailData['id']], // Busca por id
                        ['correo' => $emailData['correo']] // Actualiza el correo
                    );
                }
            }

            // Actualizar las direcciones
            if ($request->has('direcciones')) {
                foreach ($request->direcciones as $direccionData) {
                    $direccion = $contacto->direcciones()->updateOrCreate(
                        ['id' => $direccionData['id']], // Busca por id
                        ['direccion' => $direccionData['direccion']] // Actualiza la dirección
                    );
                }
            }

            return response()->json(['message' => 'Contacto actualizado correctamente', 'contacto' => $contacto], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el contacto', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Eliminar primero los registros dependientes (telefonos, correos, direcciones, etc.)
            DB::table('telefonos')->where('contacto_id', $id)->delete();
            DB::table('correos')->where('contacto_id', $id)->delete();
            DB::table('direccions')->where('contacto_id', $id)->delete();

            // Luego, eliminar el contacto principal
            $contacto = Contacto::findOrFail($id);
            $contacto->delete();

            return response()->json(['message' => 'Contacto eliminado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al eliminar el contacto', 'error' => $e->getMessage()], 500);
        }
    }
}
