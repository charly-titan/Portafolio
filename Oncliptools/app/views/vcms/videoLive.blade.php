@extends('vcms.main')

@section('content')

<style type="text/css">
    .rickshaw_annotation_timeline .annotation .content {
        background: white;
        color: black;
        opacity: 0.7;
        width: 50px;
        font-size: 10px;
        padding: 5px 8px 5px;
     
    }
    
</style>
<div class="row">
    <div class="col-md-8">
        <section class="widget">
            <header>
				<h4>Video<small> LIVE</small></h4>
            </header>
            <div class="body no-margin">
                <div class="chart visits-chart">
                    <div class="sample-player col-md-10 col-md-offset-1" >
                        <div id="akamai-media-player"></div>
                    </div>
                </div>
            </div>
            <div class="body row">
                <div class="col-sm-2" style="display:none;">
                    <div id="legend"></div>
                </div>
                <div class="col-md-10 col-md-offset-1" id="chart-container">
                    <div id="realtime-chart" style="height: 100px;">
                    </div>
                    <div id="timeline"></div>
                </div>
            </div>
            {{Form::open(array('url' => 'v2/detalle', 'method' => 'post', 'name' => 'cutForm', 'target' => '_blank'))}}
            <div id="crearClip" class="btn-toolbar pull-right" style="display:none;">
                <button type="submit" class="btn btn-info btn-xs pull-right" alt="Crear clip"><i class="fa fa-cut"></i> Clip</button>
            </div>
        </section>
        <section class="widget">
            <div>
                <div class="body text-align-center well">
                    <button id="setIn" type="button" class="btn btn-primary">
                        <i class="fa fa-sign-in"></i> Set in  
                    </button>
                    <button id="setOut" type="button" class="btn btn-danger">
                        <i class="fa fa-sign-out"></i> Set out
                    </button>
                    <button type="submit" id="cutClip" type="button" class="btn btn-info">
                        <i class="fa fa-cut"></i> Clip
                    </button>
                </div>    
                <div id="enviar_gol" class="body text-align-center well" style="display:none;">
                    <header>
                        <strong>Enviar Goles <small> Transmitidos en TV</small></atrong>
                    </header>
                    <button id="gol_local" type="button" class="btn btn-success">
                        <i class="fa fa-circle"></i> Gol local
                    </button>
                    <button id="gol_visit" type="button" class="btn btn-success">
                        <i class="fa fa-circle"></i> Gol visitate
                    </button>
                </div>
            </div>     
        </section>
    </div>
    <div class="col-md-4">
		<section class="widget widget-tabs">
            <header>
                <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li class="active">
                        <a href="#stats" role="tab" data-toggle="tab"><h5>Canal{{--Lang::get('vcms.tab1_title')--}}</h5></a>
                    </li>
                </ul>
            </header>
            <div class="body tab-content">
                <div id="stats" class="tab-pane active clearfix">
                    <fieldset>
                        <div class="form-group">
                            <label for="canal">{{Lang::get('vcms.channel_label')}}</label>
                            <select name="canal" id='signal' class='chzn-select select-block-level' required="required">
                                @foreach ($signals as $key)
                                    <option value="{{$key->short_name}}" id="{{$key->url_signal}}">{{$key->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="game">Selecciona el partido</label>
                            <select name="game" id='game' class='chzn-select select-block-level'>
                                <option value="">............</option>
                                <option value="0">Crear nuevo partido</option>
                                @foreach ($games as $key)
                                    <option value="{{$key['game']->id}}" id="{{$key['game']->id}}"><strong>{{$key['local']->abreviatura}}-{{$key['visitante']->abreviatura}}</strong> {{$key['game']->fecha_partido}} {{$key['game']->hora_partido}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="start" id="start" value="">
                            <input type="hidden" name="end" id="end" value="">   
                        </div>
                    </fieldset>
				</div>
               {{ Form::close() }}
			</div>
        </section>
        
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-mail-forward"></i>
                    Goles enviados
                </h4>
            </header>
            <div id="goles" class="body">
                <div id="msg">
                    <p>No se han generado goles</p>
                </div>
            </div>
        </section>
    
    </div>
</div>
@stop

@section('scripts')
 @parent
    {{ HTML::script('/amp/amp.premier.min.js?amp-defaults=/amp/amp-samples.xml') }}


    {{ HTML::script('/light-blue/lib/jquery-pjax/jquery.pjax.js')}}
    <!-- jquery and friends -->
    {{ HTML::script('/light-blue/lib/jquery-ui-1.10.3.custom.js')}}
    <!-- d3-->
    {{ HTML::script('/light-blue/lib/nvd3/lib/d3.v2.js')}}
    {{ HTML::script('/light-blue/lib/d3.layout.min.js')}}
    <!-- rickshaw -->
    {{ HTML::script('/light-blue/lib/rickshaw/rickshaw.js')}}
    {{ HTML::script('/light-blue/lib/rickshaw/rickshaw-extensions.js')}}
    <!-- basic application js-->
    {{ HTML::script('/light-blue/js/app.js')}}
   
    
    
    <script type="text/javascript">
        var start_global=new Array();
        var time,cut_id=0, actual_id=0,tname="#tstart-";
        var info_img=new Array();
        var info_down=new Array();
        var amp,player;
        
        $(document).ready(function () {
            $("#signal").on('change',function(){
                var Channel = $('option:selected', this).attr('id');
                WatchSelection();
            });

            $("#game").on('click',function(){
                var idx = $('option:selected', this).val();
                if (idx=="0"){
                    document.location.href = "/games";
                    //console.log(idx);
                }else if(idx!=""){
                    i=parseInt(idx);
                    local="";
                    visitante="";
                    @foreach ($games as $key)
                        if(i=={{$key['game']->id}}){
                            local="{{$key['local']->nombre}}";
                            visitante="{{$key['visitante']->nombre}}";
                        }
                    @endforeach
                    $("#gol_local").html("Gol del "+local);
                    $("#gol_visit").html("Gol del "+visitante);
                    $("#enviar_gol").show();
                    interval = setInterval(showGoles,20000);
                    console.log("local:"+local+" visitante:"+visitante);

                }else{
                    $("#enviar_gol").hide();
                    clearInterval(interval); // stop the interval
                }
            });


            jQuery.fn.exists = function(){return this.length>0;}

            function showGoles(){
                var datos = {
                    "partido": parseInt($("#game").val())
                };
                $.ajax({
                    url: '/goles',
                    type: 'post',
                    data: datos,
                    success: function(result) {
                        info_goles=result['info_goles'];
                        if(info_goles.length > 0){
                            console.log(info_goles);
                            if ($('#msg').exists()){ $('#msg').remove();}
                            for(gol in info_goles){
                                var idG='#gol-'+info_goles[gol]['id'];
                                if ($(idG).exists()){
                                    //ya no lo agrega para no duplicar goles
                                }else{
                                    $('#goles').append('<div id="gol-'+info_goles[gol]['id']+'" class="well well-sm"><h5 class="no-margin weight-normal"> Gol del '+info_goles[gol]['equipo']+'</h5><footer><small>'+info_goles[gol]['time']+'</small></footer><div class="row margin-bottom text-align-left"></div><a id='+info_goles[gol]['id']+' href="javascript:void(null);" onclick="deleteGol(this)"><span class="badge badge-danger">Eliminar</span></a></div>');
                                }
                                
                            }
                            $('#goles div').each(function(idx, el){
                                if ($(el).hasClass('well well-sm')){
                                    iden=$(el).attr('id');
                                    num=iden.split('-');
                                    id=num[1];
                                    remElem=true;
                                    for(gol in info_goles){
                                        if(info_goles[gol]['id']==id)
                                            remElem=false;
                                    }
                                    if (remElem) {
                                        $(el).remove();
                                    }
                                }
                            });


                        }else{
                            $('#goles').html('<div id="msg"><p>No se han generado goles</p></div>');
                        }
                    },
                    error: function() {
                           $("#goles").html('<div id="msg"><p>{{Lang::get("vcms.error_label")}}</p></div>');
                    }
                }); 
            }


        });
        

        function deleteGol(s) {
            id_gol=s.id;
            var parametros = {
                "id_gol" :id_gol
            }; 
            $.ajax({
                url: '/deletegol',
                type: 'post',
                data: parametros,
                success: function(result) {
                    $('gol-'+id_gol).remove();
                    console.log(result);
                },
                error: function(result) {
                    console.log(result);
                }
            });
            
        }

        function loadHandler(event) {
            var config_overrides = {
                autoplay: true,
                loop: true,
                media:{
                    title: "Live",
                    temporalType: "live",
                    source:[
                            {src:"http://tvsawpdvr-lh.akamaihd.net/z/stch02wp_1@119660/manifest.f4m?b=150-970", type: "video/mp4"}
                    ]
                }
            }
            amp = new akamai.amp.AMP("akamai-media-player", config_overrides);
            amp.addEventListener("timeupdate", timeUpdateHandler);
        }

        function timeUpdateHandler(event) {
            id="playerTimerText-"+actual_id;
            document.getElementById(id).innerHTML = amp.getCurrentTime().toFixed(1);
            time=amp.getCurrentTime().toFixed(1);
            id_player=$("#akamai-media-player object").attr('id');
            player = document.getElementById(id_player);
            if( amp.getCurrentTime().toFixed(1) == parseFloat($("#tend-"+actual_id).val()) ){
                amp.pause();
                $("#pause-"+actual_id).hide();
                $("#play-"+actual_id).show();
            }else{
                $('.fa-pause').each (function(){ $(this).hide(); });
                $('.fa-play').each (function(){ $(this).show(); });
                if (amp.getPaused()){
                    $("#pause-"+actual_id).hide();
                    $("#play-"+actual_id).show();
                }else{
                    $("#pause-"+actual_id).show();
                    $("#play-"+actual_id).hide();
                }
            }
        }

        function WatchSelection() {
            /*if (!ValidarFecha()){
               return false;
            }
            if( document.namingForm.time.value == '' ){
                alert('{{Lang::get("vcms.msg_duration")}}');
                return false;
            }
            if( document.namingForm.startDateCal.value == '' ){
                alert('{{Lang::get("vcms.msg_datehour_ran")}}');
                return false;
            }
            var cal = document.namingForm.startDateCal.value;
            var calTime = document.namingForm.startTime.value;
            time = (parseFloat( document.namingForm.time.value ))*60;
            var fecha = new Date( parseInt(cal.substring(0,4)), (parseInt(cal.substring(5,7))-1), parseInt(cal.substring(8,10)), parseInt(calTime.substring(0,2)), parseInt(calTime.substring(3,5)), 0);
            var timestamp = (fecha.getTime() / 1000 ) ;*/
            //var channelIndex = document.namingForm.canal.selectedIndex - 1;
            var element = document.getElementById("signal");
            var channel =element[element.selectedIndex].id;
            var liveStreams = channel.split('$$');
            var hds = liveStreams[0];// + "&start=" + timestamp + "&end=" +  ( timestamp + time );
            var hls = liveStreams[1];// + "&start=" + timestamp + "&end=" +  ( timestamp + time );
            
            console.log(hds);
            var video = {
                title: "Live",
                source: [
                    {src: hds, type: "video/f4m"},
                    {src: hls, type: "application/x-mpegURL"}
                ]                                   
            };
            
            amp.setMedia(video);
            amp.play();
            time=amp.getCurrentTime();
            //$("#next").show();
        }
        
        window.onload = loadHandler;



        
    </script>
    {{ HTML::script('/js/realtime.js')}}
    
@stop