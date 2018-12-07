<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class precio extends Controller
{
    public function index(){

    }
    public function getPrecioReemplazo(Request $req){
      $productos = DB::table($req->categoria)
      ->select('codigo_producto',DB::raw('precio_reemplazo as precio'))
      ->where('codigo_producto', $req->codigo_producto)
      ->where('codigo_localizacion', $req->codigo_localizacion)
      ->where('precio_reemplazo','!=','')
      ->get();

      if($productos->count()==0){
        $productos = DB::table('producto')
        ->select('codigo', DB::raw('precio1 as precio'))
        ->where('codigo', $req->codigo_producto)
        ->get();
      }

      return response()->json($productos);
    }
    public function guardarPrecioReemplazo(Request $req){
        DB::table($req->categoria)
        ->where('codigo_producto', $req->codigo_producto)
        ->where('codigo_localizacion', $req->codigo_localizacion)
        ->update(['precio_reemplazo' => $req->precio_reemplazo]);
      return response()->json(1);
    }

}
