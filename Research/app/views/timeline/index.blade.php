@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-editbutton="false">

<header>
    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
    <h2>Timeline Vive Latino 2016</h2>

</header>

<!-- widget div-->
<div>

    <!-- widget edit box -->
    <div class="jarviswidget-editbox">
        <!-- This area used as dropdown edit box -->

    </div>
    <!-- end widget edit box -->

    <!-- widget content -->
    <div class="widget-body no-padding">
        <div id="content-msg-tabl-fireline" class="col-md-12"></div>
        <div class="col-md12">
            <a data-toggle="modal" id="btn-create-event" data-target="#modalNew" class="btn btn-primary pull-right">Agregar nuevo Evento</a>
        </div>
        <table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">
            <thead>
                <tr>
                    <th data-class="expand">Fecha de Inicio</th>
                    <th>Fecha de termino</th>
                    <th data-hide="phone">Banda</th>
                    <th data-hide="">Tag</th>
                    <th data-hide="phone,tablet">acciones</th>
                </tr>
            </thead>
            <tbody id="content-timeline-data">
            </tbody>
        </table>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Info Banda</h4>
                    </div>
                    <div class="modal-body">
        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="from">Fecha inicio</label>
                                <div class="input-group">
                                    <!--<input class="form-control hasDatepicker" id="startdate" name="ServiceSettings[from]" type="text" value="">-->
                                    <input class="form-control datepicker" id="active_date" name="datestart" type="text" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="from">Fecha fin</label>
                                <div class="input-group">
                                    <!--<input class="form-control hasDatepicker" id="finishdate" name="ServiceSettings[from]" type="text" value="">-->
                                    <input class="form-control datepicker" id="inactive_date" name="dateend" type="text" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de inicio</label>
                                    <div class="input-group">
                                        <input class="form-control" id="horaInicio" name="horainicio" type="text" placeholder="Select time">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de termino</label>
                                    <div class="input-group">
                                        <input class="form-control" id="horaFin" name="horafin" type="text" placeholder="Select time">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags">Nombre Banda</label>
                                    <input type="text" name="headline" class="form-control" id="tags" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags"> Tags</label>
                                    <input type="text" name="tag" class="form-control" id="tags">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="button" id="btn-save-fire" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="modalNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Info Banda</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form-new-event" name="new-event">
                        <div id="content-msg-fireline" class="col-md-12">
                            <div id="alertmsg-fireline" class="alert alert-warning fade in" style="display:none;">
                                <button name="botonx"  value="closemsg" class="close" data-dismiss="alert">
                                    ×
                                </button>
                                <i class="fa-fw fa fa-warning"></i>
                                <strong>Warning</strong> Todos los campos son requeridos.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="from">Fecha inicio</label>
                                <div class="input-group">
                                    <input class="form-control datepicker" id="date_from" name="datestart" type="text" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="from">Fecha fin</label>
                                <div class="input-group">
                                    <input class="form-control datepicker" id="date_to" name="dateend" type="text" >
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de inicio</label>
                                    <div class="input-group">
                                        <input class="form-control" id="hourone" name="hourone" type="text" placeholder="Select time">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Hora de termino</label>
                                    <div class="input-group">
                                        <input class="form-control" id="hourtwo" name="hourtwo" type="text" placeholder="Select time">
                                        <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags">Nombre Banda</label>
                                    <input type="text" name="headline" class="form-control" id="tags" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags"> Tags</label>
                                    <input type="text" name="tag" class="form-control" id="tags">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button onclick="fireline.prepareEeventData()" type="button" id="sendNewData" value="submit" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

    </div>
    <!-- end widget content -->

</div>
<!-- end widget div -->

</div>
<!-- end widget -->

@endsection
@section("scripts")
@parent
    <script src="{{asset('/js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js')}}"></script>
    <script type="text/javascript" src="https://cdn.firebase.com/js/client/2.2.1/firebase.js"></script>
    <script src="{{asset('/js/timelinelive.js')}}"></script>
    <script>
    $("#btn-create-event").click(function(){
        $("#alertmsg-fireline").hide();
    });
    $("#msg-fireline-created").hide();
        $("#myModal").css("z-index", "907");
        $("#modalNew").css("z-index", "907");
        $("#date_from, #date_to, #active_date, #inactive_date").focusin(function(){
            setTimeout(function(){$("#ui-datepicker-div").css("z-index","908");},1000);
            
        });

                $("#active_date").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd/mm/yy',
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    onClose: function (selectedDate) {
                        $("#inactive_date").datepicker("option", "minDate", selectedDate);
                    },
                    onSelect: function() {

                        dateTo = (new Date($(this).val()).getTime() / 1000).toFixed(0)
                        $("#dateFrom").val($(this).val());
                    }
            
                });


                $("#inactive_date").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd/mm/yy',
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    onClose: function (selectedDate) {
                        $("#active_date").datepicker("option", "maxDate", selectedDate);
                        
                    },
                    onSelect: function() {

                        dateFrom = (new Date($(this).val()).getTime() / 1000).toFixed(0)
                        $("#dateTo").val($(this).val())
                    }
                });

                $("#date_from").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd/mm/yy',
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    onClose: function (selectedDate) {
                        $("#inactive_date").datepicker("option", "minDate", selectedDate);
                    },
                    onSelect: function() {

                        dateTo = (new Date($(this).val()).getTime() / 1000).toFixed(0)
                        $("#dateFrom").val($(this).val());
                    }
            
                });


                $("#date_to").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: 'dd/mm/yy',
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    onClose: function (selectedDate) {
                        $("#active_date").datepicker("option", "maxDate", selectedDate);
                        
                    },
                    onSelect: function() {

                        dateFrom = (new Date($(this).val()).getTime() / 1000).toFixed(0)
                        $("#dateTo").val($(this).val())
                    }
                });

                $('#horaInicio').timepicker({
                    minuteStep: 1,
                    minuteStep : 5,
                    maxHours : 24,
                    showMeridian: false,
                    defaultTime: false
                });
                $('#horaFin').timepicker({
                    minuteStep: 1,
                    maxHours : 24,
                    minuteStep : 5,
                    showMeridian: false,
                    defaultTime: false
                });
                $('#hourone').timepicker({
                    minuteStep: 1,
                    minuteStep : 5,
                    maxHours : 24,
                    showMeridian: false,
                    defaultTime: false
                });
                $('#hourtwo').timepicker({
                    minuteStep: 1,
                    maxHours : 24,
                    minuteStep : 5,
                    showMeridian: false,
                    defaultTime: false
                });

                $("#smart-mod-eg1").click(function(e) {
                $.SmartMessageBox({
                    title : "Smart Alert!",
                    content : "This is a confirmation box. Can be programmed for button callback",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
        
                        $.smallBox({
                            title : "Callback function",
                            content : "<i class='fa fa-clock-o'></i> <i>You pressed Yes...</i>",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated",
                            timeout : 4000
                        });
                    }
                    if (ButtonPressed === "No") {
                        $.smallBox({
                            title : "Callback function",
                            content : "<i class='fa fa-clock-o'></i> <i>You pressed No...</i>",
                            color : "#C46A69",
                            iconSmall : "fa fa-times fa-2x fadeInRight animated",
                            timeout : 4000
                        });
                    }
        
                });
                e.preventDefault();
            });

    </script>
    
@endsection