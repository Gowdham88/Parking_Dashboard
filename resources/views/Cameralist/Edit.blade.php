@extends('layouts.app')
@section('content')
    <div class="row">
   <div class="col-lg-12">
      <h1 class="page-header"> Edit Camera Details</h1>
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
                <form method="post" action="{{ action('CameradetailsController@update', $camera['cameraID']) }}">
                    {!! csrf_field() !!}
                    {!! method_field('put') !!}
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camid') ? 'has-error' : ''}}">
                            <label for="camid" class="col-md-3 col-form-label text-md-right">{{ __('Camera ID') }}</label>
                            <div class="col-md-6">
                                <input id="camid" type="camid" class="form-control{{ $errors->has('camid') ? ' is-invalid' : '' }}" name="camid" readonly value="{{$camera['cameraID']}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camloc') ? 'has-error' : ''}}">
                            <label for="camloc" class="col-md-3 col-form-label text-md-right">{{ __('Camera Location') }}</label>
                            <div class="col-md-6">
                                <input name="location" id="camloc" type="camloc" class="form-control" value="{{$camera['cameraLocationName']}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                            <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Lat') }}</label>
                            <div class="col-md-6">
                                <input name="lat" id="camlatlong" type="camlat" class="form-control" value="{{$camera['cameraLat']}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camlatlong') ? 'has-error' : ''}}">
                            <label for="camlatlong" class="col-md-3 col-form-label text-md-right">{{ __('Camera Long') }}</label>
                            <div class="col-md-6">
                                <input name="lng" id="camlatlong" type="camlong" class="form-control" value="{{$camera['cameraLong']}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camurl') ? 'has-error' : ''}}">
                            <label for="camurl" class="col-md-3 col-form-label text-md-right">{{ __('Camera URL') }}</label>
                            <div class="col-md-6">
                                <input name="url" id="camurl" type="camurl" class="form-control" value="{{$camera['cameraImageUrl']}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('camflen') ? 'has-error' : ''}}">
                            <label for="camflen" class="col-md-3 col-form-label text-md-right">{{ __('CameraFocalLength') }}</label>
                            <div class="col-md-6">
                                <input name="flen" id="camflen" type="camflen" class="form-control" value="{{'TBD'}}" required autofocus>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <div class="col-md-5">
                        </div>
                        <div class=" col-md-3">
                            <button id="addcamera" type="add" class="btn btn-primary">Update</button>
                            @if(Session::has('message'))
                                <script>
                                    alert("{{ Session::get('message') }}");
                                </script>
                            @endif
                        </div>
                    </div>
                </form>
         </div>
      </div>
   </div>
</div>
@endsection