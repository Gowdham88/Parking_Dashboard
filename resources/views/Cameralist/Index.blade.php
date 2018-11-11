@extends('layouts.app')
@section('content')

<div class="row">
<!-- <button class="btn btn-success btn-xs pull-right" type="submit" value="Add another row" onclick="addRow(this)">
        <i class="fa fa-plus-circle"></i> CAMERA
</button> -->
<a class="btn btn-success btn-xs pull-right" href="{{action('CameradetailsController@create')}}">
        <i class="fa fa-plus-circle"></i> CAMERA
</a>
</div>
<div class="row">
    @if(Session::has('message'))
        <div id="addpopup" class="popup">
            <div id="popup-content">
                <span class="close">&times;</span>
                <p> {{ Session::get('message') }} </p>
            </div>
        </div>
    @endif
    <table class="row">
        <tr>
            <th>Id</th>
            <th>Url</th>
            <th>location</th>
            <th></th>
        </tr>
        @foreach($data as $key=>$object)
            <tr>
                <td>{{$object['cameraID']}}</td>
                <td>{{$object['cameraImageUrl']}}</td>
                <td>{{$object['cameraLocationName']}}</td>
                <td>
                    <a class="btn btn-success btn-xs" value="View" href="{{url('cameraList/')}}/{{$object['cameraID']}}">VIEW</a>
                    <a class="btn btn-info btn-xs" value="View" href="{{url('cameraList/')}}/{{$object['cameraID']}}/edit">EDIT</a>
                    <form action="{{ action('CameradetailsController@destroy', $object['cameraID']) }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <button class="btn btn-info btn-xs" value="View" href="{{url('cameraList/')}}/{{$object['cameraID']}}/edit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
</div>

@stop
