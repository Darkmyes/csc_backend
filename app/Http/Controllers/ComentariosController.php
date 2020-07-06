<?php

namespace App\Http\Controllers;

use App\comentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComentariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>comentarios::all()], 200);
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
        $comentarios = new comentarios([            
            'id_comentario' => $request->id_comentario,
            'usuario_sin_cuenta' => $request->usuario_sin_cuenta,
            'id_usuario' => $request->id_usuario,
            'comentario' => $request->comentario,
            'respuesta_de' => $request->respuesta_de
        ]);

        $comentarios->save();
        return response()->json([
            'message' => 'comentario creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comentario=comentarios::find($id);
        if (!$comentarios) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una comentario con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>$comentario],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function edit(comentarios $comentarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comentarios = comentarios::findOrFail($request->id);

        if (!$comentarios) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una comentario con ese código.'],200);
        }
        
        $comentarios->id_comentario = $request->id_comentario;
        $comentarios->usuario_sin_cuenta = $request->usuario_sin_cuenta;
        $comentarios->id_usuario = $request->id_usuario;
        $comentarios->comentario = $request->comentario;
        $comentarios->respuesta_de = $request->respuesta_de;

        $comentarios->save();

        /* return $users; */
        return response()->json([
            'message' => 'comentario actualizado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\comentarios  $comentarios
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comentarios = comentarios::find($id);
        if (!$comentarios) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una comentario con ese código.'],200);
		}
        $comentarios->delete();
        return response()->json([
            'message' => 'comentario eliminada!'], 200);
    }
}
