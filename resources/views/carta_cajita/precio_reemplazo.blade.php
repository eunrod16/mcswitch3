<div class="modal fade" id="precios" tabindex="-1" role="dialog" aria-labelledby="preciosLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="preciosLabel">Precio Reemplazo</h4>

      </div>
      <div class="modal-body">
        <label >Código Restaurante</label>
        <select  class="form-control" id="restaurantes">
          @foreach ($restaurantes as $key=>$value)
            <option value="{{$key}}">{{$value}}</option>
          @endforeach
        </select>
      <div class="form-group">
        <label for="email">Precio</label>
        <input type="text" class="form-control" id="precio_reemplazo" placeholder="$MuchosDólares">
      </div>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="guardarPrecioReemplazo">Save changes</button>
      </div>
    </div>
  </div>
</div>
