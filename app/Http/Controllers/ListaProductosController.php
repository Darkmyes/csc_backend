<?php

namespace App\Http\Controllers;

use App\lista_productos;
use Illuminate\Http\Request;
use Validator;

class ListaProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista_producto = lista_productos::join('productos', 'productos.id', '=', 'lista_productos.id_producto')
            ->select('lista_productos.*', 'productos.nombre')
            ->get();
        return response()->json(['status'=>'ok','data'=>$lista_producto], 200);
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
            'id_producto' => 'required|exists:productos,id',
            'id_bar' => 'required|exists:bars,id',
            'precio' => 'required|numeric'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $lista_productos = lista_productos::where([
            ['id_producto', '=', $request->id_producto],
            ['id_bar', '=', $request->id_bar],
        ])->first();

        if (isset($lista_productos)) {
			return response()->json([
                'message' => 'Esta lista_productos ya se encuentra registrada'
            ], 404);
		}

        $lista_productos = new lista_productos([      
            'id_producto' => $request->id_producto,
            'id_bar'  => $request->id_bar,
            'precio'  => $request->precio
        ]);

        $lista_productos->save();
        return response()->json([
            'message' => 'lista_productos Registrada'], 200);
    }

    public function show($id_bar, $id_producto)
    {
        $lista_productos = lista_productos::where([
                ['id_producto', '=', $id_producto],
                ['id_bar', '=', $id_bar],
            ])->join('productos', 'productos.id', '=', 'lista_productos.id_producto')
            ->select('lista_productos.*', 'productos.nombre')
            ->get();

        if (!$lista_productos) {
			return response()->json([
                'message'=>'No se encuentra una lista_productos con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$lista_productos],200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id_producto' => 'required|exists:users,id',
            'id_bar' => 'required|exists:bars,id',
            'precio' => 'required|numeric'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $lista_productos = lista_productos::where([
            ['id_producto', '=', $request->id_producto],
            ['id_bar', '=', $request->id_bar],
        ])->first();

        if (!isset($lista_productos)) {
			return response()->json([
                'message' => 'Esta lista_productos no existe'
            ], 404);
		}

        $lista_productos = lista_productos::where([
            ['id_producto', '=', $request->id_producto],
            ['id_bar', '=', $request->id_bar],
        ])            
        ->update(['precio'  => $request->precio]);

        return response()->json([
            'message' => 'lista_productos Actualizada'], 200);
    }

    public function porBar($id_bar)
    {
        $lista_productos = lista_productos::where('id_bar', '=', $id_bar)
            ->join('productos', 'productos.id', '=', 'lista_productos.id_producto')
            ->select('lista_productos.*', 'productos.nombre')
            ->get();
        if (!$lista_productos) {
			return response()->json([
                'message'=>'No se encuentra una lista_productos con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$lista_productos],200);
    }

    public function destroy($id_bar, $id_producto)
    {
        $lista_productos = lista_productos::where([
            ['id_producto', '=', $id_producto],
            ['id_bar', '=', $id_bar],
        ])->first();

        if (!$lista_productos) {
			return response()->json([
                'message' => 'No se encuentra una lista_productos con ese código.'
            ], 404);
		}
        lista_productos::where([
            ['id_producto', '=', $id_producto],
            ['id_bar', '=', $id_bar],
        ])->delete();

        return response()->json([
            'message' => 'lista_productos Eliminada'], 200);
    }
}
