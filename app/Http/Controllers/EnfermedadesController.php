<?php

namespace App\Http\Controllers;

use App\enfermedades;
use Illuminate\Http\Request;
use Validator;

class EnfermedadesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(["data" => enfermedades::all()], 200);
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

	$al = enfermedades::where('nombre','like', '%'.$request->nombre.'%')->get();
        if (count($al) > 0) {
                return response()->json([
                'message'=>'Ya se encuentra una Enfermedad con ese Nombre'],404);
        }

        $enfermedad = new enfermedades([      
            'nombre'  => $request->nombre
        ]);

        $enfermedad->save();
        return response()->json([
            'message' => 'enfermedad Registrada'], 200);
    }

    public function show($id)
    {
        $enfermedad = enfermedades::find($id);
        if (!$enfermedad) {
			return response()->json([
                'message'=>'No se encuentra una enfermedad con ese código.'],404);
		}
		return response()->json(["data" => $enfermedad],200);
    }

    public function porNombre($busq)
    {
        $enfermedad = enfermedades::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$enfermedad) {
			return response()->json([
                'message'=>'No se encuentra una enfermedad con ese código.'],404);
		}
		return response()->json(["data" => $enfermedad],200);
    }

    public function edit(enfermedad $enfermedad)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $enfermedad = enfermedades::find($id);

        if (!$enfermedad) {
			return response()->json([
                'message' => 'No se encuentra una enfermedad con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $enfermedad->nombre = $request->nombre;
        $enfermedad->save();

        return response()->json([
            'message' => 'Se actualizó la enfermedad'], 200);
    }

    public function destroy($id)
    {
        $enfermedad = enfermedades::find($id);
        if (!$enfermedad) {
			return response()->json([
                'message' => 'No se encuentra una enfermedad con ese código.'
            ], 404);
		}
        $enfermedad->delete();
        return response()->json([
            'message' => 'enfermedad Eliminada'], 200);
    }
}
