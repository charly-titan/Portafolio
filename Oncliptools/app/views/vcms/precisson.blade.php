@extends('vcms.main')
@section('content')
<div class="row">
    <div class="col-md-8">
        <section class="widget">
            <header>
                <h4>Video<small> Preview</small></h4>
            </header>
            <div class="body no-margin" id="content">
                <div id="visits-chart" class="" style="height:300px;">
                    <div class="loader animated fadeIn handle">
                        <span class="spinner">
                            <i class="fa fa-spinner fa-spin"></i>
                        </span>
                    </div>
                    <div class="sample-player col-md-8 col-md-offset-2" style="">
                        <div id="akamai-media-player"></div>
                    </div>
                </div>
            </div>
        </section>

        <!--section class="widget">
            <div class="key pull-right">Generando Video</div>
                <div class="stat">
                    <div class="info">0%</div>
                    <div class="progress progress-small">
                        <div class="progress-bar progress-bar-danger" style="width: 0%;"></div>
                    </div>
                </div>
        </section-->
    </div>
    <div class="col-md-4">
		<section class="widget widget-tabs">
            <header>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#stats" data-toggle="tab">{{Lang::get('vcms.video_info')}}</a>
                    </li>
                </ul>
            </header>
            <div class="body tab-content">
                <div id="stats" class="tab-pane active clearfix">
                    <div id="video_info" class="well well-sm">
                        
                        @if($onlyMaster == "")
                            <div class="widget widget-overview">
                                                            <h5>{{Lang::get('vcms.video_qual')}}:</h5>
                                    <div class="row margin-bottom text-align-center">
                                                                    <a href="javascript:void(null);" onclick="playRendition('http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-150.mp4')"><span class="badge badge-default btn-default">150</span></a>
                                                                    <a href="javascript:void(null);" onclick="playRendition('http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-235.mp4')"><span class="badge badge-success btn-success">235</span></a> 
                                                                    <a href="javascript:void(null);" onclick="playRendition('http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-480.mp4')"><span class="badge badge-info btn-info">480</span></a>
                                                                    <a href="javascript:void(null);" onclick="playRendition('http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-600.mp4')"><span class="badge badge-primary btn-primary">600</span></a> 
                                                                    <a href="javascript:void(null);" onclick="playRendition('http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-970.mp4')"><span class="badge badge-danger btn-danger">970<span></span></a>
                                                            </div>

                            </div>
                        @endif
                        
                        <div class="row margin-bottom text-align-center">
                        @if($onlyMaster == "")    
                            <div class="col-md-8 col-md-offset-2">
                                    <a href="http://mediapm.edgesuite.net/edgeflash/public/zeri/debug/Main.html?url=http://m4vhds.tvolucion.com/z/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-,150,235,480,600,970,.mp4.csmil/manifest.f4m" onclick="" target="_blank"><span class="badge badge-default btn-block btn-default">{{Lang::get('vcms.video_show')}}</span></a>
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                    <a href="http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>.jpg" target="_blank"><span class="badge badge-default btn-block btn-default">Thumbnail</span></a>
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                    <a href="http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-STILL.jpg" target="_blank"><span class="badge badge-default btn-block btn-default">Still</span></a>
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                    <a href="http://m4vhds.tvolucion.com/i/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-,150,235,480,600,970,.mp4.csmil/master.m3u8" target="_blank"><span class="badge badge-default btn-block btn-default">M3U8</span></a>
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                    <a href="http://m4vhds.tvolucion.com/z/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-,150,235,480,600,970,.mp4.csmil/manifest.f4m" target="_blank"><span class="badge badge-default btn-block btn-default">HDS</span></a>
                            </div>
                            @if ($master == "") 
                            <div class="col-md-8 col-md-offset-2">
                                <a href="/generateMaster/<?=$vid?>"><span class="badge badge-default btn-block btn-default">{{Lang::get('vcms.generate_master')}}</span></a>
                            </div>
                            @endif  
                            
                        @endif
                        
                        @if(($master == "on")||($onlyMaster == "on"))
                            <div class="col-md-8 col-md-offset-2">
                                <a href="/download/master/<?=$vid?>"><span class="badge badge-default btn-block btn-default">{{Lang::get('vcms.video_master')}}</span></a>
                            </div>
                        @endif

                        </div>
                    </div>
                    @if ($user = Sentry::getUser())
                        @if ($user->hasAnyAccess(array('users.create','roles.create')))
                            <div class="widget widget-overview">
                                <div class="row margin-bottom text-align-center">
                                    <div class="col-md-8 col-md-offset-2">
                                    <a href="/logs/<?=$vid?>"><span class="badge badge-default btn-block btn-default">Procesar Logs</span></a>
                                    <a href="/videosProperties/<?=$vid?>"><span class="badge badge-default btn-block btn-default">Propiedades del Video</span></a>
                                    <a href="/regenerateVideo/<?=$vid?>"><span class="badge badge-warning btn-block btn-danger">Procesar nuevamente el video</span></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </section>
    </div>
</div>

@stop

@section('scripts')
 @parent

 
    {{ HTML::script('/amp/amp.min.js?/amp/samples.xml') }}
    <script type="text/javascript">
        var amp;
        function loadHandler(event) {
            var config_overrides = {
                autoplay: true,
                media:{
                    title: "Titulo",
                    //temporalType: "live",
                    poster: 'http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-STILL.jpg',
                    source:[
                            {src: "http://apps.tvolucion.com/m4v/tst/<?=$program?>/<?=$path?>/<?=$Clip?>-480.mp4", type: "video/mp4"}
                          //{src: "/vcms/media/<?=$program?>/<?=$path?>/<?=$Clip?>-600.mp4", type: "video/mp4"}
                          //{src: "/media/<?=$program?>/<?=$path?>/<?=$Clip?>-480.mp4", type: "video/mp4"}
                    ]
                }
            }
            amp = new AMP("akamai-media-player", config_overrides);
        }
        function playRendition( videoUrl ) {
            var video = {
                        title: "Harlem Shake!!!!!!",
                        source: [{src: videoUrl, type: "video/mp4"}]
            };
            amp.setMedia(video);
            amp.play();
        }

        loadHandler(event);
    </script>
    <script type="text/javascript" src="http://comentarios.esmas.com/js/comunidades.js"></script>
@stop

