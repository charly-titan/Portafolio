@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<link rel="stylesheet" href="{{ asset('css/ultima-hora.css')}}"/>
@endsection
@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <h1 ><i class="fa fa-list-alt"></i>Listado</h1>
                </div>
                <a href="/admin-stickers/create-album" class="btn btn-primary pull-right">
                    Nuevo
                </a>
                <div class="row">
                    <article class="col-md-12">
                        <div class="jarviswidget jarviswidget-color-blueDark" >
                            <header role="heading">
                                <span class="widget-icon"><i class="fa fa-edit"></i></span>
                                <h2>Albums</h2>
                                <span class="jarviswidget-loader">
                                    <i class="fa fa-refresh fa-spin">
                                    </i>
                                </span>
                            </header>
                            <div role="content">
                                <div class="jarviswidget-editbox"></div>
                                <div class="widget-body no-padding">
                                    <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    Album
                                                </th>
                                                <th class="text-center">
                                                    Sitio
                                                </th>
                                                <th class="text-center">
                                                    Accion
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($albums as $album)
                                            <tr id="tr_{{$album->id}}">
                                                <td class="text-center">{{$album->album}}</td>
                                                <td class="text-center">{{$album->sitio}}</td>
                                                <td class="text-center">
                                                    <a href="/admin-stickers/preview-album/{{$album->sitio}}" target="_blank" class="btn btn-success" >
                                                        <i class="fa fa-eye">
                                                        </i>
                                                    </a>
                                                    <a href="javascript:void(0)" id="editAlbum_{{$album->id}}" class="btn btn-primary editAlbum" >
                                                        <i class="fa fa-edit">
                                                        </i>
                                                        <i class="fa fa-book">
                                                        </i>
                                                    </a>
                                                    <a href="javascript:void(0)" id="editStickers_{{$album->id}}" class="btn btn-primary editStickers" >
                                                        <i class="fa fa-edit">
                                                        </i>
                                                        <i class="fa fa-th-large">
                                                        </i>
                                                    </a>
                                                    <a href="javascript:void(0)" id="deleteAlbum_{{$album->id}}" class="btn btn-danger deleteAlbum">
                                                        <i class="fa fa-trash-o">
                                                        </i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section("scripts")
@parent
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="{{asset('js/notification/SmartNotification.min.js')}}"></script>
<script type="text/javascript">
    /**************************************************************************/
    /*****************************init index.blade.php*************************/
    /**************************************************************************/
    /* init table *************************************************************/
    $(document).ready(function() {
        $('#dt_basic').dataTable();
    });
    $(document).on('click', '.deleteAlbum', function(event) {
        $.ajax({
            url: '/admin-stickers/delete-album',
            type: 'POST',
            data: {
                'id': this.id
            },
            success: function(obj) {
                id = (obj.id);
                var algo = '#tr_' + id + ' td';
                $(algo).fadeOut(1000);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $(document).on('click', '.editAlbum', function(event) {
        $.ajax({
            url: '/admin-stickers/site-exist',
            type: 'POST',
            data: {
                'id': this.id
            },
            success: function(obj) {
                window.open('/admin-stickers/edit-album?site=' + obj.title, '_blank');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    $(document).on('click', '.editStickers', function(event) {
        $.ajax({
            url: '/admin-stickers/site-exist',
            type: 'POST',
            data: {
                'id': this.id
            },
            success: function(obj) {
                window.open('/admin-stickers/edit-stickers?site=' + obj.title);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    /*****************************end  index.blade.php*****************************/
</script>
@endsection
