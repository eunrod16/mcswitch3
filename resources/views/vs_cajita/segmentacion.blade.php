@extends('master')

@section('content')
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Segmentación Vida Saludable Cajita</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="panel-body">
              <div class="form-group">
                <div class="col-sm-5 col-xs-12">
                  <label for="exampleFormControlSelect2">Activo</label>
                  <select multiple class="form-control" id="activos">
                    @foreach ($activos as $rest)
                      <option value="{{$rest->codigo_localizacion}}">{{$rest->codigo_localizacion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-2 col-xs-12 text-center" style="margin-top:5%;">
                  <button type="button" id="add"  class="btn btn-info"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></button>
                  <button type="button" id="delete"  class="btn btn-info"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></button>
                </div>
                <div class="col-sm-5 col-xs-12">
                  <label for="exampleFormControlSelect2">Inactivo</label>
                  <select multiple class="form-control" id="inactivos">
                    @foreach ($inactivos as $rest)
                      <option value="{{$rest->codigo_localizacion}}">{{$rest->codigo_localizacion}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="row">
                  <div class="col-xs-12 text-center" style="margin-top:5%;">
                    <button id="guardar" type="button" class="btn btn-info">Guardar</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
<script>
$( document ).ready(function() {
  var agregados=[], eliminados = []
  $( "#delete" ).click(function() {
    var selectedValues = $('#activos').val();
    console.log(selectedValues)
    for (i = 0; i < selectedValues.length; i++) {
      $("#activos option[value='"+selectedValues[i]+"']").remove();
      $("#inactivos").append('<option>'+selectedValues[i]+'</option>');
      eliminados.push(selectedValues[i]);
      var index = agregados.indexOf(selectedValues[i]);
      if (index !== -1) agregados.splice(index, 1);
    }
  });
  $( "#add" ).click(function() {
    var selectedValues = $('#inactivos').val();
    console.log(selectedValues)
    for (i = 0; i < selectedValues.length; i++) {
      $("#inactivos option[value='"+selectedValues[i]+"']").remove();
      $("#activos").append('<option>'+selectedValues[i]+'</option>');
      agregados.push(selectedValues[i]);
      var index = eliminados.indexOf(selectedValues[i]);
      if (index !== -1) eliminados.splice(index, 1);
    }
  });
  $( "#guardar" ).click(function() {
    console.log("eliminados",eliminados);
    console.log("agregados",agregados);
    $.ajax({
    type: "POST",
    url: '/vsCajita/GuardarSegmentacion',
    data: {eliminados: eliminados, agregados: agregados, _token: '{!! csrf_token() !!}'},
    success: function(data){
        alert(data);
    }
});
  });
});
</script>
@endsection
