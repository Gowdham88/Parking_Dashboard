@extends('layouts.app')
@section('content')

<div>
<!-- <button class="btn btn-success btn-xs pull-right" type="submit" value="Add another row" onclick="addRow(this)">
        <i class="fa fa-plus-circle"></i> CAMERA
</button> -->
<a class="btn btn-success btn-xs pull-right" value="Add another row" href="{{url('cameraList/Addcamera')}}">
        <i class="fa fa-plus-circle"></i> CAMERA
</a>
</div>
<table>
        <tr>
          <th>Id</th>
          <th>Url</th>
          <th>location</th>
          <th></th>
        </tr>
        @foreach($response as $object)
          <tr>
            <td>{{$object['cameraID']}}</td>
            <td>{{$object['cameraImageUrl']}}</td>  
            <td>{{$object['cameraLocationName']}}</td>
            {{--  <td><input type="button" value="View" onclick="SomeDeleteRowFunction(this)"/></td>            --}}
            <td>
                  <a class="btn btn-success btn-xs" value="View" href="{{url('cameraList/Viewcamera')}}/{{$object['cameraID']}}">VIEW</a>
                  <a class="btn btn-info btn-xs" value="View" href="{{url('cameraList/Editcamera')}}/{{$object['cameraID']}}">EDIT</a>
            </td>
          </tr>
        @endforeach  
      </table>

@stop
