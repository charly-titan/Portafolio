@extends('vcms.main')
@section('content')

<div class="row">
    <div class="col-md-8">
        <section class="widget">
            <header>
                <div id="video_generate">
                    <i class="glyphicon glyphicon-facetime-video"></i>
                    {{Lang::get('vcms.video_generate')}}
                </div>
                <div class="actions hidden-xs-portrait">
                            <input id="search" type="search" placeholder="{{Lang::get('vcms.enter_title')}}">
                </div>
            </header>
            
            <div class="body" class="col-md-8 col-md-offset-1">
               <div id="table-dynamic"></div>
            </div> 
            
        </section>
    </div>
    
    <div class="col-md-4">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-cogs"></i>
                    {{Lang::get('vcms.video_process')}}
                </h4>
            </header>
            <div id="procesos" class="body">
                @if(count($info_process) > 0)
                    @foreach($info_process as $process)
                        <div id="{{$process['pid']}}" class="well well-sm">
                            <h5 class="no-margin weight-normal">{{$process['video_title']}}</h5>
                            <div class="progress progress-striped active no-margin">
                                <div class="progress-bar progress-bar-{{$process['color']}}" style="width:{{$process['avance']}}%;">{{$process['avance']}}%</div>
                            </div>
                            <footer>
                                <small><i class="fa fa-spinner fa-lg fade fa-spin in"></i> {{$process['step']}}</small>
                            </footer>
                        </div>
                    @endforeach
                @else
                    <div id="msg">
                    <p>{{Lang::get('vcms.process_pend')}}</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>

@stop
@section('scripts')

 @parent
 
  <script src="/light-blue/lib/jquery.dataTables.min.js"></script>

 <!--backbone and friends -->
 <script src="/light-blue/lib/backbone/underscore-min.js"></script>
 <script src="/light-blue/lib/backbone/backbone-min.js"></script>
 <script src="/light-blue/lib/backbone/backbone-pageable.js"></script>
 <script src="/light-blue/lib/backgrid/backgrid.js"></script>
 <script src="/light-blue/lib/backgrid/backgrid-paginator.js"></script>

 <!-- page-specific js -->
 <script src="/light-blue/js/tables-dynamic.js"></script>
 
 <script type="text/javascript">
 $(document).ready(function() {
    jQuery.fn.exists = function(){return this.length>0;}

    var i = setInterval(function() {
        $.ajax({
            url: '/progress',
            type: 'post',
            success: function(data) {
                info_process=data['info_process'];
                if(info_process.length > 0){
                    if ($('#msg').exists()){ $('#msg').remove();}
                    for(process in info_process){
                        var pid='#'+info_process[process]['pid'];
                        if ($(pid).exists()){ // modifica el avance
                            $(pid +" .progress-bar").html(info_process[process]['avance']+"%");
                            $(pid +" .progress-bar").width(info_process[process]['avance']+"%");
                            clase=$(pid +" .progress-bar").attr('class').split(' ');
                            $(pid +" .progress-bar").removeClass(clase[1]);
                            $(pid +" .progress-bar").addClass("progress-bar-"+info_process[process]['color']);
                            $(pid +" footer").html('<small><i class="fa fa-spinner fa-lg fade fa-spin in"></i> '+info_process[process]['step']+'</small>');

                        }else{
                            $('#procesos').append('<div id="'+info_process[process]['pid']+'" class="well well-sm"><h5 class="no-margin weight-normal">'+info_process[process]['video_title']+'</h5><div class="progress progress-striped active no-margin"><div class="progress-bar progress-bar-'+info_process[process]['color']+'" style="width:'+info_process[process]['avance']+'%;">'+info_process[process]['avance']+'%</div></div><footer><small><i class="fa fa-spinner fa-lg fade fa-spin in"></i> '+info_process[process]['step']+'</small></footer></div>');
                        }
                    }

                    $('#procesos div').each(function(idx, el){
                        if ($(el).hasClass('well well-sm')){
                            id=$(el).attr('id');
                            remElem=true;
                            for(process in info_process){
                                if(info_process[process]['pid']==id)
                                    remElem=false;
                            }
                            if (remElem) {
                                $(el).remove();
                            }
                        }
                    });


                }else{
                    $('#procesos').html('<div id="msg"><p>{{Lang::get("vcms.process_pend")}}</p></div>');
                }
            },
            error: function() {
                   $("#procesos").html('<div id="msg"><p>{{Lang::get("vcms.error_label")}}</p></div>');
            }
        }); 
    }, 10000);
 });

 </script>

  
@stop
