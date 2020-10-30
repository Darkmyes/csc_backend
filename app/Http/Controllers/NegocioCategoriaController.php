<?php

namespace App\Http\Controllers;

use App\negocio_categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NegocioCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([negocio_categoria::all()], 200);
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
        $negocio_categoria = new negocio_categoria([            
            'id_negocio'  => $request->id_negocio,
            'id_categoria'  => $request->id_categoria,
        ]);

        $negocio_categoria->save();
        return response()->json([
            'message' => 'negocio creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\negocio_categoria  $negocio_categoria
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negocio=negocio_categoria::find($id);

		// Si no existe ese negocio devolvemos un error.
		if (!$negocio)
		{
			// Se devuelve un array errors con los errores encontrados y cabecera HTTP 404.
			// En code podríamos indicar un código de error personalizado de nuestra aplicación si lo deseamos.
			return response()->json(['errors'=>array(['code'=>404,'message'=>'No se encuentra un negocio con ese código.'])],404);
		}

		return response()->json([$negocio],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\negocio_categoria  $negocio_categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(negocio_categoria $negocio_categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\negocio_categoria  $negocio_categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, negocio_categoria $negocio_categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\negocio_categoria  $negocio_categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_negocio,$id_categoria)
    {
        $negocio_categoria = DB::table('negocio_categoria')->where(
            ['id_negocio', '=', $id_negocio],
            ['id_categoria', '=', $id_categoria])->delete();
        if(json_decode($negocio_categoria, true) ){
            return response()->json([
                'message' => 'negocio eliminado!'], 200);

        }else{
            return response()->json([
                'message' => 'Ese negocio no existe!'], 200);
        }
    }
}
