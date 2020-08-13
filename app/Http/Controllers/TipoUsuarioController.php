<?php

namespace App\Http\Controllers;

use App\tipo_usuario;
use Illuminate\Http\Request;
use Validator;

class TipoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status' => 'ok', 'data' => tipo_usuario::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $tipo_usuario = new tipo_usuario([      
            'nombre'  => $request->nombre
        ]);

        $tipo_usuario->save();
        return response()->json([
            'message' => 'Tipo Usuario Registrado'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tipo_usuario  $tipo_usuario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipo_usuario = tipo_usuario::find($id);
        if (!$tipo_usuario) {
			return response()->json([
                'code' => 200, 'message' => 'No se encuentra un Tipo de Usuario con ese código.'
            ],200);
		}
		return response()->json(['status' => 'ok','data' => $tipo_usuario],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tipo_usuario  $tipo_usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(tipo_usuario $tipo_usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tipo_usuario  $tipo_usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tipo_usuario = tipo_usuario::find($id);

        if (!$tipo_usuario) {
			return response()->json([
                'code' => 200,
                'message' => 'No se encuentra un Tipo de Usuario con ese código.'
            ],200);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $tipo_usuario->nombre = $request->nombre;
        $tipo_usuario->save();

        return response()->json([
            'message' => 'Se actualizó el Tipo de Usuario de Cuarentena'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tipo_usuario  $tipo_usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo_usuario = tipo_usuario::find($id);
        if (!$tipo_usuario || !isset($tipo_usuario['id'])) {
			return response()->json([
                'code' => 200,
                'message' => 'No se encuentra una Tipo Usuario con ese código.'
            ], 200);
		}
        $tipo_usuario->delete();
        return response()->json([
            'message' => 'Tipo de Usuario Eliminado'], 200);
    }
}
