<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Clientes;
use App\Models\Facturas;
use App\Models\Facturas_Detalle;
use App\Models\Productos;

class FacturasController extends Controller
{
    public function facturar(){
        return view('facturar');
    }

    public function consulta(){
        return DB::table('alp_facturas')->select(
            DB::raw('(SELECT NOMBRE_CLIENTE FROM alp_clientes WHERE alp_clientes.ID_CLIENTE = alp_facturas.ID_CLIENTE) AS CLIENTE'),
            'ID_FACTURA',
            'ID_CLIENTE',
            'FOLIO',
            'FECHA_FACTURA',
            'TOTAL'
        )->get();
    }

    public function crearFactura(){
        $factura = new Facturas;
        $factura->save();
        
        return response()->json(["id" => $factura->ID_FACTURA], 200);
        
    }

    public function guardarDatosFactura(Request $request){
        $factura = Facturas::find($request->ID_FACTURA);
        $factura->ID_CLIENTE = $request->ID_CLIENTE;
        $factura->FECHA_FACTURA = $request->FECHA_FACTURA;
        $factura->FOLIO = $request->FOLIO;
        $factura->TOTAL = $request->TOTAL;
        $factura->save();
        
        return response()->json(200);
    }

    public function guardarProducto(Request $request){
        $detalle = new Facturas_Detalle;
        $detalle->ID_FACTURA = $request->ID_FACTURA_PRODUCTOS;
        $detalle->ID_PRODUCTO = $request->ID_PRODUCTO;
        $detalle->CANTIDAD = $request->CANTIDAD;
        $detalle->IMPORTE = $request->IMPORTE;
        $detalle->save();

        return $this->consultaDetalleFactura($request->ID_FACTURA_PRODUCTOS);
    }

    public function eliminarProducto($ID_FACTURA_DETALLE){
        
        $ID_FACTURA = DB::table('alp_facturas_detalle')->select('ID_FACTURA')->where('ID_FACTURA_DETALLE','=',$ID_FACTURA_DETALLE)->get();
        $ID_FACTURA = $ID_FACTURA[0]->ID_FACTURA;

        Facturas_Detalle::where('ID_FACTURA_DETALLE','=', $ID_FACTURA_DETALLE)->delete();
        
        
        return $this->consultaDetalleFactura($ID_FACTURA);
    }

    public function consultaDetalleFactura($ID_FACTURA = 0){
        // return DB::table('alp_facturas_detalle')->where('ID_FACTURA','=',$ID_FACTURA)->get();

        return DB::table('alp_facturas_detalle')->select(
            DB::raw('(SELECT NOMBRE_PRODUCTO FROM alp_productos WHERE alp_productos.ID_PRODUCTO = alp_facturas_detalle.ID_PRODUCTO) AS PRODUCTO'),
            DB::raw('(SELECT PRECIO FROM alp_productos WHERE alp_productos.ID_PRODUCTO = alp_facturas_detalle.ID_PRODUCTO) AS PRECIO'),
            'ID_FACTURA_DETALLE',
            'ID_FACTURA',
            'ID_PRODUCTO',
            'CANTIDAD',
            'IMPORTE'
        )->where('ID_FACTURA','=',$ID_FACTURA)->get();
    }

    public function consultaProductos(){
        return DB::table('alp_productos')->get();
    }

    public function consultaClientes(){
        return DB::table('alp_clientes')->get();
    }

    public function eliminarFactura($ID_FACTURA){
        
        Facturas_Detalle::where('ID_FACTURA','=', $ID_FACTURA)->delete();
        Facturas::where('ID_FACTURA','=', $ID_FACTURA)->delete();
        
        return $this->consultaDetalleFactura($ID_FACTURA);
    }
}
