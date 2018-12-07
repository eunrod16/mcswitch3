<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'cartaCajita'],function(){
  Route::get('', 'cartaCajita@index');
  Route::get ('segmentacion', 'cartaCajita@segmentacion' );
  Route::get ('getData', 'cartaCajita@getData' );
  Route::post ('setData', 'cartaCajita@setData' );
  Route::get ('export', 'cartaCajita@export' );
  Route::post ('crearNuevo', 'cartaCajita@crearNuevo' );
  Route::post ('GuardarSegmentacion', 'cartaCajita@GuardarSegmentacion' );
});
Route::get ('getPrecioReemplazo', 'precio@getPrecioReemplazo' );
Route::post ('guardarPrecioReemplazo', 'precio@guardarPrecioReemplazo' );
Route::group(['prefix'=>'vsCajita'],function(){
  Route::get('', 'vsCajita@index');
  Route::get ('segmentacion', 'vsCajita@segmentacion' );
  Route::get ('getData', 'vsCajita@getData' );
  Route::post ('setData', 'vsCajita@setData' );
  Route::get ('export', 'vsCajita@export' );
  Route::post ('GuardarSegmentacion', 'vsCajita@GuardarSegmentacion' );
});
