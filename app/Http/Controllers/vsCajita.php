<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class vsCajita extends Controller
{
    public function index(){
      $productos = DB::table('vs_cajita')
      ->select('codigo_producto', 'nombre','imagen')
      ->groupBy('codigo_producto','nombre','imagen')->get();
      return view('vs_cajita.index', ['productos' => $productos]);
    }
    public function getData(){
      $productos = DB::table('vs_cajita')
      ->select('codigo_producto', 'nombre','imagen')
      ->groupBy('codigo_producto','nombre','imagen')->get();
      return response()->json($productos);
    }

    public function setData(Request $req){
    $datas = $req->data;
    foreach ($datas as $key => $value) {
      $data =$value;
    }
    DB::table('vs_cajita')
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
      $productos = DB::table('vs_cajita')//
      ->select('codigo_localizacion as Codigo De Localizacion{editor-type:text;size:5}',
      'codigo_producto as Codigo De Producto{editor-type:text;size:5}',
      'nombre as Nombre{editor-type:text;size:15}','imagen as Imagen{editor-type:text;size:15}',
      'categoria as Categoria{editor-type:text;size:15}', 'active as Active{editor-type:checkbox;local-edit:false}',
      'precio_reemplazo as Precio Reemplazo{editor-type:text;size:5}')
      ->orderBy('codigo_localizacion')->get();
      return response()->json($productos);
    }

    public function segmentacion(Request $req){
      $activos = DB::table('vs_cajita')
      ->select('codigo_localizacion')
      ->where('codigo_producto','=',$req->cod)
      ->where('active','=',1)->get();
      $inactivos = DB::table('vs_cajita')
      ->select('codigo_localizacion')
      ->where('codigo_producto','=',$req->cod)
      ->where('active','=',0)->get();
      return view('vs_cajita.segmentacion', ['activos' => $activos,'inactivos' => $inactivos])->renderSections()['content'];;
    }
    public function GuardarSegmentacion(Request $req){
      $agregados = $req->agregados;
      $eliminados = $req->eliminados;
      if(count($agregados)>0){
        DB::table('vs_cajita')
              ->whereIn('codigo_localizacion', $agregados)
              ->update(['active' => 1]);
      }
      if(count($eliminados)>0){
        DB::table('vs_cajita')
              ->whereIn('codigo_localizacion', $eliminados)
              ->update(['active' => 0]);
      }


      return 1;
    }
}
