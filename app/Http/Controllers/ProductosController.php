<?php

namespace App\Http\Controllers;

use App\productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>productos::all()], 200);
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
        $productos = new productos([      
            'id_negocio' => $request->id_negocio,
            'producto'  => $request->producto,
            'descripcion'  => $request->descripcion,
            'img'  => $request->img,
        ]);

        $productos->save();
        return response()->json([
            'message' => 'producto creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=productos::find($id);
        if (!$producto) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un producto con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>producto],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit(productos $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $productos = productos::find($id);

        if (!$productos) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un producto con ese código.'],200);
		}

        $productos->id_negocio = $request->id_negocio;
        $productos->producto  = $request->producto;
        $productos->descripcion  = $request->descripcion;
        $productos->img  = $request->img;

        $productos->save();

        /* return $users; */
        return response()->json([
            'message' => 'producto actualizado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = productos::find($id);
        if (!$producto) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un producto con ese código.'],200);
		}
        $producto->delete();
        return response()->json([
            'message' => 'producto eliminado!'], 200);
    }
}
