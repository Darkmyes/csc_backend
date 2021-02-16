<?php

namespace App\Http\Controllers;

use App\actividades_cuarentena;
use Illuminate\Http\Request;
use Validator;

class ActividadesCuarentenaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([actividades_cuarentena::all()], 200);
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

	$al = actividades_cuarentena::where([['nombre','like', '%'.$request->nombre.'%'],
		['id_usuario','=',$request->id_usuario]
	])->get();
        if (count($al) > 0) {
                return response()->json([
                'message'=>'Ya se encuentra una Actividad de Cuarentena con ese Nombre'],404);
        }

        $actividades_cuarentena = new actividades_cuarentena([      
            'nombre'  => $request->nombre,
            'id_usuario' => $request->id_usuario,
        ]);

        $actividades_cuarentena->save();
        return response()->json([
            'message' => 'Actividad Cuarentena Registrada'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\actividades_cuarentena  $actividades_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* $actividad_cuarentena=actividades_cuarentena::find($id);
        if (!$actividad_cuarentena) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una actividad_cuarentena con ese código.'],200);
		}
		return response()->json([actividad_cuarentena],200); */
    }

    public function byUsuario($id)
    {
        $actividad_cuarentena = actividades_cuarentena::where('id_usuario', '=', $id)->get();

		return response()->json(['status' => 'ok','data' => $actividad_cuarentena],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\actividades_cuarentena  $actividades_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function edit(actividades_cuarentena $actividades_cuarentena)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\actividades_cuarentena  $actividades_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actividades_cuarentena = actividades_cuarentena::find($id);

        if (!$actividades_cuarentena) {
			return response()->json([
                'message' => 'No se encuentra una Actividad de Cuarentena con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $actividades_cuarentena->nombre = $request->nombre;
        $actividades_cuarentena->save();

        return response()->json([
            'message' => 'Se actualizó la Actividad de Cuarentena'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\actividades_cuarentena  $actividades_cuarentena
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actividad_cuarentena = actividades_cuarentena::find($id);
        if (!$actividad_cuarentena) {
			return response()->json([
                'message' => 'No se encuentra una Actividad Cuarentena con ese código.'
            ], 404);
		}
        $actividad_cuarentena->delete();
        return response()->json([
            'message' => 'Actividad Cuarentena Eliminada'], 200);
    }
}
