<!DOCTYPE HTML>
<html lang="es">
    <head>
        <title>{{(isset($info->properties['titleContest']))?$info->properties['titleContest']:''}}</title>

       	@include(Config::get( 'app.main_template' ).'.main.metas')

    </head>

    <style>
    .stage-container{
        background:url({{isset($info->properties['UrlImgStage'])?$info->properties['UrlImgStage']:''}})
    }

    </style>
    <body class=" js-off" id="main">

        <div class="mm-page">
    
           @include(Config::get( 'app.main_template' ).'.main.scripts_googleTagService')

                <div class="c5-wapper">
                    @include(Config::get( 'app.main_template' ).'.main.header')

                        <section class="wrapper-container"><section>
                            
                                @include(Config::get( 'app.main_template' ).'.main.banner')

                                    <div class="container">
                                        
                                        @yield('content')

                                        
                                        @include(Config::get( 'app.main_template' ).'.main.aside_right')
                                        
                                    </div>

                        </section>

                       @include(Config::get( 'app.main_template' ).'.main.footer')
                    
                </div>

                @include(Config::get( 'app.main_template' ).'.main.scripts')


        </div>
    </body>
</html>