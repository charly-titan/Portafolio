@section('inside')

    <div>

        <!-- BEGIN: TWITTER -->
        <article class="box-twitter hidden-smartphone">
            <h3>En el twitter ...</h3>
            <div class="timeline">
                @if ($info->short_name=='amqlichita')
                    <a class="twitter-timeline" href="https://twitter.com/AMQLichita" data-chrome="nofooter" data-widget-id="601794307935178752" data-theme="light" width="600" height="330" data-link-color="#CFCFCF">Tweets por el @AMQLichita.</a>
                @else
                    <a class="twitter-timeline" href="https://twitter.com/hashtag/Televisa" data-chrome="nofooter" data-widget-id="591712030266040320" data-theme="light" width="600" height="330" data-link-color="#CFCFCF">Tweets sobre #Televisa</a>
                @endif    
            </div>
        </article>
        <!-- END: TWITTER -->
                        
                        
        <!-- BEGIN: TOP 5 -->                    
        <article class="box-top5" >
            <div class="top5">
                <h2 class="titulo-top">Top 5</h2>
                <span> ({{$point->name}})</span>
                <ul class="top">
                    {{$top1=0;}}
                    @foreach ($UsersTop as $user)
                        {{$top1++}}
                        @if ($top1==1) 
                            <li class="top-list selected">
                        @else
                            <li class="top-list">
                        @endif
                            @if ($user["photo_url"]!="")
                                <p class="profile"><img src="{{$user['photo_url']}}" alt="" height="45" width="45"><span class="box-border"></span></p>
                            @else
                                @if ($user["social_network"]=="Google") 
                                    <p class="profile"><img src="https://secure.gravatar.com/avatar/{{md5(strtolower(trim($user['email'])))}}" alt="" height="45" width="45"><span class="box-border"></span></p>
                                @elseif ($user["social_network"]=="Facebook")
                                    <p class="profile"><img src="https://avatars.io/facebook/{{$user['social_id']}}" alt="" height="45" width="45"><span class="box-border"></span></p>
                                @elseif ($user["social_network"]=="Twitter")
                                    <p class="profile"><img src="https://avatars.io/twitter/{{$user['social_id']}}" alt="" height="45" width="45"><span class="box-border"></span></p>
                                @endif
                            @endif
                            <p class="profile-text">{{$user["name"]}}</p>
                            <p class="profile-points"><!--i class="c5-popcorn"></i-->
                                {{$noimg=true; $i=0;}}
                                @foreach ($category as $value)
                                    @if (($user["points"]>=$value->range_ini) &&($user["points"]<=$value->range_fin)) 
                                        <i><img src="{{$value->img}}" height="35" width="35"></i>
                                        {{$noimg=false;}}
                                    @endif
                                    {{$i++;}}
                                @endforeach
                                @if ($noimg)
                                    <i><img src="{{$category[$i-1]->img}}" height="35" width="35"></i>
                                @endif 
                            <b>{{$user["points"]}}</b>
                            </p>
                        </li>
                    @endforeach    
                </ul>
            </div>
        </article>
        <!-- END: TOP 5 -->
                        
                        
        <!-- BEGIN: BOX BANNER -->
        <article class="desk_box_banner hidden-tablet" >
            <p> PUBLICIDAD </p>
                <div class="tui-adds-cubo">
                    <div id='ban02' style="margin:auto;">
                        <script type='text/javascript'>
                            googletag.cmd.push(function() {
                                googletag.display('ban01_televisa');
                            });
                        </script>
                    </div>
                </div>
        </article>
        <!-- END: BOX BANNER -->

@show