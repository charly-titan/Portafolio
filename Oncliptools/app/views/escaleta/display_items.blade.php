<style>
   .feedBorder{
          -webkit-transition:background-color 0.3s ease-out;
          border-top-color:rgba(21, 21, 21, 0.247059);
          border-top-style:solid;
          border-top-width:2px;
          box-sizing:content-box;
          cursor:pointer;
          height:100%;
          width: 92%;
          margin:3px -10px;
          padding:12px;
          transition:background-color 0.2s ease-out; 
          text-align: justify;
   }

   .feedBorder:hover{
          -webkit-transition:background-color 0.3s ease-out;
          border-top-color:rgba(51, 51, 51, 0.247059);
          border-top-style:solid;
          border-top-width:2px;
          box-sizing:content-box;
          cursor:pointer;
          height:100%;
          width: 92%;
          margin:3px -10px;
          padding:12px;
          transition:background-color 0.2s ease-out; 
          text-align: justify;
          background-color: rgba(256, 256, 256, 0.15);
   }           

</style>
        
@if (isset($FeedsProgram) && $FeedsProgram == NULL)

    <section class="feed-item">
        <!--
        |-------------------------------------------------------------------------------
        | Imagen of Feed
        |-------------------------------------------------------------------------------
        |
        -->          
        <div class="icon pull-left">
            <i class="fa fa-exclamation"></i>
        </div>
        <!--
        |-------------------------------------------------------------------------------
        | Information Web
        |-------------------------------------------------------------------------------
        |
        -->         
        <div class="feed-item-body">
            <div class="text">
                {{Lang::get('escaleta.programNot')}}
            </div>
            <div class="time pull-left">
                {{Lang::get('escaleta.tryAnother')}}
            </div>
        </div>
    </section>

    <input type="hidden" name="time_add" id="time_add" value="{{$extra_time}}">
    
@else

    @foreach ($FeedsProgram as $video) 

        <?php 
            $tmp = explode(":",$video->duration);
            $duracion = (intval($tmp[0]*60)+intval($tmp[1]));
            
            $j = $video -> img;
            $json = json_decode($j,true);
            //echo $json['thumb'];
        ?>
    
       @if ( $video->status > '0') 
       
            <section id="{{$video->secuency}}" class="feed-item feedBorder">
                <!--
                |-------------------------------------------------------------------------------
                | Imagen of Feed
                |-------------------------------------------------------------------------------
                |
                -->
                <div class="icon pull-left">
                        <a onclick="PlayVideo({{(intval(strtotime(substr($video->startDate,0, 4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate, -2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style="color:#fff; cursor:pointer;">
                        @if ($video->img)
                            <img src="{{$json['thumb']}}" class="img-circle" alt="" style="position: relative; left: 0px; width: 38px; height: 38px;">
                        @else
                            <i class="fa fa-arrow-down"></i>
                        @endif                                                                                  
                    </a>
                </div>
                <!--
                |-------------------------------------------------------------------------------
                | Information Web
                |-------------------------------------------------------------------------------
                |
                -->
                <div class="feed-item-body">
                    <div class="text">
                         <a  onclick = "PlayVideo({{(intval(strtotime(substr($video->startDate,0,4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate,-2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style="color:#fff; cursor:pointer;">{{ $video->title}}</a>
                    </div>
                    <div class="time pull-left">
                        {{$video->startDate}} {{$video->startTime}} {{$video->duration}}
                    </div>
                </div>
            </section>         
       
       
       @else
            <section id="{{$video->secuency}}" class="feed-item" style="border-style:solid; border-color:#d14d45; text-decoration:line-through; opacity:0.5">
                <!--
                |-------------------------------------------------------------------------------
                | Imagen of Feed
                |-------------------------------------------------------------------------------
                |
                -->                
                <div class="icon pull-left">
                        <a onclick="PlayVideo({{(intval(strtotime(substr($video->startDate,0, 4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate, -2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style="color:#fff; cursor:pointer;">
                        @if ($video->img)
                            <img src="{{$json['thumb']}}" class="img-circle" alt="">
                        @else
                            <i class="fa fa-arrow-down"></i>
                        @endif                                                                                  
                    </a>
                </div>
                <!--
                |-------------------------------------------------------------------------------
                | Information Web
                |-------------------------------------------------------------------------------
                |
                -->                
                <div class="feed-item-body">
                    <div class="text">
                         <a  onclick = "PlayVideo({{(intval(strtotime(substr($video->startDate,0,4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate,-2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style="color:#fff; cursor:pointer;">{{ $video->title}}</a>
                    </div>
                    <div class="time pull-left">
                        {{$video->startDate}} {{$video->startTime}} {{$video->duration}}
                    </div>
                </div>
            </section>         
       
       @endif
      
    @endforeach
    
        <input type="hidden" name="time_add" id="time_add" value="{{$extra_time}}">
        
@endif

