<?php

namespace App\Http\Controllers;

use App\estilos_vida;
use Illuminate\Http\Request;
use Validator;

class EstilosVidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([ "data" => estilos_vida::all()], 200);
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

        $estilos_vidas = new estilos_vida([      
            'nombre'  => $request->nombre
        ]);

        $estilos_vidas->save();
        return response()->json([
            'message' => 'Estilo de Vida Registrada'], 200);
    }

    public function show($id)
    {
        $estilos_vidas = estilos_vida::find($id);
        if (!$estilos_vidas) {
			return response()->json([
                'message'=>'No se encuentra un Estilo de Vida con ese código.'],404);
		}
		return response()->json([ "data" => $estilos_vidas],200);
    }

    public function porNombre($busq)
    {
        $estilos_vidas = estilos_vida::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$estilos_vidas) {
			return response()->json([
                'message'=>'No se encuentra un Estilo de Vida con ese código.'],404);
		}
		return response()->json([ "data" => $estilos_vidas],200);
    }

    public function edit(estilos_vidas $estilos_vidas)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $estilos_vidas = estilos_vida::find($id);

        if (!$estilos_vidas) {
			return response()->json([
                'message' => 'No se encuentra un Estilo de Vida con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $estilos_vidas->nombre = $request->nombre;
        $estilos_vidas->save();

        return response()->json([
            'message' => 'Se actualizó el Estilo de Vida'], 200);
    }

    public function destroy($id)
    {
        $estilos_vidas = estilos_vida::find($id);
        if (!$estilos_vidas) {
			return response()->json([
                'message' => 'No se encuentra un Estilo de Vida con ese código.'
            ], 404);
		}
        $estilos_vidas->delete();
        return response()->json([
            'message' => 'Estilo de Vida Eliminado'], 200);
    }
}
