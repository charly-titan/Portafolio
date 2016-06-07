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
                    @include(Config::get( 'app.main_template' ).'.versus.header')

                        <section class="wrapper-container">
                                @include(Config::get( 'app.main_template' ).'.versus.publicidad1')

                                @include(Config::get( 'app.main_template' ).'.versus.titulo')

                                <div class="container">
                            
                                        @yield('content')

                                </div>

                                {{--@include(Config::get( 'app.main_template' ).'.versus.publicidad2')--}}

                        </section>
                        <section class="box-c5-footer">
                                
                                {{--@include(Config::get( 'app.main_template' ).'.versus.inside')--}}

                        </section>

                       @include(Config::get( 'app.main_template' ).'.main.footer')
                    
                </div>

                @include(Config::get( 'app.main_template' ).'.main.scripts')


        </div>
    </body>
</html>