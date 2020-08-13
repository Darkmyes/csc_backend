<?php

namespace App\Http\Controllers;

use App\producto;
use Illuminate\Http\Request;
use Validator;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>producto::all()], 200);
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
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $producto = new producto([      
            'nombre'  => $request->nombre
        ]);

        $producto->save();
        return response()->json([
            'message' => 'producto Registrado'], 200);
    }

    public function show($id)
    {
        $producto = producto::find($id);
        if (!$producto) {
			return response()->json([
                'message'=>'No se encuentra una producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$producto],200);
    }

    public function porNombre($busq)
    {
        $producto = producto::where('nombre', 'like', '%'.$busq.'%')->get();
        if (!$producto) {
			return response()->json([
                'message'=>'No se encuentra una producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$producto],200);
    }

    public function edit(producto $producto)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $producto = producto::find($id);

        if (!$producto) {
			return response()->json([
                'message' => 'No se encuentra una producto con ese código.'
            ],404);
        }

        $validator = Validator::make($request->all(), [
            'nombre'  => 'string|required'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        
        $producto->nombre = $request->nombre;
        $producto->save();

        return response()->json([
            'message' => 'Se actualizó la producto'], 200);
    }

    public function destroy($id)
    {
        $producto = producto::find($id);
        if (!$producto) {
			return response()->json([
                'message' => 'No se encuentra una producto con ese código.'
            ], 404);
		}
        $producto->delete();
        return response()->json([
            'message' => 'producto Eliminada'], 200);
    }
}
