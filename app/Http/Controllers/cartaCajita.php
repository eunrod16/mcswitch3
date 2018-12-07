<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class cartaCajita extends Controller
{
    public function index(){
      $productos = DB::table('carta_cajita')
      ->select('codigo_producto', 'nombre','imagen')
      ->groupBy('codigo_producto','nombre','imagen')->get();
      $restaurantes = DB::table('localizacion')
      ->pluck('nombre', 'codigo')->prepend('Elige un restaurante',0)->toArray();
      return view('carta_cajita.index', ['productos' => $productos, 'restaurantes' => $restaurantes]);
    }
    public function getData(){
      $productos = DB::table('carta_cajita')
      ->select('codigo_producto', 'nombre','imagen')
      ->groupBy('codigo_producto','nombre','imagen')->get();
      return response()->json($productos);
    }
    public function crearNuevo(Request $req){
      $codigos_localizacion = DB::table('localizacion')->select('codigo')->get();
      foreach ($codigos_localizacion as $key => $loc) {
        DB::table('carta_cajita')->insert(
            ['nombre' => $req->nombre,
             'codigo_localizacion' => $loc->codigo,
             'codigo_producto' => $req->codigo_producto,
             'categoria' => $req->categoria,
             'imagen' => $req->imagen,
             'active' => 1
          ]
        );
        DB::table('producto')->insert(
            ['codigo' => $req->codigo_producto,
             'nombre' => $loc->nomm,
             'precio1' => $req->precio
          ]
        );
      }
      return response()->json(1);
    }
    public function setData(Request $req){
    $datas = $req->data;
    foreach ($datas as $key => $value) {
      $data =$value;
    }
    DB::table('carta_cajita')
    ->where('codigo_producto', $data["codigo_producto"])

    ->update(['imagen' => $data["imagen"]], ['nombre' => $data["nombre"]]);

    $output = '{
        "data": [
          {
            "DT_RowId": '.$data["codigo_producto"].',
            "codigo_producto": '.$data["codigo_producto"].',
            "nombre": "'.$data["nombre"].'",
            "imagen": "'.$data["imagen"].'",
            "acciones": "'.$data["acciones"].'"
          }
        ]
      }';
      return response()->json($output);
    }

    public function export(Request $req){
      $productos = DB::table('carta_cajita')//
      ->select('codigo_localizacion as Codigo De Localizacion{editor-type:text;size:5}',
      'codigo_producto as Codigo De Producto{editor-type:text;size:5}',
      'nombre as Nombre{editor-type:text;size:15}','imagen as Imagen{editor-type:text;size:15}',
      'categoria as Categoria{editor-type:text;size:15}', 'active as Active{editor-type:checkbox;local-edit:false}',
      'precio_reemplazo as Precio Reemplazo{editor-type:text;size:5}')
      ->orderBy('codigo_localizacion')->get();
      return response()->json($productos);
    }

    public function segmentacion(Request $req){
      $activos = DB::table('carta_cajita')
      ->select('codigo_localizacion')
      ->where('codigo_producto','=',$req->cod)
      ->where('active','=',1)->get();
      $inactivos = DB::table('carta_cajita')
      ->select('codigo_localizacion')
      ->where('codigo_producto','=',$req->cod)
      ->where('active','=',0)->get();
      return view('carta_cajita.segmentacion', ['activos' => $activos,'inactivos' => $inactivos])->renderSections()['content'];;
    }
    public function GuardarSegmentacion(Request $req){
      $agregados = $req->agregados;
      $eliminados = $req->eliminados;
      if(count($agregados)>0){
        DB::table('carta_cajita')
              ->whereIn('codigo_localizacion', $agregados)
              ->update(['active' => 1]);
      }
      if(count($eliminados)>0){
        DB::table('carta_cajita')
              ->whereIn('codigo_localizacion', $eliminados)
              ->update(['active' => 0]);
      }


      return 1;
    }
}
