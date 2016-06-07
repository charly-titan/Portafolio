<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>{{isset($info->properties['titleContest'])?$info->properties['titleContest']:''}}</title>

       	@include(Config::get( 'app.main_template' ).'.main.metas')

    </head>

    <body class="c5-vsx js-off" id="main">

        <div class="mm-page ">
    
           @include(Config::get( 'app.main_template' ).'.main.scripts_googleTagService')

                <div class="c5-wapper">
                    @include(Config::get( 'app.main_template' ).'.ninos.header')

                        <section class="wrapper-container">
                                @include(Config::get( 'app.main_template' ).'.ninos.publicidad1')

                                @include(Config::get( 'app.main_template' ).'.ninos.titulo')

                                <div class="container">
                            
                                        @yield('content')

                                </div>

                                {{--@include(Config::get( 'app.main_template' ).'.ninos.publicidad2')--}}

                        </section>
                        <section class="box-c5-footer">
                                
                                @include(Config::get( 'app.main_template' ).'.ninos.inside')

                        </section>

                       @include(Config::get( 'app.main_template' ).'.ninos.footer')
                    
                </div>

                @include(Config::get( 'app.main_template' ).'.main.scripts')


        </div>
    </body>
</html>