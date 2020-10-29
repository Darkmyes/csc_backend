<?php

namespace App\Http\Controllers;

use App\preferencias;
use Illuminate\Http\Request;
use Validator;

class PreferenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preferencias = preferencias::join('categoria_alimentos', 'categoria_alimentos.id', '=', 'preferencias.id_categoria_alimento')
            ->select('preferencias.*', 'categoria_alimentos.nombre')
            ->get();
        return response()->json([ "data" => $preferencias], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required',
            'id_categoria_alimento' => 'required',
            'valor' => 'int|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $preferencia = preferencias::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_categoria_alimento', '=', $request->id_categoria_alimento],
        ])->first();

        if (isset($preferencia)) {
			return response()->json([
                'message' => 'Esta preferencia ya se encuentra registrada'
            ], 404);
		}

        $preferencias = new preferencias([      
            'id_usuario' => $request->id_usuario,
            'id_categoria_alimento'  => $request->id_categoria_alimento,
            'valor' => $request->valor
        ]);

        $preferencias->save();
        return response()->json([
            'message' => 'Preferencia Registrada'], 200);
    }

    public function show($id_usuario, $id_cat_al)
    {
        $preferencia = preferencias::where([
                ['id_usuario', '=', $id_usuario],
                ['id_categoria_alimento', '=', $id_cat_al],
            ])->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'preferencias.id_categoria_alimento')
            ->select('preferencias.*', 'categoria_alimentos.nombre')
            ->get();
        if (!$preferencia) {
			return response()->json([
                'message'=>'No se encuentra una preferencia con ese código.'],404);
		}
		return response()->json([ "data" => $preferencia],200);
    }

    public function porUsuario($id_usuario)
    {
        $preferencia = preferencias::where('id_usuario', '=', $id_usuario)
            ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'preferencias.id_categoria_alimento')
            ->select('preferencias.*', 'categoria_alimentos.nombre')
            ->get();
        if (!$preferencia) {
			return response()->json([
                'message'=>'No se encuentra una preferencia con ese código.'],404);
		}
		return response()->json([ "data" => $preferencia],200);
    }

    public function edit(preferencias $preferencias)
    {
        //
    }

    public function update(Request $request, $id_usuario, $id_cat_al)
    {
        $preferencias = preferencias::where([
            ['id_usuario', '=', $id_usuario],
            ['id_categoria_alimento', '=', $id_cat_al],
        ])->first();

        if (!$preferencias || !isset($preferencias->id_usuario)) {
			return response()->json([
                'message' => 'No se encuentra una preferencia con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'valor'  => 'int|required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        preferencias::where([
            ['id_usuario', '=', $id_usuario],
            ['id_categoria_alimento', '=', $id_cat_al],
        ])->update(['valor' => $request->valor]);

        return response()->json([
            'message' => 'Se actualizó la preferencia'], 200);
    }

    public function destroy($id_usuario, $id_cat_al)
    {
        $preferencia = preferencias::where([
            ['id_usuario', '=', $id_usuario],
            ['id_categoria_alimento', '=', $id_cat_al],
        ])->first();

        if (!$preferencia) {
			return response()->json([
                'message' => 'No se encuentra una preferencia con ese código.'
            ], 404);
		}
        preferencias::where([
            ['id_usuario', '=', $id_usuario],
            ['id_categoria_alimento', '=', $id_cat_al],
        ])->delete();

        return response()->json([
            'message' => 'preferencia Eliminada'], 200);
    }
}
