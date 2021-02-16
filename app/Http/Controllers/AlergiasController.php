<?php

namespace App\Http\Controllers;

use App\alergias;
use Illuminate\Http\Request;
use Validator;

class AlergiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>alergias::all()], 200);
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

	$al = alergias::where('nombre','like', '%'.$request->nombre.'%')->get();
	if (count($al) > 0) {
		return response()->json([
                'message'=>'Ya se encuentra una Alergia con ese Nombre'],404);
	}

        $alergias = new alergias([      
            'nombre'  => $request->nombre
        ]);

        $alergias->save();
        return response()->json([
            'message' => 'Alergia Registrada'], 200);
    }

    public function show($id)
    {
        $alergia = alergias::find($id);
        if (!$alergia) {
			return response()->json([
                'message'=>'No se encuentra una alergia con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$alergia],200);
    }

    public function porNombre($busq)
    {
        $alergia = alergias::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$alergia) {
			return response()->json([
                'message'=>'No se encuentra una alergia con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$alergia],200);
    }

    public function edit(alergias $alergias)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $alergias = alergias::find($id);

        if (!$alergias) {
			return response()->json([
                'message' => 'No se encuentra una Alergia con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $alergias->nombre = $request->nombre;
        $alergias->save();

        return response()->json([
            'message' => 'Se actualizó la Alergia'], 200);
    }

    public function destroy($id)
    {
        $alergia = alergias::find($id);
        if (!$alergia) {
			return response()->json([
                'message' => 'No se encuentra una Alergia con ese código.'
            ], 404);
		}
        $alergia->delete();
        return response()->json([
            'message' => 'Alergia Eliminada'], 200);
    }
}
