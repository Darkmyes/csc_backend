<?php

namespace App\Http\Controllers;

use App\menu_diario;
use Illuminate\Http\Request;
use Validator;

class MenuDiarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista_producto = menu_diario::join('productos', 'productos.id', '=', 'menu_diarios.id_producto')
            ->select('menu_diarios.*', 'productos.nombre')
            ->get();
        return response()->json([ "data" => $lista_producto], 200);
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
            'precio' => 'required|numeric',
            'fecha' => 'required|date'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $menu_diario = menu_diario::where([
            ['id_producto', '=', $request->id_producto],
            ['id_bar', '=', $request->id_bar],
        ])->first();

        if (isset($menu_diario)) {
			return response()->json([
                'message' => 'Est Producto del Menu Diario ya se encuentra registrado'
            ], 404);
		}

        $menu_diario = new menu_diario([      
            'id_producto' => $request->id_producto,
            'id_bar'  => $request->id_bar,
            'precio'  => $request->precio,
            'fecha' => $request->fecha,
        ]);

        $menu_diario->save();
        return response()->json([
            'message' => 'Producto del Menu Diario Registrado'], 200);
    }

    public function show($id_bar, $id_producto)
    {
        $menu_diario = menu_diario::where([
                ['id_producto', '=', $id_producto],
                ['id_bar', '=', $id_bar],
            ])->join('productos', 'productos.id', '=', 'menu_diario.id_producto')            
            ->select('menu_diario.*', 'productos.nombre')
            ->get();

        if (!$menu_diario) {
			return response()->json([
                'message'=>'No se encuentra una menu_diario con ese código.'],404);
		}
		return response()->json([ "data" => $menu_diario],200);
    }

    public function update(Request $request, $id_menu) {
        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric',
            'fecha' => 'required|date'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $menu_diario = menu_diario::find($id_menu);

        if (!isset($menu_diario)) {
			return response()->json([
                'message' => 'Este Producto del Menu Diario no existe'
            ], 404);
		}

        $menu_diario->precio = $request->precio;
        $menu_diario->fecha = $request->fecha;

        return response()->json([
            'message' => 'Producto del Menu Diario Actualizado'], 200);
    }

    public function porBar($id_bar)
    {
        $menu_diario = menu_diario::where('id_bar', '=', $id_bar)
            ->join('productos', 'productos.id', '=', 'menu_diarios.id_producto')
            ->orderBy('fecha')
            ->select('menu_diarios.*', 'productos.nombre')
            ->get();
        if (!$menu_diario) {
			return response()->json([
                'message'=>'No se encuentra un Producto del Menu Diario con ese código.'],404);
		}
		return response()->json([ "data" => $menu_diario],200);
    }

    public function porBarFecha($id_bar,$fecha)
    {
        $menu_diario = menu_diario::where([
                ['id_bar', '=', $id_bar],
                ['fecha', '=', $fecha]
            ])
            ->join('productos', 'productos.id', '=', 'menu_diarios.id_producto')
            ->select('menu_diarios.*', 'productos.nombre')
            ->get();
        if (!$menu_diario) {
			return response()->json([
                'message'=>'No se encuentra un Producto del Menu Diario con ese código.'],404);
		}
		return response()->json([ "data" => $menu_diario],200);
    }

    public function porFecha($fecha)
    {
        $menu_diario = menu_diario::where([
                ['fecha', '=', $fecha]
            ])
            ->join('productos', 'productos.id', '=', 'menu_diarios.id_producto')
            ->orderBy('id_bar')
            ->select('menu_diarios.*', 'productos.nombre')
            ->get();
        if (!$menu_diario) {
			return response()->json([
                'message'=>'No se encuentra un Producto del Menu Diario con ese código.'],404);
		}
		return response()->json([ "data" => $menu_diario],200);
    }

    public function destroy($id_menu)
    {
        $menu_diario = menu_diario::find($id_menu);

        if (!$menu_diario) {
			return response()->json([
                'message' => 'No se encuentra un Producto del Menu Diario con ese código.'
            ], 404);
		}
        $menu_diario->delete();

        return response()->json([
            'message' => 'Producto del Menu Diario Eliminado'], 200);
    }
}
