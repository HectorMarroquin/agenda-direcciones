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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'telefonos' => 'array',
            'telefonos.*.numero' => 'required|string',
            'emails' => 'array',
            'emails.*.email' => 'required|email',
            'direcciones' => 'array',
            'direcciones.*.direccion' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $contacto = new Contacto();
            $contacto->nombre = $request->nombre;
            $contacto->user_id = auth()->id();
            $contacto->save();

            // Guardar teléfonos
            foreach ($request->telefonos as $telefonoData) {
                $telefono = new Telefono();
                $telefono->numero = $telefonoData['numero'];
                $telefono->contacto_id = $contacto->id;
                $telefono->save();
            }

            // Guardar emails
            foreach ($request->emails as $emailData) {
                $correo = new Correo();
                $correo->correo = $emailData['email'];
                $correo->contacto_id = $contacto->id;
                $correo->save();
            }

            // Guardar direcciones
            foreach ($request->direcciones as $direccionData) {
                $direccion = new Direccion();
                $direccion->direccion = $direccionData['direccion'];
                $direccion->contacto_id = $contacto->id;
                $direccion->save();
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
            $contacto = Contacto::where('user_id', auth()->id())->findOrFail($id);
            return response()->json(['contacto' => $contacto], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Contacto no encontrado', 'error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $contacto = Contacto::where('user_id', auth()->id())->findOrFail($id);
            $contacto->nombre = $request->nombre;
            $contacto->save();

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
