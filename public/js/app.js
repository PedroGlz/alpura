/* Variables */
var numId = 0,select,selectString;
var tabla_facturas ="";
const formularioFactura = document.getElementById("frmFactura")
const formularioProductos = document.getElementById("frmProductos")
const btnNuevaFactura = document.querySelector('#btnNuevaFactura');
const btnAgregarProducto = document.querySelector('#btnAgregarProducto');
const btnEliminar = document.querySelector('#eliminar');
const selectProductos = document.querySelector('#ID_PRODUCTO');
const inputCantidad = document.querySelector('#CANTIDAD');
const inputPrecio = document.querySelector(`#PRECIO_UNITARIO`);
const btnGuardarCambiosFactura = document.querySelector('#btnGuardarCambiosFactura');

var productosArray = [];

window.addEventListener('DOMContentLoaded', (event) => {
    cargarEventListeners()
    crearTablaFacturas()
    crearSelect('ID_CLIENTE','Clientes')
    crearSelect('ID_PRODUCTO','Productos')
})

/* Listeners */
function cargarEventListeners() {
    /* Dispara cuando se presiona "Agregar" */
    btnNuevaFactura.addEventListener('click', crearFactura);
    btnAgregarProducto.addEventListener('click', agregarProducto);
    selectProductos.addEventListener('change', datosProducto);
    inputCantidad.addEventListener('keyup', calcularImporte);
    $('#frmFacturaModal').on('hide.bs.modal', limpiarMdl);
    btnGuardarCambiosFactura.addEventListener('click', modificarFactura);
}

/* Funciones */
function crearTablaFacturas(){
    // Creando el cuerpo de la tabla con dataTable y ajax
    $("#facturasTable").DataTable({
        // Petición para llenar la tabla
        "ajax": {
            url: 'consulta',
            dataSrc: ''
        },
        "columns": [
            {data: 'ID_FACTURA',visible:false},
            {data: 'FOLIO'},
            {data: 'CLIENTE'},
            {data: 'FECHA_FACTURA'},
            {data: 'TOTAL'},
            // Botones para editar y eliminar
            { data: null, render: function ( data, type, row ) {
                    return `<button class="btn btn-danger btn-sm" value="${row.ID_FACTURA}" onclick="eliminarFactura(this.value)">Eliminar</button>
                            <button class="btn btn-primary btn-sm btnEditarFactura" value="${row.ID_FACTURA}">Editar</button>`;
                }
            },
        ],
        // Indicamos el indice de la columna a ordenar y tipo de ordenamiento
        order: [[0, 'desc']],
        dom: '<"row">rt<"row"<"col"l><"col"p>>',
        // Mostrar los botones de paginación Inicio y Ultimo
        pagingType: 'full_numbers',
    });

    // Obtiene todos los datos del registro en el datatable al dar clic en editar
    $('#facturasTable tbody').on('click', '.btnEditarFactura', function () {
        var dataRow = $('#facturasTable').DataTable().row($(this).parents('tr')).data();
        
            // peticion a la base
    $.ajax({
        url: `consultaDetalleFactura/${dataRow.ID_FACTURA}`,
        type: "get",
        dataType: 'json',
        success: function (data){
            actualizarTablaDetalle(data)
        },
        error: function (error) {
            console.log(error);
        },
    });


        document.querySelector("#FECHA_FACTURA").value = dataRow.FECHA_FACTURA
        document.querySelector("#FOLIO").value = dataRow.FOLIO
        document.querySelector("#ID_CLIENTE").value = dataRow.ID_CLIENTE
        document.querySelector("#ID_FACTURA").value = dataRow.ID_FACTURA
        document.querySelector("#TOTAL").value = dataRow.TOTAL
        $('#frmFacturaModal').modal('show');
    });
    
}

function crearFactura(){
    $.ajax({
        url: 'crearFactura',
        type: "get",
        dataType: 'json',
        success: function (res) {
            document.querySelector("#ID_FACTURA").value = res.id
            document.querySelector("#ID_FACTURA_PRODUCTOS").value = res.id
            $('#frmFacturaModal').modal('show');
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function modificarFactura(){
    // Obtenemos la operacion a realizar crear ó editar
    var form_action = formularioFactura.getAttribute("action");
    // Datos del formulario
    var formData = new FormData(formularioFactura);

    guardarDatos(formData, form_action, "factura" )
}

function agregarProducto(){
    // Obtenemos la operacion a realizar crear ó editar
    var form_action = formularioProductos.getAttribute("action");
    // Datos del formulario
    var formData = new FormData(formularioProductos);
    
    guardarDatos(formData, form_action, "productos" )
}

function guardarDatos(formData, form_action, callBack ){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formData,
        url: form_action,
        type: "POST",
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res)
            if (callBack == "productos") {
                actualizarTablaDetalle(res)
            }else{
                $('#facturasTable').DataTable().ajax.reload();
                $('#frmFacturaModal').modal('hide');
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function eliminarProducto(ID_FACTURA_DETALLE){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'eliminarProducto/'+ID_FACTURA_DETALLE,
        type: "get",
        dataType: 'json',
        success: function (res) {
            actualizarTablaDetalle(res)
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function actualizarTablaDetalle(data){
    var cuerpoTabla = document.querySelector("#detalleFaturaTable tbody")
    let totalFactura = 0;
    cuerpoTabla.innerHTML = "";

    data.forEach(element => {
        totalFactura = totalFactura + element.IMPORTE;
    
      cuerpoTabla.innerHTML += `<tr>
                                  <td>${element.PRODUCTO}</td>
                                  <td>${element.PRECIO}</td>
                                  <td>${element.CANTIDAD}</td>
                                  <td>${element.IMPORTE}</td>
                                  <td>
                                    <button type="button" class="btn btn-danger btn-sm" value="${element.ID_FACTURA_DETALLE}" onclick="eliminarProducto(this.value)">Eliminar</button>
                                  </td>
                                </tr>`;
    });

    document.querySelector("#TOTAL").value = totalFactura;
    $('#frmProductos')[0].reset();
    document.querySelector("#ID_FACTURA_PRODUCTOS").value = document.querySelector("#ID_FACTURA").value
}

function crearSelect(id_select,tipo){
    // obteniendo el select a modificar
    var select = document.getElementById(`${id_select}`);

    // peticion a la base
    $.ajax({
        url: `consulta${tipo}`,
        type: "get",
        dataType: 'json',
        success: function (data){
            // // Limpiando el select
            $(`#${id_select}`).empty();

            // creando el select con los productos en la OC
            select.innerHTML += '<option value="">Selecionar...</option>';
            data.forEach(data => {
                if(tipo == "Productos"){
                    select.innerHTML += `<option value="${data.ID_PRODUCTO}">${data.NOMBRE_PRODUCTO}</option>`;
                    
                    const producto = {
                        id: data.ID_PRODUCTO,
                        precio: data.PRECIO
                    }
            
                    productosArray = [...productosArray, producto];
                }else{
                    select.innerHTML += `<option value="${data.ID_CLIENTE}">${data.NOMBRE_CLIENTE}</option>`;
                }
            });
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function datosProducto(){
    let datos = productosArray.filter( producto => producto.id == this.value );
    inputPrecio.value = datos[0].precio;
    inputCantidad.value = 0;
}

function calcularImporte(){

    const cantidad = parseFloat(inputCantidad.value)
    const precio = parseFloat(inputPrecio.value)
    
    var resOperacion = precio * cantidad;

    // si laoperacion retorna NaN lo covertimos a 0
    if(isNaN(resOperacion)){resOperacion = 0}

    // Agregamos el subtotal al td
    document.querySelector(`#IMPORTE`).value = resOperacion;
}

function limpiarMdl(){
    $('#frmProductos')[0].reset();
    $('#frmFactura')[0].reset();
    document.querySelector("#detalleFaturaTable tbody").innerHTML = "";
    $('#facturasTable').DataTable().ajax.reload();
}

function eliminarFactura(ID_FACTURA){
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'eliminarFactura/'+ID_FACTURA,
        type: "get",
        dataType: 'json',
        success: function (res) {
            $('#facturasTable').DataTable().ajax.reload();
        },
        error: function (err) {
            console.log(err);
        }
    });
}
