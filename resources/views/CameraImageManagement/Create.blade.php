@extends('layouts.app')
@section('content')
    <div class="row">
   <div class="col-lg-12">
      <h1 class="page-header">Add New Camera</h1>
   </div>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
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
                        <input id="camid" type="camid" class="form-control{{ $errors->has('camid') ? ' is-invalid' : '' }}" name="camid" value="{{ old('camid') }}" required autofocus>
                     </div>
               </div>    
            </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camloc') ? 'has-error' : ''}}">
                      <label for="camloc" class="col-md-3 col-form-label text-md-right">{{ __('Camera Location *') }}</label>
                       <div class="col-md-6">
                          <input id="camloc" type="camloc" class="form-control" required autofocus>
                       </div>
               </div> 
           </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Lat *') }}</label>
                     <div class="col-md-6">
                        <input id="camlatlong" type="camlat" class="form-control" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Long *') }}</label>
                     <div class="col-md-6">
                        <input id="camlatlong" type="camlong" class="form-control" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camurl') ? 'has-error' : ''}}">
                     <label for="camurl" class="col-md-3 col-form-label text-md-right">{{ __('Camera URL *') }}</label>
                     <div class="col-md-6">
                        <input id="camurl" type="camurl" class="form-control" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camflen') ? 'has-error' : ''}}">
                     <label for="camflen" class="col-md-3 col-form-label text-md-right">{{ __('CameraFocalLength') }}</label>
                     <div class="col-md-6">
                        <input id="camflen" type="camflen" class="form-control" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>  
           <div class="form-group">
               <div class="col-md-5">
               </div>
               <div class=" col-md-3">
                  <button id="addcamera" type="add" class="btn btn-primary">ADD</button>
                  <div id="addpopup" class="popup"> 
                     <div id="popup-content">
                      <span class="close">&times;</span>
                      <p> Camera Added </p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
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
span.onclick = function() {
    popup.style.display = "none";
   }
window.onclick = function(event) {
    if (event.target == popup) {
        popup.style.display = "none";
    }
}
</script>
@endsection