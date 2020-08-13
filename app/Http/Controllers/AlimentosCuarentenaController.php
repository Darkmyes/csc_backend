<?php

namespace App\Http\Controllers;

use App\alimentos_cuarentena;
use Illuminate\Http\Request;
use Validator;

class AlimentosCuarentenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status' => 'ok', 'data' => alimentos_cuarentena::all()], 200);
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
            'nombre'  => 'string|required',
            'id_usuario' => 'required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $alimentos_cuarentena = new alimentos_cuarentena([      
            'nombre'  => $request->nombre,
            'id_usuario' => $request->id_usuario,
        ]);

        $alimentos_cuarentena->save();
        return response()->json([
            'message' => 'Alimento Cuarentena Registrada'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\alimentos_cuarentena  $alimentos_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function show(alimentos_cuarentena $alimentos_cuarentena)
    {
        //
    }

    public function byUsuario($id)
    {
        $alimento_cuarentena = alimentos_cuarentena::where('id_usuario', '=', $id)->get();

		return response()->json(['status' => 'ok','data' => $alimento_cuarentena],200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\alimentos_cuarentena  $alimentos_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function edit(alimentos_cuarentena $alimentos_cuarentena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\alimentos_cuarentena  $alimentos_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $alimentos_cuarentena = alimentos_cuarentena::find($id);

        if (!$alimentos_cuarentena) {
			return response()->json([
                'message' => 'No se encuentra una alimento de Cuarentena con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $alimentos_cuarentena->nombre = $request->nombre;
        $alimentos_cuarentena->save();

        return response()->json([
            'message' => 'Se actualizó la alimento de Cuarentena'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\alimentos_cuarentena  $alimentos_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alimento_cuarentena = alimentos_cuarentena::find($id);
        if (!$alimento_cuarentena) {
			return response()->json([
                'message' => 'No se encuentra una alimento Cuarentena con ese código.'
            ], 404);
		}
        $alimento_cuarentena->delete();
        return response()->json([
            'message' => 'Alimento Cuarentena Eliminada'], 200);
    }
}
