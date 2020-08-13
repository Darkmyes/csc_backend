<?php

namespace App\Http\Controllers;

use App\EstilosVidaUsuario;
use Illuminate\Http\Request;
use Validator;

class EstilosVidaUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $EstilosVidaUsuario = EstilosVidaUsuario::join('estilos_vidas', 'estilos_vidas.id', '=', 'estilos_vida_usuarios.id_estilo_vida')
            ->select('estilos_vida_usuarios.*', 'estilos_vidas.nombre')
            ->get();
        return response()->json(['status'=>'ok','data'=>$EstilosVidaUsuario], 200);
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
            'id_estilo_vida' => 'required|exists:estilos_vidas,id'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $estilo_vida_usuario = EstilosVidaUsuario::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_estilo_vida', '=', $request->id_estilo_vida],
        ])->first();

        if (isset($estilo_vida_usuario)) {
			return response()->json([
                'message' => 'Esta Alergia del Usuario ya se encuentra registrada'
            ], 404);
		}

        $EstilosVidaUsuario = new EstilosVidaUsuario([      
            'id_usuario' => $request->id_usuario,
            'id_estilo_vida'  => $request->id_estilo_vida,
            'valor' => $request->valor
        ]);

        $EstilosVidaUsuario->save();
        return response()->json([
            'message' => 'Alergia del Usuario Registrada'], 200);
    }

    public function show($id_usuario, $id_cat_al)
    {
        $estilo_vida_usuario = EstilosVidaUsuario::where([
                ['id_usuario', '=', $id_usuario],
                ['id_estilo_vida', '=', $id_cat_al],
            ])->join('estilos_vidas', 'estilos_vidas.id', '=', 'estilos_vida_usuarios.id_estilo_vida')
            ->select('estilos_vida_usuarios.*', 'estilos_vidas.nombre')
            ->get();
        if (!$estilo_vida_usuario) {
			return response()->json([
                'message'=>'No se encuentra una Alergia del Usuario con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$estilo_vida_usuario],200);
    }

    public function porUsuario($id_usuario)
    {
        $estilo_vida_usuario = EstilosVidaUsuario::where('id_usuario', '=', $id_usuario)
            ->join('estilos_vidas', 'estilos_vidas.id', '=', 'estilos_vida_usuarios.id_estilo_vida')
            ->select('estilos_vida_usuarios.*', 'estilos_vidas.nombre')
            ->get();
        if (!$estilo_vida_usuario) {
			return response()->json([
                'message'=>'No se encuentra una Alergia del Usuario con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$estilo_vida_usuario],200);
    }

    public function destroy($id_usuario, $id_cat_al)
    {
        $estilo_vida_usuario = EstilosVidaUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_estilo_vida', '=', $id_cat_al],
        ])->first();

        if (!$estilo_vida_usuario) {
			return response()->json([
                'message' => 'No se encuentra una Alergia del Usuario con ese código.'
            ], 404);
		}
        EstilosVidaUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_estilo_vida', '=', $id_cat_al],
        ])->delete();

        return response()->json([
            'message' => 'Alergia del Usuario Eliminada'], 200);
    }
}
