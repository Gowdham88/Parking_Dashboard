@extends('layouts.app')
@section('content')
<style type="text/css">
  td{
    border-style: hidden !important;
  }
  .borderless td, .borderless th {
    border: none !important;
}
</style>
    <div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Add New Camera</h1>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
          <form action="{{ action('CameradetailsController@store') }}" method="post">
              {{ csrf_field() }}
              <div class="panel-heading">
                  Camera Informations
              </div>
              <div class="panel-body">
                  @if ($errors->any())
                      <ul class="alert alert-danger">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  @endif
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camid') ? 'has-error' : ''}}">
                          <label for="camid" class="col-md-3 col-form-label text-md-right">{{ __('Camera ID *') }}</label>
                          <div class="col-md-6">
                              <strong>Auto Generated</strong>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camloc') ? 'has-error' : ''}}">
                          <label for="camloc" class="col-md-3 col-form-label text-md-right">{{ __('Camera Location *') }}</label>
                          <div class="col-md-6">
                              <input name="location" id="camloc" type="camloc" class="form-control" required autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                          <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Lat *') }}</label>
                          <div class="col-md-6">
                              <input name="lat" id="camlatlong" type="camlat" class="form-control" required autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                          <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Long *') }}</label>
                          <div class="col-md-6">
                              <input name="lng" id="camlatlong" type="camlong" class="form-control" required autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camurl') ? 'has-error' : ''}}">
                          <label for="camurl" class="col-md-3 col-form-label text-md-right">{{ __('Camera URL *') }}</label>
                          <div class="col-md-6">
                              <input name="url" id="camurl" type="camurl" class="form-control" required autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('camflen') ? 'has-error' : ''}}">
                          <label for="camflen" class="col-md-3 col-form-label text-md-right">{{ __('CameraFocalLength') }}</label>
                          <div class="col-md-6">
                              <input name="flen" id="camflen" type="camflen" class="form-control"  autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('parkingRules') ? 'has-error' : ''}}">
                          <label for="parkingRules" class="col-md-3 col-form-label text-md-right">{{ __('Parking Rules') }}</label>
                                  <input type="button" id="add" value="+" />
                                  <input type="button" id="del" value="-" />
                          <div class="form-group col-md-6">
                            <table class="table" id="pr" style="border: none;outline: none;border-collapse: collapse;">
                              <tr style="border: none;">
                                <td>
                                  <input name="parkingRules[]" id="parkingRules0" placeholder="Rule 1" type="text" class="form-control" autofocus>
                                </td>
                              </tr>
                            </table>
                              
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="col-md-12">
                      <div class="form-group {{ $errors->has('directionAngle') ? 'has-error' : ''}}">
                          <label for="directionAngle" class="col-md-3 col-form-label text-md-right">{{ __('NorthDirectionAngle') }}</label>
                          <div class="col-md-6">

                            <input name="directionAngle" id="directionAngle" type="directionAngle" class="form-control"  autofocus>
                          </div>
                      </div>
                  </div>
                  <br><br>
                  <div class="form-group">
                      <div class="col-md-5">
                      </div>
                      <div class=" col-md-3">
                          <button id="addcamera" type="add" class="btn btn-primary">ADD</button>
                          @if(Session::has('message'))
                              <script>
                                  alert("{{ Session::get('message') }}");
                              </script>
                          @endif
                      </div>
                  </div>
              </div>
          </form>
      </div>
   </div>
</div>

<script type="text/javascript">
var popup = document.getElementById("addpopup");
var btn = document.getElementById("addcamera");
var span = document.getElementsByClassName("close")[0];
btn.onclick = function() {
   popup.style.display = "block";
}
// span.onclick = function() {
//     popup.style.display = "none";
//    }
window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}

$('#add').click(function () {
  id=$('#pr tr').length;
  ruleCount=id+1;
              var markup = `<tr> 
                              <td>
                                <input name="parkingRules[]" id="parkingRules`+id+`" type="text" class="form-control"  autofocus placeholder="Rule `+ruleCount+`">
                                </td>
                              </tr>`;
  $("#pr").append(markup);

});
$('#del').click(function () {
    var table = $('#pr');
    if (table.find('input:text').length > 1) {
        table.find('input:text').last().closest('tr').remove();
    }
});
</script>
@endsection