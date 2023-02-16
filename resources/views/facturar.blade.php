<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <title>Factura</title>
</head>
<body>
    
    <div class="row">
        <div class="col">
            <h1>FACTURAS</h1>        
        </div>
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" id="btnNuevaFactura">
                Nueva Factura
            </button>
        </div>
    </div>

    <table id="facturasTable">
        <thead>
            <tr>
                <th>ID_FACTURA</th>
                <th>Folio</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="frmFacturaModal" tabindex="-1" aria-labelledby="frmFacturaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="frmFacturaModalLabel">Nueva Factura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="guardarDatosFactura" id="frmFactura">
                    <!-- Campo oculto -->
                    <div hidden>
                        <input type="text" name="ID_FACTURA" id="ID_FACTURA">
                    </div>

                    <div class="row">
                        <div class="col">
                            Cliente:
                            <select name="ID_CLIENTE" id="ID_CLIENTE" style="width:150px">
                                <option value="1">Cliente 1</option>
                            </select>
                        </div>
                        <div class="col">
                            Fecha: <input type="date" name="FECHA_FACTURA" id="FECHA_FACTURA">
                        </div>
                        <div class="col">
                            Folio: <input type="text" name="FOLIO" id="FOLIO">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            Total: <input type="text" name="TOTAL" id="TOTAL" style="width:108px" value="0" readonly>
                        </div>
                    </div>
                </form>

                <br><br>

                <form action="guardarProducto" id="frmProductos">
                    <!-- Campo oculto -->
                    <div hidden>
                        <input type="text" name="ID_FACTURA_PRODUCTOS" id="ID_FACTURA_PRODUCTOS">
                    </div>

                    <div class="table-responsive">
                        <table id="detalleFaturaTable" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        Prodcuto <br>
                                        <select name="ID_PRODUCTO" id="ID_PRODUCTO" style="width:200px">
                                            <option value="1">producto 1</option>
                                        </select>
                                    </th>
                                    <th>
                                        Precio unitario <br>
                                        <input type="text" name="PRECIO_UNITARIO" id="PRECIO_UNITARIO" value="0" style="width:100px" readonly>
                                    </th>
                                    <th>
                                        Cantidad <br>
                                        <input type="number" name="CANTIDAD" id="CANTIDAD" value="0" style="width:75px">
                                    </th>
                                    <th>
                                        Importe <br>
                                        <input type="text" name="IMPORTE" id="IMPORTE" value="0" style="width:70px"readonly>
                                    </th>
                                    <th>
                                        <button type="button" id="btnAgregarProducto">Agregar</button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnGuardarCambiosFactura">Guardar cambios</button>
            </div>
            </div>
        </div>
    </div>



    <!-- Este es mi arcivho js va al final del body para que no marue errores -->
    <script src="{{ asset('jquery/jquery-3.6.1.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>