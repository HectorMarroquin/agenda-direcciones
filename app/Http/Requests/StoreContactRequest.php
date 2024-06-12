<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        // Puedes agregar lógica de autorización aquí.
        // Retorna true si todos los usuarios están autorizados a hacer esta solicitud.
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required|string',
            'telefonos' => 'array',
            'telefonos.*.numero' => 'required|numeric',
            'emails' => 'array',
            'emails.*.email' => 'required|email',
            'direcciones' => 'array',
            'direcciones.*.direccion' => 'required|string',
        ];
    }
}
