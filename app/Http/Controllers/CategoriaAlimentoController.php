<?php

namespace App\Http\Controllers;

use App\categoria_alimento;
use Illuminate\Http\Request;
use Validator;

class CategoriaAlimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([ "data" => categoria_alimento::all()], 200);
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

        $categoria_alimento = new categoria_alimento([      
            'nombre'  => $request->nombre
        ]);

        $categoria_alimento->save();
        return response()->json([
            'message' => 'Categoría de Alimento Registrada'], 200);
    }

    public function show($id)
    {
        $categoria_alimento = categoria_alimento::find($id);
        if (!$categoria_alimento) {
			return response()->json([
                'message'=>'No se encuentra una Categoría de Alimento con ese código.'],404);
		}
		return response()->json([ "data" => $categoria_alimento],200);
    }

    public function porNombre($busq)
    {
        $categoria_alimento = categoria_alimento::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$categoria_alimento) {
			return response()->json([
                'message'=>'No se encuentra una Categoría de Alimento con ese código.'],404);
		}
		return response()->json([ "data" => $categoria_alimento],200);
    }

    public function edit(categoria_alimento $categoria_alimento)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $categoria_alimento = categoria_alimento::find($id);

        if (!$categoria_alimento) {
			return response()->json([
                'message' => 'No se encuentra una Categoría de Alimento con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $categoria_alimento->nombre = $request->nombre;
        $categoria_alimento->save();

        return response()->json([
            'message' => 'Se actualizó la Categoría de Alimento'], 200);
    }

    public function destroy($id)
    {
        $categoria_alimento = categoria_alimento::find($id);
        if (!$categoria_alimento) {
			return response()->json([
                'message' => 'No se encuentra una Categoría de Alimento con ese código.'
            ], 404);
		}
        $categoria_alimento->delete();
        return response()->json([
            'message' => 'Categoría de Alimento Eliminada'], 200);
    }
}
