@extends('layouts.app')
@section('content')
    <div class="row">
   <div class="col-lg-12">
      <h1 class="page-header"> View Camera Details</h1>
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
                     <label for="camid" class="col-md-3 col-form-label text-md-right">{{ __('Camera ID') }}</label>
                     <div class="col-md-6">
                        <input id="camid" type="camid" readonly class="form-control{{ $errors->has('camid') ? ' is-invalid' : '' }}" name="camid" value="{{$object['cameraID']}}" required autofocus>
                     </div>
               </div>    
            </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camloc') ? 'has-error' : ''}}">
                      <label for="camloc" class="col-md-3 col-form-label text-md-right">{{ __('Camera Location') }}</label>
                       <div class="col-md-6">
                          <input id="camloc" type="camloc" readonly class="form-control" value="{{$object['cameraLocationName']}}" required autofocus>
                       </div>
               </div> 
           </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Lat') }}</label>
                     <div class="col-md-6">
                        <input id="camlatlong" type="camlat" readonly class="form-control" value="{{$object['cameraLat']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Long') }}</label>
                     <div class="col-md-6">
                        <input id="camlatlong" type="camlong" readonly class="form-control" value="{{$object['cameraLong']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camurl') ? 'has-error' : ''}}">
                     <label for="camurl" class="col-md-3 col-form-label text-md-right">{{ __('Camera URL') }}</label>
                     <div class="col-md-6">
                        <input id="camurl" type="camurl" readonly class="form-control" value="{{$object['cameraImageUrl']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camflen') ? 'has-error' : ''}}">
                     <label for="camflen" class="col-md-3 col-form-label text-md-right">{{ __('CameraFocalLength') }}</label>
                     <div class="col-md-6">
                        <input id="camflen" type="camflen" readonly class="form-control" value="{{'TBD'}}" required autofocus>
                     </div>
               </div>
           </div>
         </div>
      </div>
   </div>
</div>
@endsection