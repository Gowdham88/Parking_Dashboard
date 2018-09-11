@extends('layouts.app')
@section('content')

<div>
<button class="btn btn-success btn-xs pull-right" type="submit" value="Add another row" onclick="addRow(this)">
        <i class="fa fa-plus-circle"></i> CAMERA
</button>
</div>
<table>
        <tr>
          <th>Id</th>
          <th>Url</th>
          <th>location</th>
          <th></th>
        </tr>
        <tr>
          <td>CAM001</td>
          <td>https://pyrky-d40df.firebaseio.com/</td>
          <td>Germany</td>
          {{--  <td><input type="button" value="View" onclick="SomeDeleteRowFunction(this)"/></td>            --}}
          <td>
                <button class="btn btn-success btn-xs" value="View" onclick="viewRow(this)">
                    VIEW
                  </button>
                  <button class="btn btn-info btn-xs" value="View" onclick="editRow(this)">
                    EDIT
                  </button>
        </td>

        </tr>
        <tr>
          <td>CAM002</td>
          <td>https://pyrky-d40df.firebaseio.com/</td>
          <td>Mexico</td>
          {{--  <td><input type="button" value="View" onclick="SomeDeleteRowFunction(this)"/></td>            --}}
          <td>
                <button class="btn btn-success btn-xs" value="View" onclick="viewRow(this)">
                VIEW
                  </button>
                  <button class="btn btn-info btn-xs" value="View" onclick="editRow(this)">
                EDIT
                  </button>
        </td>

        </tr>
        <tr>
                <td>CAM003</td>
                <td>https://pyrky-d40df.firebaseio.com/</td>
                <td>Germany</td>
                {{--  <td><input type="button" value="View" onclick="SomeDeleteRowFunction(this)"/></td>            --}}
                <td>
                        <button class="btn btn-success btn-xs" value="View" onclick="viewRow(this)">
                            VIEW
                          </button>
                          <button class="btn btn-info btn-xs" value="View" onclick="editRow(this)">
                             EDIT
                          </button>
                </td>
              </tr>
        
      </table>

@stop
