<?php

namespace App\Http\Controllers;

use App\componente;
use Illuminate\Http\Request;
use Validator;

class ComponenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>componente::all()], 200);
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

        $componente = new componente([      
            'nombre'  => $request->nombre
        ]);

        $componente->save();
        return response()->json([
            'message' => 'componente Registrado'], 200);
    }

    public function show($id)
    {
        $componente = componente::find($id);
        if (!$componente) {
			return response()->json([
                'message'=>'No se encuentra una componente con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$componente],200);
    }

    public function porNombre($busq)
    {
        $componente = componente::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$componente) {
			return response()->json([
                'message'=>'No se encuentra una componente con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$componente],200);
    }

    public function update(Request $request, $id)
    {
        $componente = componente::find($id);

        if (!$componente) {
			return response()->json([
                'message' => 'No se encuentra una componente con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $componente->nombre = $request->nombre;
        $componente->save();

        return response()->json([
            'message' => 'Se actualizó la componente'], 200);
    }

    public function destroy($id)
    {
        $componente = componente::find($id);
        if (!$componente) {
			return response()->json([
                'message' => 'No se encuentra una componente con ese código.'
            ], 404);
		}
        $componente->delete();
        return response()->json([
            'message' => 'componente Eliminada'], 200);
    }
}
