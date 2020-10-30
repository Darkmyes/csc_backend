<?php

namespace App\Http\Controllers;

use App\EnfermedadesUsuario;
use Illuminate\Http\Request;
use Validator;

class EnfermedadesUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EnfermedadesUsuario = EnfermedadesUsuario::join('enfermedades', 'enfermedades.id', '=', 'enfermedades_usuarios.id_enfermedad')
            ->select('enfermedades_usuarios.*', 'enfermedades.nombre')
            ->get();
        return response()->json([ "data" => $EnfermedadesUsuario], 200);
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
            'id_usuario' => 'required|exists:users,id',
            'id_enfermedad' => 'required|exists:enfermedades,id'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $enfermedad_usuario = EnfermedadesUsuario::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_enfermedad', '=', $request->id_enfermedad],
        ])->first();

        if (isset($enfermedad_usuario)) {
			return response()->json([
                'message' => 'Esta enfermedad del Usuario ya se encuentra registrada'
            ], 404);
		}

        $EnfermedadesUsuario = new EnfermedadesUsuario([      
            'id_usuario' => $request->id_usuario,
            'id_enfermedad'  => $request->id_enfermedad
        ]);

        $EnfermedadesUsuario->save();
        return response()->json([
            'message' => 'enfermedad del Usuario Registrada'], 200);
    }

    public function show($id_usuario, $id_cat_al)
    {
        $enfermedad_usuario = EnfermedadesUsuario::where([
                ['id_usuario', '=', $id_usuario],
                ['id_enfermedad', '=', $id_cat_al],
            ])->join('enfermedades', 'enfermedades.id', '=', 'enfermedades_usuarios.id_enfermedad')
            ->select('enfermedades_usuarios.*', 'enfermedades.nombre')
            ->get();
        if (!$enfermedad_usuario) {
			return response()->json([
                'message'=>'No se encuentra una enfermedad del Usuario con ese código.'],404);
		}
		return response()->json([ "data" =>$enfermedad_usuario],200);
    }

    public function porUsuario($id_usuario)
    {
        $enfermedad_usuario = EnfermedadesUsuario::where('id_usuario', '=', $id_usuario)
            ->join('enfermedades', 'enfermedades.id', '=', 'enfermedades_usuarios.id_enfermedad')
            /*->select('enfermedades_usuarios.*', 'enfermedades.nombre') */
            ->get();
        if (!$enfermedad_usuario) {
			return response()->json([
                'message'=>'No se encuentra una enfermedad del Usuario con ese código.'],404);
		}
		return response()->json([ "data" =>$enfermedad_usuario],200);
    }

    public function destroy($id_usuario, $id_cat_al)
    {
        $enfermedad_usuario = EnfermedadesUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_enfermedad', '=', $id_cat_al],
        ])->first();

        if (!$enfermedad_usuario) {
			return response()->json([
                'message' => 'No se encuentra una enfermedad del Usuario con ese código.'
            ], 404);
		}
        EnfermedadesUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_enfermedad', '=', $id_cat_al],
        ])->delete();

        return response()->json([
            'message' => 'enfermedad del Usuario Eliminada'], 200);
    }
}
