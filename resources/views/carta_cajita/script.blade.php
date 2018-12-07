    <script src="../vendor/jquery/jquery.min.js"></script>
<script>
$(document).ready(function () {
  $('#table').DataTable({
    dom: "Bfrtip",
        data: {!! $productos !!},
        order: [[ 1, 'asc' ]],
        columns: [

            { data: "codigo_producto" },
            { data: "nombre" },
            { data: "imagen" },
            { data: null, render: function(data, type, row){
                var segmentacion = '<a href="cartaCajita/segmentacion?cod='+data.codigo_producto+'" class="btn btn-info btn-xs segmentacion">+/-</a>';
                var precio_reemplazo = ' <a  href="#" class="btn btn-success btn-xs precioReemplazo" data-toggle="modal" data-target="#precios" data-codigoproducto="'+data.codigo_producto+'">Q</a>';
                return segmentacion + precio_reemplazo;

            }}

        ]
  });

  editor = new $.fn.dataTable.Editor( {
    ajax: function ( method, url, d, success, error ) {
      d._token= '{!! csrf_token() !!}';
            $.ajax({
                type: 'POST',
                url: '/cartaCajita/setData' , // ** _id_ isn't populated in ajax call**
                data: d,
                success: function (json) {
                    json = JSON.parse(json);
                    console.log(json);
                    success(json);
                },
                error: function (xhr, error, thrown) {
                    error(xhr, error, thrown);
                }
            });
    },
    table: "#table",
    idSrc:  'codigo_producto',
    fields: [ {
            label: "Código",
            name: "codigo_producto"
        }, {
            label: "Nombre:",
            name: "nombre"
        }, {
            label: "Imagen",
            name: "imagen"
        }, {
            label: "Acciones",
            name: "acciones"
        }
    ]
} );
  $('#table').on( 'click', 'tbody td:not(:first-child)', function (e) {
    editor.inline( this, {
        submit: 'allIfChanged'
    } );
} );
$(".segmentacion").on('click',function(e) {
var href = $(this).attr('href');
//var menu_title = $(this).attr('menu_title');

$(this).parent().siblings().removeClass("active");
//console.log($(this).parent().siblings());
if(href != undefined) {
//$('#workspace_title').html(menu_title);
e.preventDefault();
        //console.log($(this).attr('href'));
        $("#container-fluid").load($(this).attr('href'));
}
});
$("#save").on('click',function(e) {
  $.ajax({
                  type: 'post',
                  url: '/cartaCajita/crearNuevo',
                  data: {
                    _token: '{!! csrf_token() !!}'
                  },
                  success: function(data) {
                    console.log(data)
                  }

});
});
var codigo_producto=0;
var codigo_localizacion = 0;
$( ".precioReemplazo" ).click(function() {
  codigo_producto = $(this).data("codigoproducto");
  $("#restaurantes").val(0);
  $("#precio_reemplazo").val(null);
});
$('#restaurantes').on('change', function() {
     codigo_localizacion = $(this).find(":selected").val();
     if(codigo_localizacion){
       $("#precio_reemplazo").val(null);
       return;
     }
    $.ajax({
                    type: 'get',
                    url: '/getPrecioReemplazo',
                    data: {
                      codigo_localizacion: codigo_localizacion,
                      codigo_producto : codigo_producto,
                      categoria: "carta_cajita"
                    },
                    success: function(data) {
                      console.log("data",data)
                      $("#precio_reemplazo").val(data[0].precio);
                    }

  });
});
$('#guardarPrecioReemplazo').on('click', function() {
    $.ajax({
                    type: 'post',
                    url: '/guardarPrecioReemplazo',
                    data: {
                      _token: '{!! csrf_token() !!}',
                      precio_reemplazo: $("#precio").val(),
                      codigo_producto : codigo_producto,
                      codigo_localizacion: codigo_localizacion,
                      categoria: "carta_cajita"
                    },
                    success: function(data) {
                      console.log("data",data)
                    }

  });
});
$("#export").on('click',function(e) {
  $.ajax({
                  type: 'get',
                  url: '/cartaCajita/export',
                  data: null,
                  success: function(data) {
                    console.log(data)
                    var csv = Papa.unparse(data);
                    download('P1AGT-V518.csv', csv);
                  }

});
});
function download(filename, text) {
    var element = document.createElement('a');
    element.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(text));
    element.setAttribute('download', filename);

    element.style.display = 'none';
    document.body.appendChild(element);

    element.click();

    document.body.removeChild(element);
}



});
</script>
