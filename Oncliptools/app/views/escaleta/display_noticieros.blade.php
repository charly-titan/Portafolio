
@if (isset($FeedsProgram) && $FeedsProgram == NULL)
    <ul style="">
	    <li>
	    	<div class="icon pull-left">
            <i class="fa fa-exclamation"></i>
        </div>
        <!-- -------- Information Web -----  -->
        <div class="feed-item-body">
          
                El programa no se encuentra disponible
        </div>

	    </li>
	</ul>
    
@else
    @foreach ($FeedsProgram as $video) 

        <?php 
            $tmp = explode(":",$video->duration);
            $duracion = (intval($tmp[0]*60)+intval($tmp[1]));
			
        ?>

        	<ul style="">
			    <li>
			    	
			    	<div class="icon pull-left">
			    		<a onclick="PlayVideo(1,{{(intval(strtotime(substr($video->startDate,0, 4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate, -2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style=" cursor:pointer;">
					    	@if ($video->img)
					    	<?php $video->img=json_decode($video->img); ?>
		                        <img src="{{$video->img->thumb}}" class="img-circle" alt="">
		                    @else
		                        <i class="fa fa-arrow-down"></i>
		                    @endif 
	                	</a>
                	</div>
                	 <div class="feed-item-body">
                <div class="text" id="{{$video->secuency}}">
                     <a  onclick = "PlayVideo(1,{{(intval(strtotime(substr($video->startDate,0,4)."-".substr($video->startDate, 5, 2)."-".substr($video->startDate,-2).' '.$video->startTime))-7200+4+Config::get('vcms.time_difference'))+$extra_time}},{{$duracion}});" style=" cursor:pointer;">{{ $video->title}}</a>
                </div>
                
            </div>
            <div class="clearfix"></div>
			    </li>
			</ul>

      
    @endforeach
        
@endif



