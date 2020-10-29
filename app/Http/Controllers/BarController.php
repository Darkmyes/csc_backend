<?php

namespace App\Http\Controllers;

use App\bar;
use Illuminate\Http\Request;
use Validator;

class BarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>bar::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'id_usuario' => 'required|exists:users,id',
            'celular' => 'string|required',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $bar = new bar([      
            'nombre'  => $request->nombre,
            'id_usuario' => $request->id_usuario,
            'celular' => $request->celular,
        ]);

	$imageName = null;

        if(($request->img) != null){
            $t = time();
            $imageName = $t.'_'.$request->id_usuario.$request->img->extension();
            $request->img->move(public_path('imgs/bares/'), $imageName);
            $bar->img = 'imgs/bares/'.$imageName;
        }

        $bar->save();
        return response()->json([
            'message' => 'bar Registrado'], 200);
    }

    public function show($id)
    {
        $bar = bar::find($id);
        if (!$bar) {
			return response()->json([
                'message'=>'No se encuentra una bar con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$bar],200);
    }

    public function porUsuario($id_usuario)
    {
        $bar = bar::where('id_usuario', '=', $id_usuario)->get();
        if (!$bar) {
			return response()->json([
                'message'=>'No se encuentra una bar con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$bar],200);
    }

    public function porNombre($busq)
    {
        $bar = bar::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$bar) {
			return response()->json([
                'message'=>'No se encuentra una bar con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$bar],200);
    }

    public function porToken($busq)
    {
        $bar = bar::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$bar) {
			return response()->json([
                'message'=>'No se encuentra una bar con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$bar],200);
    }

    public function edit(bar $bar)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $bar = bar::find($id);

        if (!$bar) {
			return response()->json([
                'message' => 'No se encuentra una bar con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        if (isset($request->celular)) {
            $bar->celular = $request->celular;
        }

	$imageName = null;

        if(($request->img) != null){
	    $dirimgs = public_path().'/'. $bar->img;
            @unlink($dirimgs);
            $t = time();
            $imageName = $t.'_'.$request->id_usuario.$request->img->extension();
            $request->img->move(public_path('imgs/bares/'), $imageName);
            $bar->img = 'imgs/bares/'.$imageName;
        }

        $bar->nombre = $request->nombre;
        $bar->save();

        return response()->json([
            'message' => 'Se actualizó la bar'], 200);
    }

    public function destroy($id)
    {
        $bar = bar::find($id);
        if (!$bar) {
			return response()->json([
                'message' => 'No se encuentra una bar con ese código.'
            ], 404);
		}
	if($bar->img != null) {
		$dirimgs = public_path().'/'. $bar->img;
	        @unlink($dirimgs);
	}

        $bar->delete();
        return response()->json([
            'message' => 'bar Eliminada'], 200);
    }
}
