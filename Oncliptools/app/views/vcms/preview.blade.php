@extends('vcms.main')

@section('content')

<div class="row">
    <div class="col-md-8">
        <section class="widget">
            <header>
				<h4>Video<small> Preview</small></h4>
            </header>
            <div class="body no-margin">
                <div class="chart visits-chart">
                    <div class="sample-player col-md-8 col-md-offset-2" style="">
                        <div id="akamai-media-player"></div>
                    </div>
                </div>
            </div>
            <p id="waitThumb" class="text-align-center well" style="display:none;"><i class="fa fa-spinner fa-lg fade fa-spin in"></i> {{Lang::get('vcms.msg_thumb')}} </p>
            <div id="imagenes" class="demo-4" style="display:none;" style="width:25%;">
                <!-- Elastislide Carousel -->
                <ul id="carousel" class="elastislide-list" >
                </ul>
                <!-- End Elastislide Carousel -->
            </div>
            <div id="add-cut" class="btn-toolbar pull-right" style="display:none;">
                <button class="btn btn-info btn-xs pull-right" onclick="newSlider();"><i class="fa fa-plus"></i> {{Lang::get('vcms.add_cut')}} </button>
            </div>
        </section>
        {{Form::open(array('url' => 'v1/precission', 'method' => 'post', 'name' => 'namingForm','onsubmit'=>'return CreateClip();'))}}
        <section id="stick" class="widget" style="display:none;">
            <div id="boxSlider">
                <div class="body text-align-center well">
                    <div class="panel" style="width:50%">
                        <div class="panel-heading">
                            <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse-0" style="text-align:left;">
                                {{Lang::get('vcms.title_cut')}}
                            </a>
                        </div>
                        <div id="collapse-0" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="control-group">
                                    <label>{{Lang::get('vcms.video_title')}}</label>
                                    <input id="title-0" type="text" class="form-control" onkeypress="return Letra(event)" onblur="validaL(this)" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="visits-chart" class="row">
                        <input type="text" name="tstart" id="tstart-0" style="width:60px;text-align:center;" type="number" step="0.1" onkeypress="return validarNro(event)" onchange="changeTime(this)"> --| <span id="playerTimerText-0"></span>  |-- <input type="text" name="tend" id="tend-0" style="width:60px;text-align: center;" onkeypress="return validarNro(event)" onchange="changeTime(this)"> 
                        <br><br>
                        <div>
                            <div style="width:100%" class="js-slider" id="slider-0" data-slider-value="[0,180]"></div>
                        </div>
                    </div>
                    <div class="row fontawesome-icon-list" style="text-align:center;">
                            <i id="back10-0" class="fa fa-fast-backward" onclick="avanceVideo(this)"></i>
                            <i id="back5-0" class="fa fa-step-backward" onclick="avanceVideo(this)"></i>
                            <i id="pause-0" class="fa fa-pause" onclick="avanceVideo(this)" style="display:none;"></i>
                            <i id="play-0" class="fa fa-play" onclick="avanceVideo(this)"></i>
                            <i id="step5-0" class="fa fa-step-forward" onclick="avanceVideo(this)"></i>
                            <i id="step10-0" class="fa fa-fast-forward" onclick="avanceVideo(this)"></i>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-4">
		<section class="widget widget-tabs">
            <header>
                <ul class="nav nav-tabs" role="tablist" id="myTab">
                    <li class="active">
                        <a href="#stats" role="tab" data-toggle="tab"><h5>{{Lang::get('vcms.tab1_title')}}</h5></a>
                    </li>
                </ul>
            </header>
            <div class="body tab-content">
                <div id="stats" class="tab-pane active clearfix">
                    <fieldset>
                        <div class="form-group">
                            <label for="canal">{{Lang::get('vcms.channel_label')}}</label>
                            <select name="canal"  class='chzn-select select-block-level' required="required" id='signal'>
                                <option value="">............</option>
                                @foreach ($signals as $key)
                                    <option value="{{$key->short_name}}" id="{{$key->url_signal}}">{{$key->name}}</option>
                                @endforeach
                            </select>   
                        </div>
                        <div class="form-group">
                            <label for="startDateCal" class="control-label">{{Lang::get('vcms.date_label')}}</label>
                            <div class="input-group">
                                <span class="input-group-btn">
									<a href="#" id="btn-select-calendar" class="btn btn-danger" data-date-format="yyyy/mm/dd" data-date=today();><i class="fa fa-calendar"></i></a>
                                </span>
                                <input id="startDateCal" class="form-control" type="text" name="startDateCal" value="" required="required" format="yyyy/mm/dd">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exp">{{Lang::get('vcms.hour_label')}}</label>
                            <input type="time" id="startTime" name="startTime" value="12:00:00" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="number">{{Lang::get('vcms.time_label')}}</label>
                            <div class="controls form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" onkeypress="return validarNro(event)" onblur="validaRango()" name="time" required="required" id="time">
                                <span class="input-group-addon">min</span>
                            </div></div>
                        </div>  
                    </fieldset>
                    <div class="form-actions">
                        <input type="Button" value="Preview" class="btn btn-info" onclick="WatchSelection();">
                        <input id="next" type="Button" value={{Lang::get('vcms.next_botton')}} class="btn btn-primary pull-right" style="display:none;" onclick="nextTab();">
                    </div>               
				</div>
				<div id="options" class="tab-pane">
					<fieldset>
						<div class="form-group">
							<label>{{Lang::get('vcms.geobloqueo_label')}}</label>
							<select name="geoblocking" class="chzn-select select-block-level" required="required">
								<option value="">...</option>
								<option value="only_mex">Sólo México</option>
								<option value="not_usa">Bloqueado a USA y sus territorios</option>
								<option value="only_usa">Sólo EE.UU.</option>
								<option value="latam">Latinoamerica</option>
								<option value="all">Sin restricción</option>
								<option value="">------------------------------------------</option>
								<option value="lateuro">LATEURO</option>
								<option value="latfifa">LATFIFA</option>
								<option value="latmex">LATMEX</option>
								<option value="mex_oti">MEX_OTI</option>
							</select>
						</div>
						<div class="controls form-group">
							<label class="checkbox">
								<input name="galaxyCheck" id="galaxyCheck" type="checkbox" class="check">
								{{Lang::get('vcms.galaxy_label')}}
							</label>
							<div id="ramaGalaxy" class="form-group" style="display:none;">
								<label>{{Lang::get('vcms.rama_galaxy')}}</label>
								<select name="nodeGalaxy" id="nodeGalaxy" class="form-control colorpicker">
									<option value="">...</option>
									<option value="">----------------------- TVOLUCION --------------------</option>
								</select>
							</div>
							<label class="checkbox">
								<input name="cq5Check" id="cq5Check" type="checkbox" class="check">
								{{Lang::get('vcms.CQ5_label')}}
							</label>
							<div id="ramaCQ5" class="form-group" style="display:none;">
								<label>{{Lang::get('vcms.rama_CQ5')}}</label>
								<select name="nodeCQ5" id="nodeCQ5" class="chzn-select select-block-level">
									<option value="">...</option>
								</select>
							</div>
							<label class="checkbox">
								<input name="cq5deportesCheck" id="cq5deportesCheck" type="checkbox" class="check">
								{{Lang::get('vcms.CQ5deportes_label')}}
							</label>
							<div id="ramaCQ5deportes" class="form-group" style="display:none;">
								<label>{{Lang::get('vcms.rama_CQ5deportes')}}</label>
								<select name="nodeCQ5deportes" id="nodeCQ5deportes" class="chzn-select select-block-level">
									<option value="">...</option>
								</select>
							</div>
						</div>
                    	<div class="form-group">
							<label for="exp">{{Lang::get('vcms.program_label')}}</label>
							<select name="program" id="program" class="chzn-select select-block-level" required="required">
								<option value="">...</option>
							</select>
                            <input type="hidden" name="cuts" id="cuts" value="">
                            <input type="hidden" name="tstart" id="tstart" value="">
                            <input type="hidden" name="tend" id="tend" value="">
                            <input type="hidden" name="carThumb" id="carThumb" value="">
						</div>
						<div class="control-group">
							{{Form::label(Lang::get('vcms.video_title'))}}
							{{Form::text('Titulo','',array('class'=>'form-control','required'=>'required',"onkeypress"=>"return Letra(event)", "onblur"=>"validaL(this)"))}}
						</div>
                        <label class="checkbox">
                                <input name="addMaster" id="addMaster" type="checkbox" class="check">
                                {{Lang::get('vcms.add_master')}}
                        </label>
                        <label class="checkbox">
                                <input name="onlyMaster" id="onlyMaster" type="checkbox" class="check">
                                <strong>{{Lang::get('vcms.only_master')}}</strong>
                        </label>
						<div id="botons" class="form-actions">
							{{Form::submit(Lang::get('vcms.createClip_botton'), array('class' => 'btn btn-success pull-right','id' => 'enviar'))}}    
						</div>
					</fieldset>
				</div>
                {{ Form::close() }}
			</div>
        </section>
    </div>
</div>
@stop

@section('scripts')
 @parent

    {{ HTML::script('/light-blue/lib/bootstrap-datepicker.js') }}
    {{ HTML::script('/light-blue/lib/bootstrap-slider-3.0.1/bootstrap-slider.js')}}
    {{ HTML::script('/light-blue/lib/bootstrap/tab.js')}}
    {{ HTML::script('js/scripts_syndi.js') }}
    {{ HTML::script('/amp/amp.premier.min.js?amp-defaults=/amp/amp-samples.xml') }}
    <script type="text/javascript" src="js/calendar.js"></script>
    <script type="text/javascript" src="js/view.js"></script>
    <!--script src="/light-blue/lib/bootstrap/carousel.js"></script-->
    
    <link rel="stylesheet" type="text/css" href="/Elastislide/css/elastislide.css" />
    <link rel="stylesheet" type="text/css" href="/Elastislide/css/custom.css" />
    <script src="/Elastislide/js/modernizr.custom.17475.js"></script>
    <script type="text/javascript" src="/Elastislide/js/jquerypp.custom.js"></script>
    <script type="text/javascript" src="/Elastislide/js/jquery.elastislide.js"></script>
    <!--     "></                  -->
    <script language="JavaScript" type="text/javascript" src="/js/program_list.js"></script>
    <script language="JavaScript" type="text/javascript" src="/js/ramas_cq5.js"></script>
    <script language="JavaScript" type="text/javascript" charset="ISO-8859-1" src="http://feeds.esmas.com/data-feeds-esmas/matrix/ramas_tv3.js" ></script>
    <script language="JavaScript" type="text/javascript" charset="ISO-8859-1" src="http://feeds.esmas.com/data-feeds-esmas/matrix/ramas_video_deportes.js"></script>
    <script language="JavaScript" type="text/javascript" charset="ISO-8859-1" src="http://feeds.esmas.com/data-feeds-esmas/matrix/ramas_ninos.js"></script>
    <script language="JavaScript" type="text/javascript" charset="ISO-8859-1" src="http://feeds.esmas.com/data-feeds-esmas/matrix/ramas_tv3_cq.js"></script>
    <script language="JavaScript" type="text/javascript" charset="ISO-8859-1" src="http://feeds.esmas.com/data-feeds-esmas/matrix/ramas_fiestaMexicana.js"></script>
    
    <script type="text/javascript">
        var start_global=new Array();
        var time,cut_id=0, actual_id=0,tname="#tstart-";
        var parametros=new Array();
        var amp;
        var timestampIni;
        
        $(document).ready(function () {
            
            /***************Ramas Galaxy******************/
            for( var i = 0; i < ramasArray.length; i++ ){
                rama=ramasArray[i][1];
                if((ramasArray[i][1]=="1363")||(rama.substring(0, 4)=="1363")){
                    /***************Ramas  CQ5******************/
                    //$("#nodeCQ5").append('<option value="' + ramasArray[i][1] + '">' + ramasArray[i][0] + '</option>');
                }else{
                    $("#nodeGalaxy").append('<option value="' + ramasArray[i][1] + '">' + ramasArray[i][0] + '</option>');
                }
            }
            $("#nodeGalaxy").append('<option value="">----------------------- DEPORTES --------------------</option>');
            for( var j = 0; j < ramasDeportesArray.length; j++ )
                $("#nodeGalaxy").append('<option value="' + ramasDeportesArray[j][1] + '">' + ramasDeportesArray[j][0] + '</option>');
            $("#nodeGalaxy").append('<option value="">----------------------- NIÑOS --------------------</option>');
            for( var k = 0; k < ramasNinosArray.length; k++ )
                $("#nodeGalaxy").append('<option value="' + ramasNinosArray[k][1] + '">' + ramasNinosArray[k][0] + '</option>');         
            $("#nodeGalaxy").append('<option value="">----------------------- FIESTA MEXICANA --------------------</option>');
            for( var k = 0; k < ramasFiestaMexicana.length; k++ )
                $("#nodeGalaxy").append('<option value="' + ramasFiestaMexicana[k][1] + '">' + ramasFiestaMexicana[k][0] + '</option>');         
            /***************Ramas  CQ5*****************/
            for( var i = 0; i < ramasCQ5.length; i++ )
                $("#nodeCQ5").append('<option value="' + ramasCQ5[i][0] + '">' + ramasCQ5[i][0] + '</option>');

            /***************Ramas  CQ5 Deportes*****************/
            for( var i = 0; i < ramas_tv3cq.length; i++ )
                $("#nodeCQ5deportes").append('<option value="' + ramas_tv3cq[i][1] + '">' + ramas_tv3cq[i][0] + '</option>');

            /***************Programas******************/
            for( var i = 0; i < programasArray.length; i++ )
                $("#program").append('<option value="' + programasArray[i][1] + '">' + programasArray[i][0] + '</option>');
            
            
            
            $("#galaxyCheck").change(function() {
                if($(this).is(':checked'))
                    $("#ramaGalaxy").show();
                else
                    $("#ramaGalaxy").hide();
            });

            $("#cq5Check").change(function() {
                if($(this).is(':checked'))
                    $("#ramaCQ5").show();
                else
                    $("#ramaCQ5").hide();
            });

            $("#cq5deportesCheck").change(function() {
                if($(this).is(':checked'))
                    $("#ramaCQ5deportes").show();
                else
                    $("#ramaCQ5deportes").hide();
            });

            $("#onlyMaster").change(function() {
                if($(this).is(':checked'))
                    alert('{{Lang::get("vcms.msg_onlyMaster")}}');
            });

            $('.date-picker').datepicker({
                autoclose: true
            });

            var $Calendar = $('#startDateCal');
            $Calendar.datepicker({
                autoclose: false
            }).on('changeDate', function(ev){
                $Calendar.datepicker('hide');
            });

            var $btnCalendar = $('#btn-select-calendar');
            $btnCalendar.datepicker({
                autoclose: true
            }).on('changeDate', function(ev){
                    $('#startDateCal').val($btnCalendar.data('date'));
                $btnCalendar.datepicker('hide');
            });

            $("#signal").on('change',function(){
                var Channel = $('option:selected', this).attr('id');
            });

            $("#boxSlider").on("slideStop",".js-slider", function(slideEvt) {
                num=(this.id).split('-');
                cut=num[1];
                valores=slideEvt.value;
                start=valores[0].toFixed(1);
                end=valores[1].toFixed(1);
                $('#boxSlider input').each(function(){ $(this).css({'border-color' : 'white', 'border-width' : '1px' }); });
                if (start_global[cut]==start){
                    player.seek(valores[1]-3);
                    try{
                        posThumb=parseInt((valores[1]/60)*7);
                        carousel.setCurrent( posThumb );
                    }catch(e){
                        //
                    }
                    $("#tend-"+cut).css({'border-color' : 'red' });
                    $("#tend-"+cut).animate({borderWidth:"3px"});
                    tname="#tend-";      
                }else{
                    player.seek(valores[0]);    
                    start_global[cut]=start;
                    try{
                        posThumb=parseInt((valores[0]/60)*7);
                        carousel.setCurrent( posThumb );
                    }catch(e){}      
                    $("#tstart-"+cut).css({'border-color' : 'red' });
                    $("#tstart-"+cut).animate({borderWidth:"3px"});
                    tname="#tstart-";
                }
                $("#tstart-"+cut).val(start);
                $("#tend-"+cut).val(end);
                actual_id=cut;
                amp.play();
            });

            $("#boxSlider").on("focus","input[name=tstart]", function(){
                num=(this.id).split('-');
                cut=num[1];
                actual_id=cut;
                $('#boxSlider input').each(function(){ $(this).css({'border-color' : 'white', 'border-width' : '1px' }); });
                $("#tstart-"+actual_id).css({'border-color' : 'red' });
                $("#tstart-"+actual_id).animate({borderWidth:"3px"});
                tname="#tstart-";          
            });

            $("#boxSlider").on("focus","input[name=tend]", function(){
                num=(this.id).split('-');
                cut=num[1];
                actual_id=cut;
                $('#boxSlider input').each(function(){ $(this).css({'border-color' : 'white', 'border-width' : '1px' }); });
                $("#tend-"+actual_id).css({'border-color' : 'red' });
                $("#tend-"+actual_id).animate({borderWidth:"3px"});
                tname="#tend-";
            });

            $(document).keydown(function(e){
              if (e.keyCode == 32){
                if (amp.getPaused()){
                    $("#play-"+actual_id).hide();
                    $("#pause-"+actual_id).show();
                    amp.play();
                }
                else{
                    $("#pause-"+actual_id).hide();
                    $("#play-"+actual_id).show();
                    amp.pause();
                }
              }
            });

         });
        
        function Letra(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "";
            ascii = [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 95, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121,122];

            tecla_especial = false;
            for(var i in ascii) {
                if(key == ascii[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla) == -1 && !tecla_especial){
                return false;
            }
        }

        function validaL(f) {
    
            var val = f.value; 
            var RegExPattern = /^[a-z0-9_]*$/;
            if ((val.match(RegExPattern)) && (val.value!='')) {
                return true; 
            } else {
                alert('{{Lang::get("vcms.msg_title_val")}}'); 
                return false;
            } 
            
        }
       
        function validarNro(e) {
            var key;
            if(window.event) // IE
                {
                key = e.keyCode;
                }
            else if(e.which) // Netscape/Firefox/Opera
                {
                key = e.which;
                }

            if (key < 48 || key > 57)
                {
                if(key == 46 || key == 8) // Detectar . (punto) y backspace (retroceso)
                    { return true; }
                else 
                    { return false; }
                }
            return true;
        }

        function validaRango() {
            min=parseFloat(document.namingForm.time.value);
            if((min<1)||(min>300)){
                alert('{{Lang::get("vcms.msg_duration_ran")}}');
                document.namingForm.time.focus();
            }
            return true;
            
        }

        function ValidarFecha() {
            today=new Date();
            fecha=$('#startDateCal').val();
            if (fecha==''){
                alert('{{Lang::get("vcms.msg_date")}}');
                $('#startDateCal').focus();
                return false;
            }else{
                tiempo=$('#startTime').val();
                array_fecha = fecha.split("/")
                array_tiempo = tiempo.split(":")
                var fechaDate = new Date(array_fecha[0],(array_fecha[1]-1),array_fecha[2],array_tiempo[0],array_tiempo[1],0);
                if(Date.parse(fechaDate)>today){
                 alert('{{Lang::get("vcms.msg_datehour_ran")}}');
                 $('#startDateCal').focus();
                 return false;
                }
            }
            return true;
        }

        function loadHandler(event) {
            var config_overrides = { autoplay: false }
            var config_overrides = {
                autoplay: true,
                  
                media:{
                    title: "Cue Point Caption Sample",
                    poster: '../resources/images/space_alone.jpg'
                },
                captioning:{
                    enabled: false
                },
                mediaanalytics:{
                    enabled: false
                }
            }
            amp = new akamai.amp.AMP("akamai-media-player", config_overrides);
            amp.addEventListener("timeupdate", timeUpdateHandler);
        }

        function timeUpdateHandler(event) {
            id="playerTimerText-"+actual_id;
            document.getElementById(id).innerHTML = amp.getCurrentTime().toFixed(1);

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
            
            if (!ValidarFecha()){
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
            var timestamp = (fecha.getTime() / 1000 ) ;
            timestampIni=timestamp;
            var channelIndex = document.namingForm.canal.selectedIndex - 1;
            var element = document.getElementById("signal");
            var channel =element[element.selectedIndex].id;
            var liveStreams = channel.split('$$');
            var hds = liveStreams[0] + "&start=" + timestamp + "&end=" +  ( timestamp + time );
            var hls = liveStreams[1] + "&start=" + timestamp + "&end=" +  ( timestamp + time );
            
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
            $("#next").show();
        }
        
        function changeTime(f) {
            var val = f.value;
            num=(f.id).split('-');
            cut=num[1];
            var RegExPattern = /^[0-9]{1,5}(\.[0-9]{0,1})?$/;
            if ((val.match(RegExPattern)) && (val.value!='')) {
                if (f.name=="tstart"){
                    if (val>time) {
                        alert('{{Lang::get("vcms.msg_number_ran")}}'+time); 
                        f.focus();
                        return false;
                    }
                    player.seek(val);
                    start_global[cut]=val;
                    ini=val;
                    fin=$("#tend-"+cut).val();
                }else{
                    if (val>time) {
                        alert('{{Lang::get("vcms.msg_number_ran")}}'+time);
                        f.focus();
                        return false;
                    }
                    player.seek(val-3);
                    ini=$("#tstart-"+cut).val();
                    fin=val;    
                }
                actual_id=cut;
                amp.play();
                $("#slider-"+cut).slider('setValue',[parseFloat(ini),parseFloat(fin)]);
                try{
                    posThumb=parseInt((val/60)*7);
                    carousel.setCurrent( posThumb );
                }catch(e){}

                return true; 
            } else {
                alert('{{Lang::get("vcms.msg_number")}}');
                f.focus();
                return false;
            } 
            
        }

        function avanceVideo(f) {
            var val = f.value;
            var ini_cut, fin_cut, ini;
            num=(f.id).split('-');
            cut=num[1];
            actual_id=cut;
            switch (num[0]){
                case "play":
                    $("#play-"+cut).hide();
                    $("#pause-"+cut).show();
                    ini=$("#tstart-"+cut).val();
                    player.seek(ini);
                    amp.play();
                    break;
                case "pause":
                    $("#pause-"+cut).hide();
                    $("#play-"+cut).show();
                    amp.pause();
                    break;
                case "step5":
                    ini=amp.getCurrentTime()+5;
                    fin_cut=$("#tend-"+cut).val();
                    if(ini<fin_cut){
                        $("#play-"+cut).hide();
                        $("#pause-"+cut).show();
                        player.seek(ini);
                        amp.play();
                    }
                    break;
                case "step10":
                    ini=amp.getCurrentTime()+10;
                    fin_cut=$("#tend-"+cut).val();
                    if(ini<fin_cut){
                        $("#play-"+cut).hide();
                        $("#pause-"+cut).show();
                        player.seek(ini);
                        amp.play();
                    }
                    break;
                case "back5":
                    ini_cut=$("#tstart-"+cut).val();
                    ini=amp.getCurrentTime()-5;
                    if (ini>=ini_cut) {
                        $("#play-"+cut).hide();
                        $("#pause-"+cut).show();
                        player.seek(ini);
                        amp.play();
                    }
                    break;
                case "back10":
                    ini_cut=$("#tstart-"+cut).val();
                    ini=amp.getCurrentTime()-10;
                    if (ini>=ini_cut) {
                        $("#play-"+cut).hide();
                        $("#pause-"+cut).show();
                        player.seek(ini);
                        amp.play();
                    }
                    break;
            }

            
        }

        window.onload = loadHandler;

        function nextTab(){
            if (ValidarFecha()){ 
                
                auxTime=(parseFloat($('#time').val()))*60;
                if (time != auxTime ){
                     if (WatchSelection()=== false)
                        return false;
                }
                
                $("#slider-0").slider({
                    min: 0,
                    max: time,
                    values: [0,time],
                    step: .1,
                    precision: 1,

                });
                $("#slider-0").slider('setValue',[0,time]);

                $("#tstart-0").val('0');
                $("#tstart-0").css({'border-color' : 'red', 'border-width' : '3px' });
                $("#tend-0").val(time);
                $("#stick").show();
                $("#stats").hide();
                $('#options').show();
                $("#add-cut").show();
                $("#waitThumb").show();
                start_global[0]=0;
                id_player=$("#akamai-media-player object").attr('id');
                player = document.getElementById(id_player);

                if (amp.getPaused()){
                    $("#play-"+actual_id).show();
                    $("#pause-"+actual_id).hide();
                }else{
                    $("#pause-"+actual_id).show();
                    $("#play-"+actual_id).hide();
                }

                parametros = {
                    "canal" : $("#signal").val(),
                    "startDateCal": $("#startDateCal").val(),
                    "startTime": $("#startTime").val(),
                    "time": $("#time").val()
                }; 
                
                updateThumb();
                

            }else
                return false;
            
        }

        function updateThumb(){
            $.ajax({
                url:  '/timelineThumb',
                type: 'post',
                data: parametros,
                success: function(result) {
                    console.log(result);
                    if (typeof result['thumbnails'] != 'undefined') {
                        //clearInterval(interval); // stop the interval
                        imgThumb=result['thumbnails'];
                        if(imgThumb.length > 0){
                            var minImg=8;
                            var totalImg=imgThumb.length;
                            if (totalImg<8)
                                minImg=4;
                            for(thumb in imgThumb){
                                imgUrl=imgThumb[thumb]['url'];
                                    $('#carousel').append('<li id="'+imgThumb[thumb]['name']+'"><a href="#"><img src="'+imgThumb[thumb]['url']+'" alt="'+imgThumb[thumb]['name']+'" /></a></li>');
                            }
                            var carpeta=imgUrl.split('/');
                            $("#waitThumb").hide();
                            $("#carThumb").val(carpeta[2]);
                            $( '#imagenes' ).show();
                            carousel = $('#carousel').elastislide( {
                                minItems : minImg,
                                start : 0,
                                speed : 500,
                                onClick : function( el, pos, evt ) {
                                        changeImage( el, pos );
                                        evt.preventDefault();
                                }
                            });
                        }else{
                            $("#waitThumb").html('No se exiten imagenes en el rango seleccionado');
                        }
                    }
                },
                error: function(result){
                    //clearInterval(interval); // stop the interval
                    $("#waitThumb").html('{{Lang::get("vcms.error_label")}}');
                    console.log(result);
                }
            });
        }

        function changeImage( el, pos ) {
            var minThum=0;
            idimg=$(el).attr('id');
            imgTemp=idimg.split('_');
            imgMin=parseInt(imgTemp[0]);
            imgX=imgTemp[1].split('.');
            imgPos=parseInt(imgX[0])-1;
            if (imgPos==0)
                minThum=imgMin-timestampIni;
            else
                minThum=((imgMin-timestampIni)+(imgPos*10))-5;
            //minThum=(pos*10)-5;
            if (minThum<0) {
                minThum=0;
            }
            if (minThum>time) {
                minThum=time;
            }
            if(tname=="#tstart-"){
                $("#tstart-"+actual_id).val(minThum);
                start_global[actual_id]=minThum;
                var tfin=$("#tend-"+actual_id).val();
                $("#slider-"+actual_id).slider('setValue',[parseFloat(minThum),parseFloat(tfin)]);
                player.seek(minThum);
            }else{
                $("#tend-"+actual_id).val(minThum);
                var tini=$("#tstart-"+actual_id).val();
                $("#slider-"+actual_id).slider('setValue',[parseFloat(tini),parseFloat(minThum)]);
                player.seek(minThum-3);
            }
            amp.play();  
        }
        
        function newSlider(){
            ini=parseFloat($("#tend-"+cut_id).val());
            if ((!ini)||(ini==time)){
                ini=0;
            }
            if (ini>time){
                alert('{{Lang::get("vcms.msg_number_ran")}}'+time);
                $("#tend-"+cut_id).focus();
                return false;
            }
            cut_id+=1;
            $("#boxSlider").prepend('<div id="cut-'+cut_id+'" class="widget text-align-center well">'+
                '<header><div class="widget-controls"><a id="remove-'+cut_id+'" data-widgster="close" title="{{Lang::get("vcms.delete_cut")}}" onclick="removeSlider(this);"><i class="glyphicon glyphicon-remove"></i></a></div></header>'+
                '<div class="panel" style="width:50%"><div class="panel-heading"><a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapse-'+cut_id+'" style="text-align:left;">{{Lang::get("vcms.title_cut")}}</a></div>'+
                    '<div id="collapse-'+cut_id+'" class="panel-collapse collapse"><div class="panel-body"><div class="control-group">'+
                        '<label>{{Lang::get("vcms.video_title")}}</label>'+
                        '<input id="title-'+cut_id+'" type="text" class="form-control" onkeypress="return Letra(event)" onblur="validaL(this)">'+
                    '</div></div></div>'+
                '</div>'+
                '<div id="visits-chart" class="row">'+
                    '<input type="text" name="tstart" id="tstart-'+cut_id+'" style="width:60px;text-align:center;" type="number" step="0.1" '+'onkeypress="return validarNro(event)" onchange="changeTime(this)"> --| <span id="playerTimerText-'+cut_id+'"></span>  |-- <input type="text" name="tend" id="tend-'+cut_id+'" style="width:60px;text-align: center;" onkeypress="return validarNro(event)" onchange="changeTime(this)"> '+
                    '<br><br>'+
                    '<div>'+
                        '<div style="width:100%" class="js-slider" id="slider-'+cut_id+'" data-slider-value="[0,180]"></div>'+
                    '</div>'+
                '</div>'+
                    '<div class="row fontawesome-icon-list" style="text-align:center;">'+
                            '<i id="back10-'+cut_id+'" class="fa fa-fast-backward" onclick="avanceVideo(this)"></i>'+
                            '<i id="back5-'+cut_id+'" class="fa fa-step-backward" onclick="avanceVideo(this)"></i>'+
                            '<i id="pause-'+cut_id+'" class="fa fa-pause" onclick="avanceVideo(this)" style="display:none;"></i>'+
                            '<i id="play-'+cut_id+'" class="fa fa-play" onclick="avanceVideo(this)"></i>'+
                            '<i id="step5-'+cut_id+'" class="fa fa-step-forward" onclick="avanceVideo(this)"></i>'+
                            '<i id="step10-'+cut_id+'" class="fa fa-fast-forward" onclick="avanceVideo(this)"></i>'+
                    '</div>'+
                '</div>');
            $("#slider-"+cut_id).slider({
                    min: 0,
                    max: time,
                    values: [0,time],
                    step: .1,
                    precision: 1,

                });
            $("#slider-"+cut_id).slider('setValue',[ini,time]);
            $("#tstart-"+cut_id).val(ini);
            $('#boxSlider input').each (function(){ $(this).css({'border-color' : 'white', 'border-width' : '1px' }); });
            $("#tstart-"+cut_id).css({'border-color' : 'red', 'border-width' : '3px' });
            $("#tend-"+cut_id).val(time);
            start_global[cut_id]=0;
            actual_id=cut_id;
            tname="#tstart-";
            return false;
        }

        function removeSlider(s){
            num=(s.id).split('-');
            cut=num[1];
            $("#cut-"+cut).remove();
        }

        function CreateClip() {
            var RegExPattern = /^[0-9]{1,5}(\.[0-9]{0,1})?$/;
            var cortes = new Array();
            var pass=false;
            idx=0;
            $('#boxSlider .js-slider').each (function(){
                num=(this.id).split('-');
                cut=num[1];
                ini=$("#tstart-"+cut).val();
                fin=$("#tend-"+cut).val();
                if( parseInt(ini) > parseInt(fin) ){
                    alert('{{Lang::get("vcms.msg_hour_val")}}');
                    $("#tstart-"+cut).select();
                    pass=true;
                    return false;
                }

                if (!(ini.match(RegExPattern)) || (ini=="")){
                    alert('{{Lang::get("vcms.msg_number")}}');
                    $("#tstart-"+cut).select();
                    pass=true;
                    return false;
                }else if(!(fin.match(RegExPattern)) || (fin=="")){
                    alert('{{Lang::get("vcms.msg_number")}}');
                    $("#tend-"+cut).select();
                    pass=true;
                    return false;
                }

                title_cut=$("#title-"+cut).val();
                var RegExPattern = /^[a-z0-9_]*$/;
                if (!(title_cut.match(RegExPattern))) {
                    alert('{{Lang::get("vcms.msg_title_val")}}');
                    $("#title-"+cut).select();
                    pass=true; 
                    return false;
                } 

                if(title_cut==''){
                    cuts =  {
                            "time_start":ini,
                            "time_end":fin
                    };
                }else{
                    cuts =  {
                            "time_start":ini,
                            "time_end":fin,
                            "title":title_cut,
                    };
                } 
                cortes[idx++]=cuts;
            });
            if (pass)
                return false;
            if ((cortes.length)>1)
                $("#cuts").val(JSON.stringify(cortes));
            $("#tstart").val($("#tstart-0").val());
            $("#tend").val($("#tend-0").val());
            if( !($("#galaxyCheck").is(':checked')) && !($("#cq5Check").is(':checked')) && !($("#cq5deportesCheck").is(':checked'))){
                alert('{{Lang::get("vcms.msg_site")}}');
                return false;
            }
            $("#enviar").attr('disabled', 'disabled');
            return true;
        }
        
    </script>
    
@stop