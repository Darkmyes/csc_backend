<?php

namespace App\Http\Controllers;

use App\AlergiasUsuario;
use Illuminate\Http\Request;
use Validator;

class AlergiasUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $AlergiasUsuario = AlergiasUsuario::join('alergias', 'alergias.id', '=', 'alergias_usuarios.id_alergia')
            ->select('alergias_usuarios.*', 'alergias.nombre')
            ->get();
        return response()->json(['status'=>'ok','data'=>$AlergiasUsuario], 200);
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
            'id_alergia' => 'required|exists:alergias,id'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $alergia_usuario = AlergiasUsuario::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_alergia', '=', $request->id_alergia],
        ])->first();

        if (isset($alergia_usuario)) {
			return response()->json([
                'message' => 'Esta Alergia del Usuario ya se encuentra registrada'
            ], 404);
		}

        $AlergiasUsuario = new AlergiasUsuario([      
            'id_usuario' => $request->id_usuario,
            'id_alergia'  => $request->id_alergia
        ]);

        $AlergiasUsuario->save();
        return response()->json([
            'message' => 'Alergia del Usuario Registrada'], 200);
    }

    public function show($id_usuario, $id_cat_al)
    {
        $alergia_usuario = AlergiasUsuario::where([
                ['id_usuario', '=', $id_usuario],
                ['id_alergia', '=', $id_cat_al],
            ])->join('alergias', 'alergias.id', '=', 'alergias_usuarios.id_alergia')
            ->select('alergias_usuarios.*', 'alergias.nombre')
            ->get();
        if (!$alergia_usuario) {
			return response()->json([
                'message'=>'No se encuentra una Alergia del Usuario con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$alergia_usuario],200);
    }

    public function porUsuario($id_usuario)
    {
        $alergia_usuario = AlergiasUsuario::where('id_usuario', '=', $id_usuario)
            ->join('alergias', 'alergias.id', '=', 'alergias_usuarios.id_alergia')
            ->select('alergias_usuarios.*', 'alergias.nombre')
            ->get();
        if (!$alergia_usuario) {
			return response()->json([
                'message'=>'No se encuentra una Alergia del Usuario con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$alergia_usuario],200);
    }

    public function destroy($id_usuario, $id_cat_al)
    {
        $alergia_usuario = AlergiasUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_alergia', '=', $id_cat_al],
        ])->first();

        if (!$alergia_usuario) {
			return response()->json([
                'message' => 'No se encuentra una Alergia del Usuario con ese código.'
            ], 404);
		}
        AlergiasUsuario::where([
            ['id_usuario', '=', $id_usuario],
            ['id_alergia', '=', $id_cat_al],
        ])->delete();

        return response()->json([
            'message' => 'Alergia del Usuario Eliminada'], 200);
    }
}
