<?php

namespace App\Http\Controllers;

use App\productos_componentes;
use Illuminate\Http\Request;
use Validator;

class ProductosComponentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista_producto = productos_componentes::join('productos', 'productos.id', '=', 'productos_componentes.id_producto')
            ->join('componentes', 'componentes.id', '=', 'productos_componentes.id_componente')
            ->select('productos_componentes.*', 'productos.nombre as producto', 'componentes.nombre as componente')
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
            'id_componente' => 'required|exists:componentes,id'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $productos_componentes = productos_componentes::where([
            ['id_producto', '=', $request->id_producto],
            ['id_componente', '=', $request->id_componente],
        ])->first();

        if (isset($productos_componentes)) {
			return response()->json([
                'message' => 'Este componente Producto ya se encuentra registrado'
            ], 404);
		}

        $productos_componentes = new productos_componentes([      
            'id_producto' => $request->id_producto,
            'id_componente'  => $request->id_componente
        ]);

        $productos_componentes->save();
        return response()->json([
            'message' => 'componente Producto Registrado'], 200);
    }

    public function show($id_componente, $id_producto)
    {
        $productos_componentes = productos_componentes::where([
                ['id_producto', '=', $id_producto],
                ['id_componente', '=', $id_componente],
            ])->join('productos', 'productos.id', '=', 'productos_componentes.id_producto')
            ->join('componentes', 'componentes.id', '=', 'productos_componentes.id_componente')
            ->select('productos_componentes.*', 'productos.nombre as producto', 'componentes.nombre as componente')
            ->get();

        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra una productos_componentes con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function update(Request $request, $id_menu) {
        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric',
            'fecha' => 'required|date'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $productos_componentes = productos_componentes::find($id_menu);

        if (!isset($productos_componentes)) {
			return response()->json([
                'message' => 'Este componente Producto no existe'
            ], 404);
		}

        $productos_componentes->precio = $request->precio;
        $productos_componentes->fecha = $request->fecha;

        return response()->json([
            'message' => 'componente Producto Actualizado'], 200);
    }

    public function productoPorComponente($id_componente)
    {
        $productos_componentes = productos_componentes::where('id_componente', '=', $id_componente)
            ->join('productos', 'productos.id', '=', 'productos_componentes.id_producto')
            ->select('productos_componentes.*', 'productos.nombre as producto')
            ->get();
        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra un componente Producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function productoPorComponenteNombre($id_componente, $nombre)
    {
        $productos_componentes = productos_componentes::where([
                ['id_componente', '=', $id_componente],
                ['nombre', 'like', '%'.$nombre.'%'],
            ])
            ->join('productos', 'productos.id', '=', 'productos_componentes.id_producto')
            ->select('productos_componentes.*', 'productos.nombre as producto')
            ->get();
        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra un componente Producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function porProducto($id_producto)
    {
        $productos_componentes = productos_componentes::where([
                ['id_producto', '=', $id_producto],
            ])
            ->join('componentes', 'componentes.id', '=', 'productos_componentes.id_componente')
            ->select('productos_componentes.*','componentes.nombre as componente')
            ->get();
        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra un componente Producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function porProductoNombre($id_producto, $nombre)
    {
        $productos_componentes = productos_componentes::where([
                ['id_producto', '=', $id_producto],
                ['nombre', 'like', '%'.$nombre.'%'],
            ])
            ->join('componentes', 'componentes.id', '=', 'productos_componentes.id_componente')
            ->select('productos_componentes.*','componentes.nombre as componente')
            ->get();
        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra un componente Producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function porFecha($fecha)
    {
        $productos_componentes = productos_componentes::where([
                ['fecha', '=', $fecha]
            ])
            ->join('productos', 'productos.id', '=', 'productos_componentes.id_producto')
            ->orderBy('id_componente')
            ->select('productos_componentes.*', 'productos.nombre')
            ->get();
        if (!$productos_componentes) {
			return response()->json([
                'message'=>'No se encuentra un componente Producto con ese código.'],404);
		}
		return response()->json(['status'=>'ok','data'=>$productos_componentes],200);
    }

    public function destroy($id_componente, $id_producto)
    {
        $productos_componentes = productos_componentes::where([
                ['id_producto', '=', $id_producto],
                ['id_componente', '=', $id_componente],
            ])->get();

        if (!$productos_componentes) {
			return response()->json([
                'message' => 'No se encuentra un componente Producto con ese código.'
            ], 404);
        }
        
        productos_componentes::where([
            ['id_producto', '=', $id_producto],
            ['id_componente', '=', $id_componente],
        ])->delete();

        return response()->json([
            'message' => 'componente Producto Eliminado'], 200);
    }
}
