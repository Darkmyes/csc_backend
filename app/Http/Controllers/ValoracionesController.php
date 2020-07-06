<?php

namespace App\Http\Controllers;

use App\valoraciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValoracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>valoraciones::all()], 200);
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
        $valoraciones = new valoraciones([            
            'id_negocio' => $request->id_negocio,
            'usuario_sin_cuenta' => $request->usuario_sin_cuenta,
            'id_usuario' => $request->id_usuario,
            'valoracion' => $request->valoracion,
            'respuesta_de' => $request->respuesta_de
        ]);

        $valoraciones->save();
        return response()->json([
            'message' => 'valoracion creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\valoraciones  $valoraciones
     * @return \Illuminate\Http\Response
     */
    public function show(valoraciones $valoraciones)
    {
        $valoracion=valoraciones::find($id);
        if (!$valoracion) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una valoracion con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>$valoracion],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\valoraciones  $valoraciones
     * @return \Illuminate\Http\Response
     */
    public function edit(valoraciones $valoraciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\valoraciones  $valoraciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valoraciones = valoraciones::findOrFail($request->id);

        $valoraciones->id_negocio = $request->id_negocio;
        $valoraciones->usuario_sin_cuenta = $request->usuario_sin_cuenta;
        $valoraciones->id_usuario = $request->id_usuario;
        $valoraciones->valoracion = $request->valoracion;
        $valoraciones->respuesta_de = $request->respuesta_de;

        $valoraciones->save();

        /* return $users; */
        return response()->json([
            'message' => 'valoracion actualizada!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\valoraciones  $valoraciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(valoraciones $valoraciones)
    {
        $valoraciones = valoraciones::find($id);
        if (!$valoraciones) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una valoracion con ese código.'],200);
		}
        $valoraciones->delete();
        return response()->json([
            'message' => 'valoracion eliminada!'], 200);
    }
}
