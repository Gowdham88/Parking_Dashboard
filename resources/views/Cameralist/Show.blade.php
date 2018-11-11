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
                        <input id="camid" type="text" readonly class="form-control{{ $errors->has('camid') ? ' is-invalid' : '' }}" name="camid" value="{{$camera['cameraID']}}" required autofocus>
                     </div>
               </div>    
            </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camloc') ? 'has-error' : ''}}">
                      <label for="location" class="col-md-3 col-form-label text-md-right">{{ __('Camera Location') }}</label>
                       <div class="col-md-6">
                          <input name="location" id="location" type="text" readonly class="form-control" value="{{$camera['cameraLocationName']}}" required autofocus>
                       </div>
               </div> 
           </div>
            <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="lat" class="col-md-3 col-form-label text-md-right">{{ __('Camera Lat') }}</label>
                     <div class="col-md-6">
                        <input name="lat" id="lat" type="camlat" readonly class="form-control" value="{{$camera['cameraLat']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                     <label for="lng" class="col-md-3 col-form-label text-md-right">{{ __('Camera Long') }}</label>
                     <div class="col-md-6">
                        <input name="lng" id="lng" type="camlong" readonly class="form-control" value="{{$camera['cameraLong']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camurl') ? 'has-error' : ''}}">
                     <label for="url" class="col-md-3 col-form-label text-md-right">{{ __('Camera URL') }}</label>
                     <div class="col-md-6">
                        <input id="url" name="url" type="text" readonly class="form-control" value="{{$camera['cameraImageUrl']}}" required autofocus>
                     </div>
               </div>
           </div>
           <br><br>
            <div class="col-md-12">
               <div class="form-group {{ $errors->has('camflen') ? 'has-error' : ''}}">
                     <label for="flen" class="col-md-3 col-form-label text-md-right">{{ __('CameraFocalLength') }}</label>
                     <div class="col-md-6">
                        <input name="flen" id="flen" type="camflen" readonly class="form-control" value="{{'TBD'}}" required autofocus>
                     </div>
               </div>
           </div>
         </div>
      </div>
   </div>
</div>
@endsection