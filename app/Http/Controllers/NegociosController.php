<?php

namespace App\Http\Controllers;

use App\negocios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NegociosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>DB::table('lista_negocios')->get()], 200);
        //return response()->json(['status'=>'ok','data'=>negocios::all()], 200);
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
        $request->validate([
            'img' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $imageName = time().$request->nombre.'.'.$request->img->extension();

        $request->img->move(public_path('images'), $imageName);

        $negocios = new negocios([            
            'id_usuario'  => $request->id_usuario,
            'nombre'  => $request->nombre,
            'img'  => $imageName,
            'descripcion'  => $request->descripcion,
            'latitud'  => $request->latitud,
            'longitud'  => $request->longitud,
            'pais'  => $request->pais,
            'ciudad'  => $request->ciudad,
            'correo'  => $request->correo,
            'facebook'  => $request->facebook,
            'instagram'  => $request->instagram,
            'whatsapp'   => $request->whatsapp,
        ]);

        $negocios->save();
        return response()->json([
            'message' => 'negocio creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negocio=negocios::find($id);
        if (!$negocio) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un negocio con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>$negocio],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\negocios  $negocios
     * @return \Illuminate\Http\Response
     */
    public function edit(negocios $negocios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\negocios  $negocios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $negocios = negocios::find($id);
        if (!$negocios) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un negocio con ese código.'],200);
		}

        $negocios->nombre = $request->nombre;
        $negocios->descripcion = $request->descripcion;
        $negocios->img = $request->img;
        $negocios->latitud = $request->latitud;
        $negocios->longitud = $request->longitud;
        $negocios->pais = $request->pais;
        $negocios->ciudad = $request->ciudad;
        $negocios->correo = $request->correo;
        $negocios->facebook = $request->facebook;
        $negocios->instagram = $request->instagram;
        $negocios->whatsapp = $request->whatsapp;

        $negocios->save();

        /* return $users; */
        return response()->json([
            'message' => 'negocio actualizado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\negocios  $negocios
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $negocio = negocios::find($id);
        if (!$negocio) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un negocio con ese código.'],200);
		}
        $negocio->delete();
        return response()->json([
            'message' => 'negocio eliminado!'], 200);
    }
}
