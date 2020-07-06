<?php

namespace App\Http\Controllers;

use App\categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>categorias::all()], 200);
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
        $categorias = new categorias([      
            'categoria'  => $request->categoria
        ]);

        $categorias->save();
        return response()->json([
            'message' => 'categoria creada!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria=categorias::find($id);
        if (!$categoria) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una categoria con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>categoria],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function edit(categorias $categorias)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $categorias = categorias::find($id);

        if (!$categorias) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una categoria con ese código.'],200);
        }
        
        $categorias->categoria  = $request->categoria;
        $categorias->save();

        /* return $users; */
        return response()->json([
            'message' => 'categoria actualizado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\categorias  $categorias
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = categorias::find($id);
        if (!$categoria) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra una categoria con ese código.'],200);
		}
        $categoria->delete();
        return response()->json([
            'message' => 'categoria eliminada!'], 200);
    }
}
