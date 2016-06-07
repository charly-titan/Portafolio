@extends(Config::get( 'app.main_template' ).'.main')


@section('css')
    @parent
    <style>
        .error{color: red;}
        .jarviswidget-ctrls,.widget-toolbar{display: none;}
        .bootstrapWizard li {width: 11%;}
        .select2-hidden-accessible{display: none;}
        .dropzone{min-height: 200px;}
        .dropzone .dz-preview{font-size: 12px;} 
        img {max-width: 100%;max-height: 100%;}
        @media all and (max-width: 1000px){
            img{
            width:800px;
            height: 250px;
            }
        }
        .imgDropzone{height: 220px;}

    </style>
@stop

@section('content')


<section id="widget-grid" class="">
    <div class="row">
        <article class=" col-lg-10">
            <div class="jarviswidget jarviswidget-color-darken"  >

                <header>
                    <span class="widget-icon"> <i class="fa fa-check"></i> </span>
                    <h2>{{Lang::get('contest.titleContest')}}</h2>
                </header>
                
                                    <!-- widget content -->
                    <div class="widget-body">
                
                        <div class="row">

                        <input type="hidden" value='{{$numStep or null}}' id='numStep'>

                                <div id="bootstrap-wizard-1" class="col-sm-12">
                                    <div class="form-bootstrapWizard">
                                        <ul class="bootstrapWizard form-wizard" id='optStep'>

                                            <li data-target="#step1" class="step" id='step1'>
                                                <a href="/contest/contestdetails" > <span class="step">1</span> <span class="title">{{Lang::get('contest.infoContest')}}</span></a>
                                            </li>
                                            @if(Session::get('SesionID'))
                                                            
                                                <li data-target="#step2" class='step' id='step2'>
                                                    <a href="/contest/contestdate"> <span class="step">2</span> <span class="title">{{Lang::get('contest.dateContest')}}</span> </a>
                                                </li>
                                                                
                                                <li data-target="#step3" class='step' id='step3'> 
                                                    <a href="/contest/contestownerinf"> <span class="step">3</span> <span class="title">{{Lang::get('contest.OwnersInformation')}}</span> </a>
                                                </li>
                                                                
                                                <li data-target="#step4" class='step' id='step4'>
                                                    <a href="/contest/tos"> <span class="step">4</span> <span class="title">{{Lang::get('contest.tos')}}</span> </a>
                                                </li>
                                                <li data-target="#step5" class='step' id='step5'>
                                                    <a href="/contest/networkservice"> <span class="step">5</span> <span class="title">{{Lang::get('contest.socialNetworks')}}</span> </a>
                                                </li>
                                                <li data-target="#step6" class='step' id='step6'>
                                                    <a href="/contest/sales"> <span class="step">6</span> <span class="title">{{Lang::get('contest.sales')}}</span> </a>
                                                </li>
                                                <li data-target="#step7" class='step' id='step7'>
                                                    <a href="/contest/metric"> <span class="step">7</span> <span class="title">{{Lang::get('contest.metric')}}</span> </a>
                                                </li>
                                                <li data-target="#step8" class='step' id='step8'>
                                                    <a href="/contest/text"> <span class="step">8</span> <span class="title">{{Lang::get('contest.text')}}</span> </a>
                                                </li>
                                                <li data-target="#step9" class='step' id='step9'>
                                                    <a href="/question/quiz"> <span class="step">9</span> <span class="title">{{Lang::get('contest.typeContest')}}</span> </a>
                                                </li>

                                            @else

                                                <li data-target="#step2" class='step' id='step2'>
                                                    <a href="#"> <span class="step">2</span> <span class="title">{{Lang::get('contest.dateContest')}}</span> </a>
                                                </li>
                                                                
                                                <li data-target="#step3" class='step' id='step3'> 
                                                    <a href="#"> <span class="step">3</span> <span class="title">{{Lang::get('contest.OwnersInformation')}}</span> </a>
                                                </li>
                                                                
                                                <li data-target="#step4" class='step' id='step4'>
                                                    <a href="#"> <span class="step">4</span> <span class="title">{{Lang::get('contest.tos')}}</span> </a>
                                                </li>
                                                <li data-target="#step5" class='step' id='step5'>
                                                    <a href="#"> <span class="step">5</span> <span class="title">{{Lang::get('contest.socialNetworks')}}</span> </a>
                                                </li>
                                                <li data-target="#step56" class='step' id='step6'>
                                                    <a href="#"> <span class="step">6</span> <span class="title">{{Lang::get('contest.sales')}}</span> </a>
                                                </li>
                                                <li data-target="#step7" class='step' id='step7'>
                                                    <a href="#"> <span class="step">7</span> <span class="title">{{Lang::get('contest.metric')}}</span> </a>
                                                </li>
                                                <li data-target="#step8" class='step' id='step8'>
                                                    <a href="#"> <span class="step">8</span> <span class="title">{{Lang::get('contest.text')}}</span> </a>
                                                </li>
                                                <li data-target="#step9" class='step' id='step9'>
                                                    <a href="#"> <span class="step">9</span> <span class="title">{{Lang::get('contest.typeContest')}}</span> </a>
                                                </li>
                                                
                                            @endif
                                        </ul>

                                        <div class="clearfix"></div>
                                    </div>

                                    <div class="tab-content">
                                                        
                                        @yield('contentTabs')
                                                    
                                    </div>
                                </div>
                        </div>
                    </div>
            </div>
        </article>
    </div>
</section>

@stop


@section('scripts')
    @parent



    {{ HTML::script("js/plugin/summernote/summernote.min.js") }}
    {{ HTML::script("js/plugin/select2/select2.min.js") }}
    {{ HTML::script("js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js") }}
    {{ HTML::script("js/plugin/dropzone/dropzone.min.js") }}
    {{ HTML::script("js/plugin/markdown/markdown.min.js") }}
    {{ HTML::script("js/plugin/markdown/to-markdown.min.js") }}
    {{ HTML::script("js/plugin/markdown/bootstrap-markdown.min.js") }}
    {{ HTML::script('js/contest/contest.js') }}
    {{ HTML::script('js/plugin/colorpicker/bootstrap-colorpicker.min.js') }}
    <script>
    $('#rgbpicker-1').colorpicker();
    $('#rgbpicker-2').colorpicker();
    $('#rgbpicker-3').colorpicker();
    $('#rgbpicker-4').colorpicker();
    $('#rgbpicker-5').colorpicker();
    </script>
@stop