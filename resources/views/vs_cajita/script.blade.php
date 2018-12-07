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
                return '<a href="vsCajita/segmentacion?cod='+data.codigo_producto+'" class="btn btn-info btn-xs segmentacion">+/-</a>'
            }}

        ]
  });
  $.ajaxSetup( {
      headers: {
          'CSRFToken': '{!! csrf_token() !!}'
      }
  } );
  editor = new $.fn.dataTable.Editor( {
    ajax: function ( method, url, d, success, error ) {
      d._token= '{!! csrf_token() !!}';
            $.ajax({
                type: 'POST',
                url: '/vsCajita/setData' , // ** _id_ isn't populated in ajax call**
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
$("#export").on('click',function(e) {
  $.ajax({
                  type: 'get',
                  url: '/vsCajita/export',
                  data: {
                      '_token': $('input[name=_token]').val(),
                  },
                  success: function(data) {
                    console.log(data)
                    var csv = Papa.unparse(data);
                    download('P1DGT-V518.csv', csv);
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
