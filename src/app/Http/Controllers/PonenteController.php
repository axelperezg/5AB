<?php

namespace App\Http\Controllers;

use App\Models\Ponente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PonenteController extends Controller
{
    /**
     * GET /api/ponentes
     * Lista (con paginación opcional)
     */
    public function index(Request $request)
    {
        $ponentes = Ponente::latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'status' => 200,
            'data'   => $ponentes
        ]);
    }

    /**
     * POST /api/ponentes
     * Crear ponente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre'       => ['required', 'string', 'max:120'],
            'biografia'    => ['nullable', 'string'],
            'especialidad' => ['nullable', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors()
            ], 422);
        }

        $ponente = Ponente::create($validator->validated());

        return response()->json([
            'status'  => 201,
            'message' => 'Ponente creado',
            'data'    => $ponente
        ], 201);
    }

    /**
     * GET /api/ponentes/{id}
     * Mostrar detalle
     */
    public function show($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Ponente no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $ponente
        ]);
    }

    /**
     * PUT/PATCH /api/ponentes/{id}
     * Actualizar ponente
     */
    public function update(Request $request, $id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Ponente no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'       => ['sometimes', 'required', 'string', 'max:120'],
            'biografia'    => ['sometimes', 'nullable', 'string'],
            'especialidad' => ['sometimes', 'nullable', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'Datos inválidos',
                'errors'  => $validator->errors()
            ], 422);
        }

        $ponente->update($validator->validated());

        return response()->json([
            'status'  => 200,
            'message' => 'Ponente actualizado',
            'data'    => $ponente
        ]);
    }

    /**
     * DELETE /api/ponentes/{id}
     * Eliminar ponente
     */
    public function destroy($id)
    {
        $ponente = Ponente::find($id);

        if (!$ponente) {
            return response()->json([
                'status'  => 404,
                'message' => 'Ponente no encontrado'
            ], 404);
        }

        $ponente->delete();

        // 204: sin contenido
        return response()->json(null, 204);
    }
}