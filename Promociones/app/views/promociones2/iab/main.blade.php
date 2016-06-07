<!DOCTYPE HTML>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es">
<!--<![endif]-->
    <head>
        @section('metas')
            <meta charset="utf-8">
            <title>IAB | title</title>
            <meta name="description" content="">
            <meta name="author" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        @show
        @section('css')
            {{ HTML::style('/aib/files/bootstrap/css/bootstrap.min.css') }}
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,800" type="text/css">
            {{ HTML::style('/aib/files/js-plugin/animation-framework/animate.css') }}
            {{ HTML::style('/aib/files/js-plugin/magnific-popup/magnific-popup.css') }}
            {{ HTML::style('/aib/files/js-plugin/isotope/css/style.css') }}
            {{ HTML::style('/aib/files/js-plugin/flexslider/flexslider.css') }}
            {{ HTML::style('/aib/files/js-plugin/pageSlide/jquery.pageslide.css') }}
            {{ HTML::style('/aib/files/js-plugin/owl.carousel/owl-carousel/owl.carousel.css') }}
            {{ HTML::style('/aib/files/js-plugin/owl.carousel/owl-carousel/owl.theme.css') }}
            {{ HTML::style('/aib/files/js-plugin/owl.carousel/owl-carousel/owl.transitions.css') }}
            {{ HTML::style('/aib/files/font-icons/custom-icons/css/custom-icons.css') }}
            {{ HTML::style('/aib/files/font-icons/custom-icons/css/custom-icons-ie7.css') }}
            {{ HTML::style('/aib/files/css/layout.css') }}
            {{ HTML::style('/aib/files/css/colors.css') }}
            <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script> <![endif]-->
            <script src="/aib/files/js/modernizr-2.6.1.min.js"></script>
        @show
    </head>

    <body data-spy="scroll" data-target="#scrollTarget" data-offset="150">

        <div id="globalWrapper" class="localscroll">

                
                    @include(Config::get( 'app.main_template' ).'.iab.header')
                        
                        <!-- content -->
                        
                        @yield('content')

                        <!-- End content -->

                    @include(Config::get( 'app.main_template' ).'.iab.footer')
                    
               



        </div>
        @section('scripts')
            {{ HTML::script('/aib/files/js-plugin/respond/respond.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/jquery/jquery.1.10.2.js') }}
            {{ HTML::script('/aib/files/js-plugin/jquery-ui/jquery-ui-1.8.23.custom.min.js') }}
            <!-- third party plugins  -->
            {{ HTML::script('/aib/files/bootstrap/js/bootstrap.js') }}
            {{ HTML::script('/aib/files/js-plugin/easing/jquery.easing.1.3.js') }}
            {{ HTML::script('/aib/files/js-plugin/flexslider/jquery.flexslider-min.js') }}
            {{ HTML::script('/aib/files/js-plugin/isotope/jquery.isotope.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/isotope/jquery.isotope.sloppy-masonry.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/neko-contact-ajax-plugin/js/jquery.form.js') }}
            {{ HTML::script('/aib/files/js-plugin/neko-contact-ajax-plugin/js/jquery.validate.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/magnific-popup/jquery.magnific-popup.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/parallax/js/jquery.scrollTo-1.4.3.1-min.js') }}
            {{ HTML::script('/aib/files/js-plugin/parallax/js/jquery.localscroll-1.2.7-min.js') }}
            {{ HTML::script('/aib/files/js-plugin/parallax/js/jquery.stellar.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/pageSlide/jquery.pageslide-custom.js') }}
            {{ HTML::script('/aib/files/js-plugin/jquery.sharrre-1.3.4/jquery.sharrre-1.3.4.min.js') }}
            {{ HTML::script('/aib/files/js-plugin/owl.carousel/owl-carousel/owl.carousel.min-MODIFIED.js') }}
            <!-- Custom  -->
            {{ HTML::script('/aib/files/js/custom.js') }}
        @show
    </body>
</html>