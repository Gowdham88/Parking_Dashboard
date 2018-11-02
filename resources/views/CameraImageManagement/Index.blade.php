@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div style="margin: 10px;">
            <!-- <button class="btn btn-success btn-xs pull-right" type="submit" value="Add another row" onclick="addRow(this)">
                    <i class="fa fa-plus-circle"></i> CAMERA
            </button> -->
            <a class="btn btn-success btn-xs pull-right" value="Add another row" href="{{url('cameraList/Addcamera')}}">
                <i class="fa fa-plus-circle"></i> CAMERA
            </a>
            <br class="clearfix">
        </div>

        <form action="{{ action('CameraImageManagementController@index') }}" method="get">

            <div class="alert alert-info">
                <select name="action" id="action">
                    <option value="none">None</option>
                    <option value="mask">Mask</option>
                    <option value="view">View</option>
                </select>
                <button>Ok</button>
            </div>

            <table class="camera-list-table-js table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Url</th>
                    <th>Image</th>
                    <th>Location</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($response as $object)
                    <tr>
                        <td>{{$object['cameraID']}}</td>
                        <td><a href="{{$object['cameraImageUrl']}}">{{$object['cameraImageUrl']}}</a></td>
                        <td>
                            <a href="#" class="pop">
                                <img src="{{$object['cameraImageUrl']}}" class="img-responsive">
                            </a>
                        </td>
                        <td>{{$object['cameraLocationName']}}</td>
                        {{--  <td><input type="button" value="View" onclick="SomeDeleteRowFunction(this)"/></td>            --}}
                        <td>
                            <a class="btn btn-success btn-xs" value="View" href="{{url('cameraList/Viewcamera')}}/{{$object['cameraID']}}">VIEW</a>
                            <a class="btn btn-info btn-xs" value="View" href="{{url('cameraList/Editcamera')}}/{{$object['cameraID']}}">EDIT</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    </div>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img src="" class="imagepreview" style="width: 100%;" >
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('footer_scripts')
    <script>
        $(document).ready( function () {

            $('.camera-list-table-js thead tr').clone(true).appendTo( '.camera-list-table-js thead' );
            $('.camera-list-table-js thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }
                } );
            } );

            var table = $('.camera-list-table-js').DataTable({
                "paging": false,
                "ordering": true,
                "info": true
            });
            $('.camera-list-table-js').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );

            $('#button').click( function () {
                alert( table.rows('.selected').data().length +' row(s) selected' );
            } );
            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', $(this).find('img').attr('src'));
                $('#imagemodal').modal('show');
            });
        } );
    </script>
@endsection
