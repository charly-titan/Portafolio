@extends('vcms.main')
@section('content')

<div class="row">
<!--
|-------------------------------------------------------------------------------
| Video Preview Dephasing Video
|-------------------------------------------------------------------------------
|
-->    
    <div class="col-md-4">
        <section class="widget">
            <header><h4><i class="fa fa-play"></i>{{Lang::get('escaleta.video')}}<small>{{Lang::get('escaleta.preview')}}</small></h4></header><br>
            <div class="body no-margin">
                <div id="visits-chart" class="chart visits-chart">
                    <div class="sample-player col-md-15 col-md-offset-0" style="">
                        <div id="akamai-media-player" ></div>
                    </div>
                </div>  
            </div><br>
            <!--
            |-------------------------------------------------------------------------------
            | Icrement and Decrement Dephasing Video
            |-------------------------------------------------------------------------------
            |
            -->            
            <div class="form-group">
                <h4><i class="fa fa-pencil"></i> <b>{{Lang::get('escaleta.lag')}}</b> <small>{{Lang::get('escaleta.videoClips')}}</small></h4>
                <div class="input-group">
                    <input id="inputDephasingVideo" type="text" name="inputDephasingVideo" value="0" class="form-control" >
                    <div class="input-group-btn">
                        <button type="button" id="incrementDephasingVideo" class="btn btn-success" ><i class="fa fa-plus" ></i></button>
                        <button type="button" id="decrementDephasingVideo" class="btn btn-danger" ><i class="fa fa-minus"></i></button>
                        <button type="button" id="saveDephasingVideo" class="btn btn-success" ><i class="fa fa-save"></i></button>
                    </div>
                </div>
                <!--
                |-------------------------------------------------------------------------------
                | SavedMessage
                |-------------------------------------------------------------------------------
                |
                -->                
                <div id="savedMessage" class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                    <strong><i class="fa fa-check"></i>{{Lang::get('escaleta.veryGood')}}<div id="message_save"></div></strong>
                </div>
            </div>                    
        </section>
    </div>
<!--
|-------------------------------------------------------------------------------
| Editor of Video Clips
|-------------------------------------------------------------------------------
|
-->
<div id="editorfeeds" class="col-md-4 col-md-offset-0">
    <section class="widget">
        <header><h4><i class="fa fa-pencil"></i>{{Lang::get('escaleta.editorVideo')}}</h4></header>
        <div class="body">
            <form method="post">
                <fieldset>
                    <div class="row">
                        <div class="col-sm-12">                        
                            <div class="form-group">
                                <!--
                                |-------------------------------------------------------------------------------
                                | Title of Video Clips
                                |-------------------------------------------------------------------------------
                                |
                                -->                                
                                <div class="control-group">
                                    <legend class="section">{{Lang::get('escaleta.titleVideo')}}</legend>
                                    <div class="controls form-group">
                                        <textarea id="titleVideoClips" type="text" class="form-control input-lg" placeholder="" style="resize:vertical; "></textarea>
                                    </div>
                                </div>
                                <!--
                                |-------------------------------------------------------------------------------
                                | Start Time of Video Clips
                                |-------------------------------------------------------------------------------
                                |
                                -->
                                <div class="form-group no-margin">
                                    <legend class="section">{{Lang::get('escaleta.initialTime')}}</legend>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="eicon-clock"></i></span>
                                        <input id="startTime" type="text" class="form-control" placeholder="">
                                        <div class="input-group-btn">
                                            <button type="button" id="timeIncrement" class="btn btn-success" ><i class="fa fa-plus" ></i></button>
                                            <button type="button" id="timeDecrement" class="btn btn-danger"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div> 
                                <!--
                                |-------------------------------------------------------------------------------
                                | Duration of Video Clips
                                |-------------------------------------------------------------------------------
                                |
                                -->
                                <div class="form-group no-margin">
                                    <legend class="section">{{Lang::get('escaleta.lengthVideo')}}</legend>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="eicon-chart-pie"></i></span>
                                        <input id="durationVideo" type="text" class="form-control" placeholder="">
                                        <div class="input-group-btn">
                                            <button type="button" id="durationIncrement" class="btn btn-success" ><i class="fa fa-plus" ></i></button>
                                            <button type="button" id="durationDecrement" class="btn btn-danger" ><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <!--
                                |-------------------------------------------------------------------------------
                                | Status of Video Clips
                                |-------------------------------------------------------------------------------
                                |
                                -->
                                <legend class="section">{{Lang::get('escaleta.estatesVideo')}}</legend>                                      
                                    {{Form::radio('status', '1', false,array('id'=>'displayStatusVideo'));}}
                                    <label for="displayStatusVideo">{{Lang::get('escaleta.visible')}}</label>

                                    {{Form::radio('status', '0', false,array('id'=>'hiddenStatusVideo'));}}
                                    <label for="hiddenStatusVideo">{{Lang::get('escaleta.hidden')}}</label>

                                <div id="log"></div>
                            <!--
                            |-------------------------------------------------------------------------------
                            | Buttons Test, Save and Retorn
                            |-------------------------------------------------------------------------------
                            |
                            --> 
                                <div class="form-actions" style="text-align: center;">                                           
                                        <button id='previewVideoClips' type="button"  class="btn btn-default" style="width: 70px;"><i class="fa fa-play"></i>{{Lang::get('escaleta.test')}}</button>
                                        <button id="saveVideoClips"    type="button"  class="btn btn-success" style="width: 76px;"><i class="fa fa-save"></i>{{Lang::get('escaleta.save')}}</button>
                                        <button id='restoreVideoClips' type="button"  class="btn btn-default" style="width: 88px;"><i class="eicon-back-in-time"></i>{{Lang::get('escaleta.return')}}</button>                                          
                                </div>
                            
                                <!--
                                |-------------------------------------------------------------------------------
                                | Save Editor Alert
                                |-------------------------------------------------------------------------------
                                |
                                -->
                                <div id="saveEditorAlert" class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                                    <strong><i class="fa fa-check"></i>{{Lang::get('escaleta.saveChange')}}<div id="message_save"></div></strong>
                                </div>
                            </div>
                        </div>
                    </div>    
                </fieldset>
            </form>
        </div>
    </section>
</div>            
<!--
|-------------------------------------------------------------------------------
| Escaleta Items Show All Feeds
|-------------------------------------------------------------------------------
|
-->
<div class="col-md-4">
    <section class="widget tiny-x2">
        <header>
            <!--
            |-------------------------------------------------------------------------------
            | Feeds All Feeds
            |-------------------------------------------------------------------------------
            |
            -->            
            <h4><i class="fa fa-list"></i>{{Lang::get('escaleta.escaleta')}}<span class="label label-success"></span>
                <span class="label label-success" style="position: relative; left: 54%; font-size: 15px;"> {{Lang::get('escaleta.feeds')}} <span id="counterFeeds"><b>{{$counterFeeds}}</b></span></span>
            </h4>
            <!--
            |-------------------------------------------------------------------------------
            | Search Refresh
            |-------------------------------------------------------------------------------
            |
            -->
            <div class="actions" style="position:relative; top: 15px; left:90%; ">
                <button class="btn btn-transparent btn-xs" id="search_btn" style="width:30px; height: 30px; background-color: #0099ff;"><i class="fa fa-refresh"></i></button>
            </div>
            <!--
            |-------------------------------------------------------------------------------
            | Seled Feeds Program
            |-------------------------------------------------------------------------------
            |
            -->            
            <div style="position:relative; width:50%; top:-15px; left:39%;">
                    {{Form::select('channels',$channels,$clave,array("id"=>"chanel", "class"=>"chzn-select select-block-level"))}}
            </div> 
            <!--
            |-------------------------------------------------------------------------------
            | btn-select-calendar
            |-------------------------------------------------------------------------------
            |
            -->             
            <div style="position:relative; width:38%; top:-45px; left: 0%;">    
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a href="#" id="btn-select-calendar" class="btn btn-danger" data-date-format="yyyy/mm/dd" data-date=today();>
                                <i class="fa fa-calendar"></i>
                            </a>
                        </span>
                        <input id="startDateCal" class="form-control" type="text" name="startDateCal" value="{{date('Y-m-d')}}" required="required" format="yyyy/mm/dd">
                    </div>
                </div>                                
            </div>  
        </header>
        <!--
        |-------------------------------------------------------------------------------
        | escaleta.display_items
        |-------------------------------------------------------------------------------
        |
        -->         
        <div class="body" style="position: relative; top:-53px; height:347px;">
            <div id="feed" class="feed" style=" height:347px;">
                <div class="wrapper">
                    <div class="vertical-line"></div>
                    <!--
                    |-------------------------------------------------------------------------------
                    | SavedMessage
                    |-------------------------------------------------------------------------------
                    |
                    -->                     
                    <div id="searchItems" class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">�</button>
                        <strong><i class="fa fa-check"></i>{{Lang::get('escaleta.searchItems')}}<div id="message_save"></div></strong>
                    </div>
                    
                    <div id="displayItemsFeeds">@include('escaleta.display_items')</div> 
                
                </div>
            </div>
        </div>
    </section>

</div>
</div>
@stop

@section('scripts')
 @parent
   
{{ HTML::script('/light-blue/lib/bootstrap-datepicker.js') }}
{{ HTML::script('js/scripts_syndi.js') }}
<!--    {{ HTML::script('/amp/amp.min.js?/amp/samples.xml') }}-->
{{ HTML::script('/amp/amp.premier.min.js?amp-defaults=/amp/amp-samples.xml') }}
<script language="JavaScript" type="text/javascript" src="js/program_list.js"></script>
<script language="JavaScript" type="text/javascript" src="js/ramas_tv3.js"></script>
<script language="JavaScript" type="text/javascript" src="js/ramas_video_deportes.js"></script>
<script language="JavaScript" type="text/javascript" src="js/ramas_ninos.js"></script>
<script type="text/javascript" src="js/calendar.js"></script>
<script type="text/javascript" src="js/view.js"></script>
<script src="/light-blue/lib/sparkline/jquery.sparkline.js"></script>
<script src="/light-blue/lib/jquery-ui-1.10.3.custom.js"></script>
<script src="/light-blue/lib/jquery.slimscroll.js"></script>
    
<script type="text/javascript">
/*
|-------------------------------------------------------------------------------
| Variables Globales
|-------------------------------------------------------------------------------
|
*/     
var clave = $('#chanel').val(); 
var fecha_input = $('#startDateCal').val(); 
/*
|-------------------------------------------------------------------------------
| escaleta/displayCounterFeeds
|-------------------------------------------------------------------------------
|
*/ 
$('#search_btn').on('click',function(event) {   
    clave = $('#chanel').val(); 
    fecha_input = $('#startDateCal').val(); 
    $.ajax({
        url: 'escaleta/displayCounterFeeds',
        type: 'get',
        data: {'clave': clave,"fecha":fecha_input},
        success: function(data) {
           if (data) {
              $('#counterFeeds').html(data);
           } else {
              $('#counterFeeds').html('<div>0</div>');
           }
           attachevent();
        }
     });
});
/*
|-------------------------------------------------------------------------------
| escaleta/displayItemsFeeds
|-------------------------------------------------------------------------------
|
*/
$('#searchItems').hide();
$('#search_btn').on('click',function(event) {   
    clave = $('#chanel').val(); 
    fecha_input = $('#startDateCal').val(); 
    $.ajax({
        url: 'escaleta/displayItemsFeeds',
        type: 'get',
        data: {'clave': clave,'fecha':fecha_input},
        beforeSend: function() {
             $('#searchItems').show('slow');
             $('#searchItems').hide(2000);             
        },
        error: function() {
           $('#displayItemsFeeds').html('<div>No hay Items</div>');
        },
        success: function(data) {
           if (data) {
              $('#displayItemsFeeds').html(data).css('background-color','');
           } else {
              $('#displayItemsFeeds').html('<div>No hay Items.</div>');
           }
           attachevent();
        }
     });
});
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo : Variables Globales
|-------------------------------------------------------------------------------
|
*/    
var value = $('#inputDephasingVideo').val();
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo
|-------------------------------------------------------------------------------
|
*/ 
$(document).ready(function(){
    value = $('#inputDephasingVideo').val();
    $.ajax({
            url: 'escaleta/displayDephasingVideo',
            type: 'get',
            data: {'clave': clave,'fecha':fecha_input,'value':value},
            success: function(data) {
               if (data) {
                  $('#inputDephasingVideo').attr('value',data);
               } else {
                  $('#inputDephasingVideo').attr('value',0);
               }
            }
          });
});
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo
|-------------------------------------------------------------------------------
|
*/
$('#search_btn').click(function(){
    value = $('#inputDephasingVideo').val();
    $.ajax({
            url: 'escaleta/displayDephasingVideo',
            type: 'get',
            data: {'clave': clave,'fecha':fecha_input,'value':value},
            success: function(data) {
                    if (data) {
                      $('#inputDephasingVideo').attr('value',data);
                    } else {
                      $('#inputDephasingVideo').attr('value',0);
                    }
                }
            });
 });
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo : incrementDephasingVideo
|-------------------------------------------------------------------------------
|
*/       
var dephasingVideo = $('#inputDephasingVideo').val();

$('#inputDephasingVideo').attr('readonly', true);

$('#incrementDephasingVideo').on("click",function() {
    incrementValueDephasing($('#inputDephasingVideo'));
    dephasingVideo = parseInt($('#inputDephasingVideo').val());
}); 

function incrementValueDephasing(selector) {
    var $item = selector;
    var $oldVal = $item.attr("value");
    $item.attr("value", parseInt($oldVal) + 1 );
}
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo : decrementDephasingVideo
|-------------------------------------------------------------------------------
|
*/ 
$("#decrementDephasingVideo").on('click',function() {
    decrementValueDephasing($('#inputDephasingVideo')); 
    dephasingVideo = parseInt($('#inputDephasingVideo').val());
});
    
function decrementValueDephasing(selector) {
    var $item = selector;
    var $oldVal = $item.attr('value');
    $item.attr('value',parseInt($oldVal) - 1);
}
/*
|-------------------------------------------------------------------------------
| escaleta/displayDephasingVideo : saveDephasingVideo
|-------------------------------------------------------------------------------
|
*/
$('#savedMessage').hide();

$('#saveDephasingVideo').on('click',function(){
    $('#savedMessage').show('slow');
    $('#savedMessage').hide(5000);

    $.ajax({
            url: 'escaleta/saveDephasingVideo',
            type: 'get',
            data: {'fecha':fecha_input,'clave': clave,'dephasingVideo':dephasingVideo},
            success: function(data) {
               if (data) {
                  $("#savedMessage").html(data);
               } else {
                  /* No existe datos ... */
               }                    
            }
           });        
});
</script>
     
<script>
/*
|-------------------------------------------------------------------------------
| escaleta/displayEditorVideo : editorVideoClips
|-------------------------------------------------------------------------------
|
*/    

/*
|-------------------------------------------------------------------------------
| Variables Globales
|-------------------------------------------------------------------------------
|
*/
var titleVideoClips = $("#titleVideoClips").val();
var secuency = 0;
var status = $("input[name='status']").val();

$('#titleVideoClips').attr('readonly', true);
$('#displayStatusVideo').attr('disabled',true);
$('#hiddenStatusVideo').attr('disabled',true);
            
function attachevent(){ 
    $('.feed-item').on('click',function(){
        titleVideoClips = $("#titleVideoClips").val();
        secuency = this.id;
        $('#titleVideoClips').attr('readonly', false);
        $('#displayStatusVideo').attr('disabled',false);
        $('#hiddenStatusVideo').attr('disabled',false);
        
        $.ajax({
                url: 'escaleta/displayEditorVideo',
                type: 'get',
                data: {'fecha':fecha_input,'clave': clave,'secuency':secuency},
                success: function(data) {
                            if(data){
                                $("#titleVideoClips").val(data.title);
                                $("#startTime").val(data.startTime);
                                $('#durationVideo').val(data.duration);
                                $( "input" ).on( "click", function() {
                                    $('#log').css({'background-color':'',opacity:''});
                                    if($('input:checked').val()== '0'){
                                        $('#' + secuency).css({'border-style': 'solid', 'border-color': '#d14d45','text-decoration':'line-through',opacity:'0.5'});
                                    }else{
                                        $('#' + secuency).css({'border-style': '', 'border-color': '','text-decoration':'',opacity:''});
                                    }
                                });
                                if(data.status > '0'){
                                    $('#displayStatusVideo').prop('checked','1');
                                    $('#log').css({'background-color':'#47B268',opacity:'0.75'});      
                                    $("#hiddenStatusVideo").empty();
                                }else if(data.status < '1'){
                                    $('#hiddenStatusVideo').prop('checked','1');
                                    $('#log').css({'background-color':'#d14d45',opacity:'0.75'});
                                    $("#displayStatusVideo").empty();
                                }    
                           } else {

                               }
                    }
            });
    }); 
}
attachevent();
   
</script>

<script type="text/javascript">
/*
|-------------------------------------------------------------------------------
| StartTimeVideoClips
|-------------------------------------------------------------------------------
|
*/    

/*
|-------------------------------------------------------------------------------
| TimeIncrementStar
|-------------------------------------------------------------------------------
|
*/
$(document).ready(function(){
    $('#startTime').attr('readonly', true);
    $('#timeIncrement').on("click",function() {
        if($("#titleVideoClips").val().length > 1){
            startTime = $("#startTime").val();
            // split it at the colons
            var a = startTime.split(':');     
            var seconds = (+a[2]); 
            // seconds. 
            if(seconds < 59){
                next_seconds = seconds + 1;
                if(next_seconds < 10){
                   next_seconds = '0'+ next_seconds;
                }else{next_seconds;}
            }else {next_seconds = '0'+'0';}
            //minutes are worth 60 seconds. var minutes = (+a[1]) * 60;
            var minutes = (+a[1]); 
            next_minutes = minutes;
            if(seconds > 58) {
                if( minutes < 59){
                    next_minutes = minutes + 1;
                }else {next_minutes = '0';}          
            }
            if( next_minutes < 10 ){
               next_minutes = '0'+ next_minutes;
            }else{next_minutes;}  
            //Hours are worth 60 minutes. var hours   = (+a[0]) * 60 * 60;
            var hours  = (+a[0]);
            next_hours = hours;
            if(minutes > 58 && seconds > 58){
                if(hours < 59){
                    next_hours = hours + 1;
                }else{next_hours = '0';}
            }
            if( next_hours < 10){
                next_hours = '0' + next_hours;
            }else{next_hours;}
            var $time = next_hours + ':' + next_minutes + ':' + next_seconds;
            $('#startTime').val($time);
        }
    }); 
/*
|-------------------------------------------------------------------------------
| TimeDecrementStart
|-------------------------------------------------------------------------------
|
*/         
    $('#timeDecrement').on("click",function() {
        if($("#titleVideoClips").val().length > 1){        
                startTime = $("#startTime").val();
                // split it at the colons
                var a = startTime.split(':');     
                var seconds = (+a[2]); 
                // seconds. 
                if(seconds > 0){
                    next_seconds = seconds - 1;
                    if(next_seconds < 10){
                       next_seconds = '0'+ next_seconds;
                    }else{next_seconds;}
                }else {next_seconds = '59';}
                //minutes are worth 60 seconds. var minutes = (+a[1]) * 60;
                var minutes = (+a[1]); 
                next_minutes = minutes;
                if(seconds < 1) {
                    if( minutes > 0){
                        next_minutes = minutes - 1;
                    }else {next_minutes = '59';}          
                }
                if( next_minutes < 10 ){
                   next_minutes = '0'+ next_minutes;
                }else{next_minutes;}  
                //Hours are worth 60 minutes. var hours   = (+a[0]) * 60 * 60;
                var hours  = (+a[0]);
                next_hours = hours;
                if(minutes < 1 && seconds < 1){
                    if(hours > 0){
                        next_hours = hours - 1;
                    }else{next_hours = '0';}
                }
                if( next_hours < 10){
                    next_hours = '0' + next_hours;
                }else{next_hours;}
                var $time = next_hours + ':' + next_minutes + ':' + next_seconds;
                $('#startTime').val($time);
            }
        });      
});  
</script>
    
<script type="text/javascript">
/*
|-------------------------------------------------------------------------------
| DurationVideoClips
|-------------------------------------------------------------------------------
|
*/

$(document).ready(function(){
/*
|-------------------------------------------------------------------------------
| DurationIncrement
|-------------------------------------------------------------------------------
|
*/       
    $('#durationVideo').attr('readonly', true);
    $('#durationIncrement').on("click",function() {
        if($("#titleVideoClips").val().length > 1){
            durationVideo = $("#durationVideo").val();
            // split it at the colons
            var a = durationVideo.split(':'); 
            var milliseconds = (+a[2]); 
            //seconds are worth 60 milliseconds. var seconds = (+a[1]) * 60;
            var seconds = (+a[1]); 
            next_seconds = seconds;
    //        if(milliseconds > 58) {
                if( seconds < 59){
                    next_seconds = seconds + 1;
                }else {next_seconds = '0';}          
    //        }
            if( next_seconds < 10 ){
               next_seconds = '0'+ next_seconds;
            }else{next_seconds;}  
            //minutes are worth 60 seconds. var minutes   = (+a[0]) * 60 * 60;
            var minutes  = (+a[0]);
            next_minutes = minutes;
    //        if(seconds > 58 && milliseconds > 58){
            if(seconds > 58 ){
                if(minutes < 59){
                    next_minutes = minutes + 1;
                }else{next_minutes = '0';}
            }
            if( next_minutes < 10){
                next_minutes = '0' + next_minutes;
            }else{next_minutes;}

           //var $time = next_minutes + ':' + next_seconds + ':' + next_milliseconds;
            var $time = next_minutes + ':' + next_seconds + ':' + '0'+'0';
            $('#durationVideo').val($time);
        }
    }); 
/*
|-------------------------------------------------------------------------------
| DurationDecrement
|-------------------------------------------------------------------------------
|
*/    
    $('#durationDecrement').on("click",function() {
        if($("#titleVideoClips").val().length > 1){
            durationVideo = $("#durationVideo").val();
            // split it at the colons
            var a = durationVideo.split(':');     
            var milliseconds = (+a[2]); 
            //seconds are worth 60 milliseconds. var seconds = (+a[1]) * 60;
            var seconds = (+a[1]); 
            next_seconds = seconds;
            if(milliseconds < 1) {
                if( seconds > 0){
                    next_seconds = seconds - 1;
                }else {next_seconds = '59';}          
            }
            if( next_seconds < 10 ){
               next_seconds = '0'+ next_seconds;
            }else{next_seconds;}  
            //minutes are worth 60 seconds. var minutes   = (+a[0]) * 60 * 60;
            var minutes  = (+a[0]);
            next_minutes = minutes;
            //if(seconds < 1 && milliseconds < 1){
            if(seconds < 1 ){
                if(minutes > 0){
                    next_minutes = minutes - 1;
                }else{next_minutes = '0';}
            }

            if( next_minutes < 10){
                next_minutes = '0' + next_minutes;
            }else{next_minutes;}

            //var $time = next_minutes + ':' + next_seconds + ':' + next_milliseconds;
            var $time = next_minutes + ':' + next_seconds + ':' + '0' + '0';
            $('#durationVideo').val($time);
        }
    }); 
});
</script>    
    
<script type="text/javascript"> 
/*
|-------------------------------------------------------------------------------
| PreviewVideoClips
|-------------------------------------------------------------------------------
|
*/     
$(document).ready(function(){
    $('#previewVideoClips').on("click",function() {
        if($("#titleVideoClips").val().length > 1){
            // get date of calendar
            fecha_input = $("#startDateCal").val(); 
            // get start time
            startTime = $("#startTime").val();
            // get duration time 
            durationVideo = $("#durationVideo").val();        
//---------------------------  Unix Time  ------------------------------------//            
            // concatenate fecha_input and startTime
            var dateString =  fecha_input + ' ' + startTime;
            // split datestrind => (fecha_input , startTime)
            var dateParts = dateString.split(' '); 
            // split timePart => (hh , mm , ss)
            var timeParts = dateParts[1].split(':');
            // split dateParts => (yyyy , mm , dd)   
            var dateParts = dateParts[0].split('-');
            //Tue Sep 17 2013 10:08:00 GMT-0400
            var date = new Date(parseInt(dateParts[0]), parseInt(dateParts[1], 10) - 1, parseInt(dateParts[2]), parseInt(timeParts[0]), parseInt(timeParts[1]), parseInt(timeParts[2])+3,0);
            var timestampreview = date.getTime()/1000;
            timestamp = timestampreview;
    //------------------------ convert to seconds  -------------------------------//              
            //split durationParts => (hh , mm , ss)
            var durationParts = durationVideo.split(':');
            //durationMinutes => convert to seconds
            var durationMinutes = durationParts[0]*60;
            //durationSeconds => convert to seconds
            var durationSeconds = durationParts[1]*1;
            // durationTotal = > sum (durationMinutes and durationSeconds)
            var durationTotal = durationMinutes + durationSeconds;
            // durationTotal -> time
            time = durationTotal;
            // play video with timestampreview -> timestamp and durationTotal -> time
            PlayVideo(timestamp, time);
        }
     });    
});
</script>  

<script>
/*
|-------------------------------------------------------------------------------
| variables Globales
|-------------------------------------------------------------------------------
|
*/        
   
/*
|-------------------------------------------------------------------------------
| saveVideoClips
|-------------------------------------------------------------------------------
|
*/
var startTime = $("#startTime").val(); 
var durationVideo = $("#durationVideo").val();
$(document).ready(function(){ 

    $('#saveEditorAlert').hide();
    $('#saveVideoClips').on('click',function(){
        if($("#titleVideoClips").val().length > 1){
            titleVideoClips = $("#titleVideoClips").val();
            startTime = $("#startTime").val();
            durationVideo = $("#durationVideo").val(); 
            status = $( "input:checked" ).val();
            $('#editorfeeds').load();
            $('#saveEditorAlert').show('slow');
            $('#saveEditorAlert').hide(1000);
            $.ajax({
                    url: 'escaleta/saveVideoClips',
                    type: 'get',
                    data: {'fecha':fecha_input,'clave': clave,'secuency':secuency,'titleVideoClips':titleVideoClips,'startTime':startTime,'durationVideo':durationVideo,'status':status},
                    success: function(data) {
                       if (data) {
                           $.ajax({
                                    url: 'escaleta/displayItemsFeeds',
                                    type: 'get',
                                    data: {'clave': clave,"fecha":fecha_input},
                                    beforeSend: function() {
                                       $("#displayItemsFeeds").html('Buscando ...').css('background-color','#0099ff');
                                    },
                                    error: function() {
                                       $("#displayItemsFeeds").html('<div> Ha surgido un error. </div>');
                                    },
                                    success: function(data) {
                                       if (data) {
                                          $("#displayItemsFeeds").html(data).css('background-color','');
                                       } else {
                                          $("#displayItemsFeeds").html('<div> No hay ning?n . </div>');
                                       }
                                       attachevent();
                                    }
                                    });
                       } else {
                            alert('no hay');
                       }
                    }
                });
           }
    });   
});             
</script> 
    
<script type="text/javascript">
/*
|-------------------------------------------------------------------------------
| RestoreVideoClips
|-------------------------------------------------------------------------------
|
*/    
$(document).ready(function(){    
    $('#restoreVideoClips').on('click',function(){
        if($("#titleVideoClips").val().length > 1){
            $.ajax({
                    url: 'escaleta/restoreVideoClips',
                    type: 'get',
                    data: {'fecha':fecha_input,'clave': clave,'secuency':secuency},
                    beforeSend: function() {
                    },
                    error: function() {
                    },
                    success: function(data) {
                       if (data) {
                           $.ajax({
                                    url: 'escaleta/displayItemsFeeds',
                                    type: 'get',
                                    data: {'clave': clave,"fecha":fecha_input},
                    //                dataType: 'JSON',
                                    beforeSend: function() {
                                       $("#displayItemsFeeds").html('Buscando ...').css('background-color','#0099ff');
                                    },
                                    error: function() {
                                       $("#displayItemsFeeds").html('<div> Ha surgido un error. </div>');
                                    },
                                    success: function(data) {
                                       if (data) {
                                          $("#displayItemsFeeds").html(data).css('background-color','');
                                       } else {
                                          $("#displayItemsFeeds").html('<div> No hay ning?n . </div>');
                                       }
                                       attachevent();
                                    }
                                    });
                        } else {
                            alert('no hay');
                        }
                    }
             }); 
        }

    });   
});        
</script>
    
<script type="text/javascript">
/*
|-------------------------------------------------------------------------------
| datepicker
|-------------------------------------------------------------------------------
|
*/
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
        if((min<0.5)||(min>300)){
            alert("La duración del video debe estar entre 0.5 y 300 minutos");
            document.namingForm.time.focus();
        }
        return true;    
    }

    function ValidarFecha() {
        today=new Date();
        fecha=$('#startDateCal').val();
        if (fecha==''){
            alert("Debes seleccionar la fecha");
            $('#startDateCal').focus();
            return false;
        }else{
            tiempo=$('#startTime').val();
            array_fecha = fecha.split("/")
            array_tiempo = tiempo.split(":")
            //var fechaDate = new Date(array_fecha[2],(array_fecha[0]-1),array_fecha[1],array_tiempo[0],array_tiempo[1],0);
            var fechaDate = new Date(array_fecha[0],(array_fecha[1]-1),array_fecha[2],array_tiempo[0],array_tiempo[1],0);
            if(Date.parse(fechaDate)>today){
             alert('La fecha y hora no pueden ser mayores a la actual');
             $('#startDateCal').focus();
             return false;
            }
        }
        return true;
    }        


//        function WatchSelection() {
//            if( document.namingForm.time.selectedIndex == 0 ){
//                alert("Debes de seleccionar la duracion");
//                return false;
//            }
//            if( document.namingForm.startDateCal.value == '' ){
//                alert("Debes seleccionar la fecha y hora");
//                return false;
//            }
//        }


    var amp;
    var akamaiBaseUrl = "http://tvsawpdvr-lh.akamaihd.net/";
    var liveStreams = [
        [
            "z/stch02wp_1@119660/manifest.f4m?b=300-800",
            "i/stch02wp_1@119660/master.m3u8?b=300-800"
        ],
        [
            "z/stch04wp_1@119661/manifest.f4m?b=300-800",
            "i/stch04wp_1@119661/master.m3u8?b=300-800"
        ],
        [
            "z/stch05wp_1@119663/manifest.f4m?b=150-970",
            "i/stch05wp_1@119663/master.m3u8?b=150-970"
        ],
        [
            "z/stch09wp_1@119664/manifest.f4m?b=300-800",
            "i/stch09wp_1@119664/master.m3u8?b=300-800"
        ]
    ];

    function loadHandler(event) {
        var config_overrides = { autoplay: false }

                    //amp = new AMP("akamai-media-player", config_overrides);

        var config_overrides = 
                    {
                        autoplay: true,

                        media:
                        {
                            title: "Cue Point Caption Sample",
                            poster: '../resources/images/space_alone.jpg'
                        },
                        captioning:
                        {
                            enabled: false
                        },
                        mediaanalytics:
                        {
                            enabled: false
                        }
                    }
        amp = new akamai.amp.AMP("akamai-media-player", config_overrides);            


    }



    function WatchSelection() {

        if( document.namingForm.time.selectedIndex == 0 ){
            alert("Debes de seleccionar la duracion");
            return false;
        }

        if( document.namingForm.startDateCal.value == '' ){
            alert("Debes seleccionar la fecha y hora");
            return false;
        }

        var cal = document.namingForm.startDateCal.value;
        var calTime = document.namingForm.startTime.value;
        var time = parseInt( document.namingForm.time.options[document.namingForm.time.selectedIndex].value );
        var fecha = new Date( parseInt(cal.substring(6,10)), (parseInt(cal.substring(0,3))-1), parseInt(cal.substring(3,5)), parseInt(calTime.substring(0,2)), parseInt(calTime.substring(3,5)), 0);

        var timestamp = fecha.getTime() / 1000;


        var channelIndex = document.namingForm.canal.selectedIndex - 1;

        var hds = akamaiBaseUrl + liveStreams[channelIndex][0] + "&start=" +  (timestamp + dephasingVideo)  + "&end=" +  ( timestamp + time );
        var hls = akamaiBaseUrl + liveStreams[channelIndex][1] + "&start=" +  (timestamp + dephasingVideo)  + "&end=" +  ( timestamp + time );
        //alert(hds);
        var video = {
                            title: "Live",
            source: [
                                {src: hds, type: "video/f4m"},
                                {src: hls, type: "application/x-mpegURL"}
                        ]                                   
                    };
                    amp.setMedia(video);
                    amp.play();
    }


    window.onload = loadHandler;



//-----------------------------------------------------------------------------

    function PlayVideo(timestamp, time){


        var akamaiBaseUrl = "http://tvsawpdvr-lh.akamaihd.net/"

        if(clave==1311 || clave==1321 ||  clave==1713){

            if(dephasingVideo == 0){
                var hds = akamaiBaseUrl + "z/stch02wp_1@119660/manifest.f4m?b=300-950" +  "&start=" + timestamp  + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch02wp_1@119660/master.m3u8?b=300-950"  +  "&start=" + timestamp  + "&end=" +  ( timestamp + time );
//                }else if(clave== ? && fecha_input== ? && id==? ){
            }else{
                var hds = akamaiBaseUrl + "z/stch02wp_1@119660/manifest.f4m?b=300-950" +  "&start=" + (timestamp + dephasingVideo)  + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch02wp_1@119660/master.m3u8?b=300-950"  +  "&start=" + (timestamp + dephasingVideo)  + "&end=" +  ( timestamp + time );
            }


        } else if (clave==1795) {

            if(dephasingVideo == 0){
                var hds = akamaiBaseUrl + "z/stch09wp_1@119664/manifest.f4m?b=300-950" +  "&start=" + timestamp + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch09wp_1@119664/master.m3u8?b=300-950"  +  "&start=" + timestamp + "&end=" +  ( timestamp + time );
            }else{
                var hds = akamaiBaseUrl + "z/stch09wp_1@119664/manifest.f4m?b=300-950" +  "&start=" + (timestamp + dephasingVideo) + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch09wp_1@119664/master.m3u8?b=300-950"  +  "&start=" + (timestamp + dephasingVideo) + "&end=" +  ( timestamp + time );
            }

        }else{

            if(dephasingVideo == 0){
                var hds = akamaiBaseUrl + "z/stch04wp_1@119661/manifest.f4m?b=300-950" +  "&start=" + timestamp + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch04wp_1@119661/master.m3u8?b=300-950"  +  "&start=" + timestamp + "&end=" +  ( timestamp + time );            
            }else{
                var hds = akamaiBaseUrl + "z/stch04wp_1@119661/manifest.f4m?b=300-950" +  "&start=" + (timestamp + dephasingVideo) + "&end=" +  ( timestamp + time );
                var hls = akamaiBaseUrl + "i/stch04wp_1@119661/master.m3u8?b=300-950"  +  "&start=" + (timestamp + dephasingVideo) + "&end=" +  ( timestamp + time );
            }

        }

        var video = {
                            title: "Live",
            source: [
                                {src: hds, type: "video/f4m"},
                                {src: hls, type: "application/x-mpegURL"}
                        ]                                   
                    };
                    amp.setMedia(video);
                    amp.play();       

    }


    $("#feed").slimscroll({
        height: 'auto',
        size: '5px',
        alwaysVisible: true,
        railVisible: true
    });

    $('html, body').css({
       'overflow-x': 'hidden',
//            'overflow': 'hidden',
        'height': 'auto'
    });

    $('.date-picker').datepicker({
        autoclose: true
    });  

</script>
    
    
    
@stop