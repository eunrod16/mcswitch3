@extends('master')

@section('content')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="page-header">Carta Cajita</h4>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
              <div class="col-sm-1"><button id="new" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Nuevo</button></div>
              <div class="col-sm-6"><button id="export" class="btn btn-success">Export</button></div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="table">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Imagen</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <!--<tbody>
                                  @foreach ($productos as $producto)
                                     <tr>
                                        <td>{{$producto->codigo_producto}}</td>
                                        <td>{{$producto->nombre}}</td>
                                        <td>{{$producto->imagen}}</td>
                                        <td><a href="cartaCajita/segmentacion?cod={{$producto->codigo_producto}}" class="btn btn-info btn-xs segmentacion">+/-</a></td>
                                     </tr>
                                   @endforeach
                                </tbody>-->
                            </table>
                          </div>
                            <!-- /.table-responsive -->
                            <div class="well">
                                <h4>DataTables Usage Information</h4>
                                <p>DataTables is a very flexible, advanced tables plugin for jQuery. In SB Admin, we are using a specialized version of DataTables built for Bootstrap 3. We have also customized the table headings to use Font Awesome icons in place of images. For complete documentation on DataTables, visit their website at <a target="_blank" href="https://datatables.net/">https://datatables.net/</a>.</p>
                                <a class="btn btn-default btn-lg btn-block" target="_blank" href="https://datatables.net/">View DataTables Documentation</a>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
@include('carta_cajita.nuevo')
@include('carta_cajita.precio_reemplazo')
@include('carta_cajita.script')


@endsection
