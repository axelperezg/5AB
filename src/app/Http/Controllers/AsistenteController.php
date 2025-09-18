<?php

namespace App\Http\Controllers;

use App\Models\Asistente;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AsistenteController extends Controller
{
    /**
     * GET /api/asistentes
     * Lista asistentes (se puede filtrar por evento_id)
     */
    public function index(Request $request)
    {
        $query = Asistente::query();

        if ($request->filled('evento_id')) {
            $query->where('evento_id', $request->evento_id);
        }

        $asistentes = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'status' => 200,
            'data'   => $asistentes
        ]);
    }

    /**
     * POST /api/asistentes
     * Crear asistente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'    => ['required', 'string', 'max:120'],
            'email'     => ['required', 'email', 'max:255', 'unique:asistentes,email'],
            'telefono'  => ['nullable', 'string', 'max:30'],
            'evento_id' => ['required', 'exists:eventos,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors()
            ], 422);
        }

        $asistente = Asistente::create($validator->validated());

        return response()->json([
            'status'  => 201,
            'message' => 'Asistente creado',
            'data'    => $asistente
        ], 201);
    }

    /**
     * GET /api/asistentes/{id}
     * Mostrar detalle
     */
    public function show($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Asistente no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $asistente
        ]);
    }

    /**
     * PUT/PATCH /api/asistentes/{id}
     * Actualizar asistente
     */
    public function update(Request $request, $id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Asistente no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'    => ['sometimes', 'required', 'string', 'max:120'],
            'email'     => [
                'sometimes', 'required', 'email', 'max:255',
                Rule::unique('asistentes', 'email')->ignore($asistente->id)
            ],
            'telefono'  => ['sometimes', 'nullable', 'string', 'max:30'],
            'evento_id' => ['sometimes', 'required', 'exists:eventos,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors()
            ], 422);
        }

        $asistente->update($validator->validated());

        return response()->json([
            'status'  => 200,
            'message' => 'Asistente actualizado',
            'data'    => $asistente
        ]);
    }

    /**
     * DELETE /api/asistentes/{id}
     * Eliminar asistente
     */
    public function destroy($id)
    {
        $asistente = Asistente::find($id);

        if (!$asistente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Asistente no encontrado'
            ], 404);
        }

        $asistente->delete();

        return response()->json(null, 204);
    }
}
