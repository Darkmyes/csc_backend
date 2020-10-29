<?php

namespace App\Http\Controllers;

use App\producto_categoria;
use Illuminate\Http\Request;
use Validator;

class ProductoCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lista_producto = producto_categoria::join('productos', 'productos.id', '=', 'producto_categorias.id_producto')
            ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'producto_categorias.id_categoria')
            ->select('producto_categorias.*', 'productos.nombre as producto', 'categoria_alimentos.nombre as categoria')
            ->get();
        return response()->json(['data' => $lista_producto], 200);
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
            'id_categoria' => 'required|exists:categoria_alimentos,id'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $producto_categoria = producto_categoria::where([
            ['id_producto', '=', $request->id_producto],
            ['id_categoria', '=', $request->id_categoria],
        ])->first();

        if (isset($producto_categoria)) {
			return response()->json([
                'message' => 'Este Categoria Producto ya se encuentra registrado'
            ], 404);
		}

        $producto_categoria = new producto_categoria([      
            'id_producto' => $request->id_producto,
            'id_categoria'  => $request->id_categoria
        ]);

        $producto_categoria->save();
        return response()->json([
            'message' => 'Categoria Producto Registrado'], 200);
    }

    public function show($id_categoria, $id_producto)
    {
        $producto_categoria = producto_categoria::where([
                ['id_producto', '=', $id_producto],
                ['id_categoria', '=', $id_categoria],
            ])->join('productos', 'productos.id', '=', 'producto_categorias.id_producto')
            ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'producto_categorias.id_categoria')
            ->select('producto_categorias.*', 'productos.nombre as producto', 'categoria_alimentos.nombre as categoria')
            ->get();

        if (!$producto_categoria) {
			return response()->json([
                'message'=>'No se encuentra una producto_categoria con ese código.'],404);
		}
		return response()->json(['data' => $producto_categoria],200);
    }

    public function update(Request $request, $id_menu) {
        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric',
            'fecha' => 'required|date'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $producto_categoria = producto_categoria::find($id_menu);

        if (!isset($producto_categoria)) {
			return response()->json([
                'message' => 'Este Categoria Producto no existe'
            ], 404);
		}

        $producto_categoria->precio = $request->precio;
        $producto_categoria->fecha = $request->fecha;

        return response()->json([
            'message' => 'Categoria Producto Actualizado'], 200);
    }

    public function porCategoria($id_categoria)
    {
        $producto_categoria = producto_categoria::where('id_categoria', '=', $id_categoria)
            ->join('productos', 'productos.id', '=', 'producto_categorias.id_producto')
            ->select('producto_categorias.*', 'productos.nombre as producto')
            ->get();
        if (!$producto_categoria) {
			return response()->json([
                'message'=>'No se encuentra un Categoria Producto con ese código.'],404);
		}
		return response()->json(['data' => $producto_categoria],200);
    }

    public function porProducto($id_producto)
    {
        $producto_categoria = producto_categoria::where([
                ['id_producto', '=', $id_producto],
            ])
            ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'producto_categorias.id_categoria')
            ->select('producto_categorias.*','categoria_alimentos.nombre as categoria')
            ->get();
        if (!$producto_categoria) {
			return response()->json([
                'message'=>'No se encuentra un Categoria Producto con ese código.'],404);
		}
		return response()->json(['data' => $producto_categoria],200);
    }

    public function porFecha($fecha)
    {
        $producto_categoria = producto_categoria::where([
                ['fecha', '=', $fecha]
            ])
            ->join('productos', 'productos.id', '=', 'producto_categorias.id_producto')
            ->orderBy('id_categoria')
            ->select('producto_categorias.*', 'productos.nombre')
            ->get();
        if (!$producto_categoria) {
			return response()->json([
                'message'=>'No se encuentra un Categoria Producto con ese código.'],404);
		}
		return response()->json(['data' => $producto_categoria],200);
    }

    public function destroy($id_categoria, $id_producto)
    {
        $producto_categoria = producto_categoria::where([
                ['id_producto', '=', $id_producto],
                ['id_categoria', '=', $id_categoria],
            ])->get();

        if (!$producto_categoria) {
			return response()->json([
                'message' => 'No se encuentra un Categoria Producto con ese código.'
            ], 404);
        }
        
        producto_categoria::where([
            ['id_producto', '=', $id_producto],
            ['id_categoria', '=', $id_categoria],
        ])->delete();

        return response()->json([
            'message' => 'Categoria Producto Eliminado'], 200);
    }
}
