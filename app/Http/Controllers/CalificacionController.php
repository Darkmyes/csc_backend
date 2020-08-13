<?php

namespace App\Http\Controllers;

use App\calificacion;
use Illuminate\Http\Request;
use Validator;

class CalificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>calificacion::all()], 200);
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
            'id_bar' => 'required|exists:bars,id',
            'calificacion' => 'required|int'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $calificacion = calificacion::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_bar', '=', $request->id_bar],
        ])->first();

        if (isset($calificacion)) {
			return response()->json([
                'message' => 'Esta Calificacion ya se encuentra registrada'
            ], 404);
		}

        $calificacion = new calificacion([      
            'id_usuario' => $request->id_usuario,
            'id_bar'  => $request->id_bar,
            'calificacion'  => $request->calificacion
        ]);

        $calificacion->save();
        return response()->json([
            'message' => 'Calificacion Registrada'], 200);
    }

    public function show($id_bar, $id_usuario)
    {
        $calificacion = calificacion::where([
                ['id_usuario', '=', $id_usuario],
                ['id_bar', '=', $id_bar],
            ])            
            ->get();
        if (!$calificacion) {
			return response()->json([
                'message'=>'No se encuentra una Calificacion con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$calificacion],200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_usuario' => 'required|exists:users,id',
            'id_bar' => 'required|exists:bars,id',
            'calificacion' => 'required|int'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $calificacion = calificacion::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_bar', '=', $request->id_bar],
        ])->first();

        if (!isset($calificacion)) {
			return response()->json([
                'message' => 'Esta Calificacion no existe'
            ], 404);
		}

        $calificacion = calificacion::where([
            ['id_usuario', '=', $request->id_usuario],
            ['id_bar', '=', $request->id_bar],
        ])            
        ->update(['calificacion'  => $request->calificacion]);

        return response()->json([
            'message' => 'Calificacion Actualizada'], 200);
    }

    public function porBar($id_bar)
    {
        $calificacion = calificacion::where('id_bar', '=', $id_bar)
            ->get();
        if (!$calificacion) {
			return response()->json([
                'message'=>'No se encuentra una Calificacion con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$calificacion],200);
    }

    public function destroy($id_bar, $id_usuario)
    {
        $calificacion = calificacion::where([
            ['id_usuario', '=', $id_usuario],
            ['id_bar', '=', $id_bar],
        ])->first();

        if (!$calificacion) {
			return response()->json([
                'message' => 'No se encuentra una Calificacion con ese código.'
            ], 404);
		}
        calificacion::where([
            ['id_usuario', '=', $id_usuario],
            ['id_bar', '=', $id_bar],
        ])->delete();

        return response()->json([
            'message' => 'Calificacion Eliminada'], 200);
    }
}
