<?php

namespace App\Http\Controllers;

use App\restricciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class RestriccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
        ('id_causante');
            $table->bigInteger('id_restriccion');
            $table->enum('tipo', ['parcial', 'completa']);
            $table->enum('por', ['alergia', 'enfermedad', 'estilo_vida']);
            $table->enum('de', ['componente', 'categoria_alimento']);
    */

    public function index()
    {
        // ALERGIAS
        $r_alergias = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
            ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'alergias.nombre as causante', 'componentes.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"alergia"],
                ['restricciones.de','=',"componente"]
            ])
            ->get();
        $r_alergias2 = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
            ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'alergias.nombre as causante', 'categoria_alimentos.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"alergia"],
                ['restricciones.de','=',"categoria_alimento"]
            ])
            ->get();
        // ENFERMEDADES
        $r_enfermedades = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
            ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'enfermedades.nombre as causante', 'componentes.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"enfermedad"],
                ['restricciones.de','=',"componente"]
            ])
            ->get();
        $r_enfermedades2 = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
        ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'enfermedades.nombre as causante', 'categoria_alimentos.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"enfermedad"],
                ['restricciones.de','=',"categoria_alimento"]
            ])
            ->get();
        // ESTILO DE VIDA
        $r_estilos = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
            ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'componentes.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"estilo_vida"],
                ['restricciones.de','=',"componente"]
            ])
            ->get();
        $r_estilos2 = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
        ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
            ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'categoria_alimentos.nombre as restriccion')
            ->where([
                ['restricciones.por','=',"estilo_vida"],
                ['restricciones.de','=',"categoria_alimento"]
            ])
            ->get();
        $r_total = $r_alergias->merge($r_alergias2);
        $r_total = $r_total->merge($r_enfermedades);
        $r_total = $r_total->merge($r_enfermedades2);
        $r_total = $r_total->merge($r_estilos);
        $r_total = $r_total->merge($r_estilos2);
        return response()->json(['status' => 'ok','data' => $r_total], 200);
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
            'id_causante' => 'required',
            'id_restriccion' => 'required',
            'tipo' => 'required|in:parcial,completa',
            'por' => 'required|in:alergia,enfermedad,estilo_vida',
            'de' => 'required|in:componente,categoria_alimento'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $error = false;
        $errores = array();

        if($request->por == 'alergia') {
            $alergia = DB::table('alergias')->find($request->id_causante);
            if(!$alergia) {
                $error = true;
                array_push($errores, 'No existe la alergia especificada');
            }
        }

        if($request->por == 'enfermedades') {
            $enfermedad = DB::table('enfermedades')->find($request->id_causante);
            if(!$enfermedad) {
                $error = true;
                array_push($errores, 'No existe la enfermedad especificada');
            }
        }

        if($request->por == 'estilo_vida') {
            $estilo_vida = DB::table('estilos_vidas')->find($request->id_causante);
            if(!$estilo_vida) {
                $error = true;
                array_push($errores, 'No existe el estilo de vida especificada');
            }
        }

        if($request->de == 'componente') {
            $componente = DB::table('componentes')->find($request->id_restriccion);
            if(!$componente) {
                $error = true;
                array_push($errores, 'No existe el componente especificada');
            }
        }

        if($request->de == 'categoria_alimento') {
            $categoria_alimento = DB::table('categoria_alimentos')->find($request->id_restriccion);
            if(!$categoria_alimento) {
                $error = true;
                array_push($errores, 'No existe la categoria de alimentos especificada');
            }
        }

        if($error) {
            return response()->json(['errores' => $errores], 400);
        }

        $restricciones = new restricciones([      
            'id_causante' => $request->id_causante,
            'id_restriccion' => $request->id_restriccion,
            'tipo' => $request->tipo,
            'por' => $request->por,
            'de' => $request->de
        ]);

        $restricciones->save();
        return response()->json([
            'message' => 'Restriccion Registrada'], 200);
    }

    public function show($id)
    {
        $restricciones = restricciones::find($id);

        if (!$restricciones) {
			return response()->json([
                'message'=>'No se encuentra una restricciones con ese código.'],404);
		}
		return response()->json([$restricciones],200);
    }

    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'tipo' => 'required|in:parcial,completa',
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $restriccion = restricciones::find($id);
        $restriccion->tipo = $request->tipo;

        $restriccion->save();
        return response()->json([
            'message' => 'Restriccion Actualizada'], 200);
    }

    public function porCausante($causante)
    {
        $validator = Validator::make(["causante" => $causante], [
            'causante' => 'in:alergia,enfermedad,estilo_vida'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $r_total = [];
        if($causante == "alergia") {
            $r_alergias = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_alergias2 = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_total = $r_alergias->merge($r_alergias2);
        } else if($causante == "enfermedad") {
            $r_enfermedades = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_enfermedades2 = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_total = $r_enfermedades->merge($r_enfermedades2);
        } else if($causante == "estilo_vida") {
            $r_estilos = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_estilos2 = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_total = $r_estilos->merge($r_estilos2);
        }
        return response()->json(['status' => 'ok','data' => $r_total], 200);
    }

    public function porRestriccion($restriccion)
    {
        $validator = Validator::make(["restriccion" => $restriccion], [
            'restriccion' => 'in:componente,categoria_alimento'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $r_total = [];
        if($restriccion == "componente") {
            $r_alergias = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_enfermedades = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_estilos = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"componente"]
                ])
                ->get();
            $r_total = $r_alergias->merge($r_enfermedades);
            $r_total = $r_total->merge($r_estilos);
        } else if($restriccion == "categoria_alimento") {            
            $r_alergias2 = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_enfermedades2 = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_estilos2 = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"categoria_alimento"]
                ])
                ->get();
            $r_total = $r_alergias2->merge($r_enfermedades2);
            $r_total = $r_total->merge($r_estilos2);
        }
        return response()->json(['status' => 'ok','data' => $r_total], 200);
    }

    public function porCausanteNombre($causante, $nombre)
    {
        $validator = Validator::make(["causante" => $causante], [
            'causante' => 'in:alergia,enfermedad,estilo_vida'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $r_total = [];
        if($causante == "alergia") {
            $r_alergias = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"componente"],
                    ['alergias.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_alergias2 = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['alergias.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_total = $r_alergias->merge($r_alergias2);
        } else if($causante == "enfermedad") {
            $r_enfermedades = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"componente"],
                    ['enfermedades.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_enfermedades2 = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['enfermedades.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_total = $r_enfermedades->merge($r_enfermedades2);
        } else if($causante == "estilo_vida") {
            $r_estilos = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"componente"],
                    ['estilos_vidas.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_estilos2 = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['estilos_vidas.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_total = $r_estilos->merge($r_estilos2);
        }
        return response()->json(['status' => 'ok','data' => $r_total], 200);
    }

    public function porRestriccionNombre($restriccion, $nombre)
    {
        $validator = Validator::make(["restriccion" => $restriccion], [
            'restriccion' => 'in:componente,categoria_alimento'
        ]);
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $r_total = [];
        if($restriccion == "componente") {
            $r_alergias = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"componente"],
                    ['componentes.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_enfermedades = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"componente"],
                    ['componentes.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_estilos = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('componentes', 'componentes.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'componentes.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"componente"],
                    ['componentes.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_total = $r_alergias->merge($r_enfermedades);
            $r_total = $r_total->merge($r_estilos);
        } else if($restriccion == "categoria_alimento") {            
            $r_alergias2 = restricciones::join('alergias', 'alergias.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'alergias.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"alergia"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['categoria_alimentos.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_enfermedades2 = restricciones::join('enfermedades', 'enfermedades.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'enfermedades.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"enfermedad"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['categoria_alimentos.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_estilos2 = restricciones::join('estilos_vidas', 'estilos_vidas.id', '=', 'restricciones.id_causante')
                ->join('categoria_alimentos', 'categoria_alimentos.id', '=', 'restricciones.id_restriccion')
                ->select('restricciones.*', 'estilos_vidas.nombre as causante', 'categoria_alimentos.nombre as restriccion')
                ->where([
                    ['restricciones.por','=',"estilo_vida"],
                    ['restricciones.de','=',"categoria_alimento"],
                    ['categoria_alimentos.nombre','like','%'.$nombre.'%']
                ])
                ->get();
            $r_total = $r_alergias2->merge($r_enfermedades2);
            $r_total = $r_total->merge($r_estilos2);
        }
        return response()->json(['status' => 'ok','data' => $r_total], 200);
    }

    public function destroy($id)
    {
        $restricciones = restricciones::find($id);

        if (!$restricciones) {
			return response()->json([
                'message' => 'No se encuentra un Restriccion con ese código.'
            ], 404);
		}
        $restricciones->delete();

        return response()->json([
            'message' => 'Restriccion Eliminada'], 200);
    }
}
