<?php

namespace App\Http\Controllers;

use App\planes;
use Illuminate\Http\Request;

class PlanesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['status'=>'ok','data'=>planes::all()], 200);
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
        $planes = new planes([            
            'nombre'    => $request->nombre,
            'descripcion'    => $request->descripcion,
            
        ]);

        $planes->save();
        return response()->json([
            'message' => 'plan creado!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plan=planes::find($id);
		if (!$plan) {
			return response()->json(['code'=>200,'message'=>'No se encuentra un plan con ese código.'],200);
		}
		return response()->json(['status'=>'ok','data'=>$plan],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\planes  $planes
     * @return \Illuminate\Http\Response
     */
    public function edit(planes $planes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\planes  $planes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $plan = planes::find($request->id_plan);

        if(!json_decode($plan, true) ){
            return response()->json([
                'message' => 'Ese plan no existe!'], 200);
        }

        $plan->nombre = $request->nombre;
        $plan->descripcion = $request->descripcion;

        $plan->save();

        /* return $users; */
        return response()->json([
            'message' => 'plan actualizado!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\planes  $planes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = planes::find($id);
        if (!$plan) {
			return response()->json([
                'code'=>200,'message'=>'No se encuentra un plan con ese código.'],200);
		}
        $plan->delete();
        return response()->json([
            'message' => 'plan eliminado!'], 200);
    }
}
