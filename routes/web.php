<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacturasController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[FacturasController::class, 'facturar']);
Route::get('consulta',[FacturasController::class, 'consulta']);
Route::get('crearFactura',[FacturasController::class, 'crearFactura']);
Route::post('guardarDatosFactura',[FacturasController::class, 'guardarDatosFactura']);
Route::post('guardarProducto',[FacturasController::class, 'guardarProducto']);
Route::get('eliminarProducto/{id}',[FacturasController::class, 'eliminarProducto']);
Route::get('consultaClientes',[FacturasController::class, 'consultaClientes']);
Route::get('consultaProductos',[FacturasController::class, 'consultaProductos']);
Route::get('eliminarFactura/{id}',[FacturasController::class, 'eliminarFactura']);
Route::get('consultaDetalleFactura/{id}',[FacturasController::class, 'consultaDetalleFactura']);