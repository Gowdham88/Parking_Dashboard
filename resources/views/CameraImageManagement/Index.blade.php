@extends('layouts.app')
@section('content')
    <script>
        function resizeIframe(obj) {
            obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
        }
    </script>
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

            <table class="camera-list-table-js table table-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Url</th>
                    <th>Image</th>
                    <th>Location</th>
                    <th></th>
                </tr>cvn
                </thead>
                <tbody>
                @foreach($data as $object)
                    <tr>
                        <td>{{$object['cameraID']}}</td>
                        <td><a href="{{$object['cameraImageUrl']}}">{{$object['cameraImageUrl']}}</a></td>
                        <td>
                            <a class="pop">
                                @if(strstr($object['cameraImageUrl'],".jpg") || strstr($object['cameraImageUrl'],".png")||strstr($object['cameraImageUrl'],".jpeg"))
                                <img data-cid="{{$object['cameraID']}}" src="{{$object['cameraImageUrl']}}" class="img-responsive">
                                @else

                                <img data-cid="{{$object['cameraID']}}" src="{{ \App\Http\Controllers\CameraImageManagementController::makeImageUrl($object['cameraImageUrl'],$object['cameraID'])}}" class="img-responsive">
                                @endif
                            </a>
                        </td>
                        <td>{{$object['cameraLocationName']}}</td>
                        <td>
                            <a class="btn btn-info btn-xs" value="Mask/Unmask" href="{{url('/cameraManagement/mask-unmask/')}}/<?=$object['cameraID']?>">Mask/Unmask</a>
                            <!-- <a class="btn btn-info btn-xs" value="Mask/Unmask" href="{{action('CameraImageManagementController@manageMasking', $object['cameraID'])}}">Mask/Unmask</a> -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    </div> 

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:75%;">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <iframe id="ipp" class="imagepreview" style="width: 100%;height: auto;border: none;margin-top:5px;" onload="resizeIframe(this)"></iframe>
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

            $('.pop').on('click', function() {
                $('.imagepreview').attr('src', "about:blank");
                $('.imagepreview').contents().find('body').html("<h2>Loading Image...</h2>");
                let camId = $(this).find('img').attr('data-cid');
                $('.imagepreview').attr('src', "{{ action('CameraImageManagementController@showPreview') }}"+"?cid="+camId);
                $('#imagemodal').modal('show');
            });
        } );
    </script>
    <script src="{{ asset('js/iframeResizer.contentWindow.min.js') }}"></script>
    <script src="{{ asset('js/iframe.js') }}"></script>
    <script>
        $('#ipp').iFrameResize();
    </script>
@endsection
