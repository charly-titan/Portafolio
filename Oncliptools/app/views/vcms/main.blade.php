<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link href="/light-blue/css/application.css" rel="stylesheet">
    <link href="/css/range.css" rel="stylesheet" type="text/css">
    <link href="/amp/amp-styles.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="img/favicon.png">
    <link href="/css/responsive_design.css" rel="stylesheet" type="text/css">
    <link href="/css/dropzone.css" rel="stylesheet">
    <script src="/js/dropzone.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    @yield('style')
</head>
<body class="background-gray">
	@include('vcms.logo')
  	@include('vcms.sidebar')

      	<div class="wrap">
            @include('vcms.header')
        		<div class="content container">
        	  		@yield('content')
          		</div>
      	</div>

  	 @section('scripts')
            <script src="/light-blue/lib/jquery/jquery-2.0.3.min.js"> </script>


<!-- jquery and friends -->
<!-- 
<script src="/light-blue/lib/jquery/jquery-2.0.3.min.js"> </script>
<script src="/light-blue/lib/jquery-pjax/jquery.pjax.js"></script>
-->



<!-- jquery plugins -->
<!-- 
<script src="/light-blue/lib/jquery-maskedinput/jquery.maskedinput.js"></script>
<script src="/light-blue/lib/parsley/parsley.js"> </script>
<script src="/light-blue/lib/icheck.js/jquery.icheck.js"></script>
<script src="/light-blue/lib/select2.js"></script>
<script src="/light-blue/lib/jquery.autogrow-textarea.js"></script>
-->
<script src="/light-blue/lib/select2.js"></script>
<script src="/light-blue/lib/bootstrap/collapse.js"></script>


<!--backbone and friends -->
<!-- 
<script src="/light-blue/lib/backbone/underscore-min.js"></script>
-->


<!-- bootstrap default plugins -->

<script src="/light-blue/lib/bootstrap/transition.js"></script>
<!-- <script src="/light-blue/lib/bootstrap/collapse.js"></script>
<script src="/light-blue/lib/bootstrap/alert.js"></script>
<script src="/light-blue/lib/bootstrap/tooltip.js"></script>
<script src="/light-blue/lib/bootstrap/popover.js"></script>
<script src="/light-blue/lib/bootstrap/button.js"></script>
<script src="/light-blue/lib/bootstrap/dropdown.js"></script>
<script src="/light-blue/lib/bootstrap/modal.js"></script>
-->

<script src="/light-blue/lib/bootstrap/button.js"></script>

<!-- bootstrap custom plugins -->
<!-- 
<script src="/light-blue/lib/bootstrap-datepicker.js"></script>
<script src="/light-blue/lib/bootstrap-select/bootstrap-select.js"></script>
<script src="/light-blue/lib/wysihtml5/wysihtml5-0.3.0_rc2.js"></script>
<script src="/light-blue/lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
<script src="/light-blue/lib/bootstrap-switch.js"></script>
<script src="/light-blue/lib/bootstrap-colorpicker.js"></script>
<script src="/light-blue/lib/bootstrap-slider-3.0.1/bootstrap-slider.min.js"></script>
-->

<script src="/light-blue/lib/bootstrap-select/bootstrap-select.js"></script>

<!-- basic application js-->
<!--
<script src="/light-blue/js/app.js"></script>
 <script src="/light-blue/js/settings.js"></script>
-->


<!-- page specific -->
<!-- 
<script src="/light-blue/js/forms-elemets.js"></script>
-->

<script type="text/javascript">


    //class-switch for button-groups
    $(".btn-group > .btn[data-toggle-class]").click(function(){
        var $this = $(this),
            isRadio = $this.find('input').is('[type=radio]'),
            $parent = $this.parent();

        if (isRadio){
            $parent.children(".btn[data-toggle-class]").removeClass(function(){
                return $(this).data("toggle-class")
            }).addClass(function(){
                return $(this).data("toggle-passive-class")
            });
            $this.removeClass($(this).data("toggle-passive-class")).addClass($this.data("toggle-class"));
        } else {
            $this.toggleClass($(this).data("toggle-passive-class")).toggleClass($this.data("toggle-class"));
        }
    });

    var problemFormUser = $("#formUserPermission").val();

    if( problemFormUser != 'formUserPermission'){

        $(".chzn-select").each(function(){
            $(this).select2($(this).data());
        });  

    }


          


//$('.selectpicker').selectpicker();

// $('#language-combo').select2.on('change', function() {
//     //do_something(evt, params);
//     $("#language-combo").select2("val");


// $("#language-combo").select2($("#language-combo").data());
$("#language-combo").bind("change", function () { try{document.location="/locale/"+$("#language-combo").select2("val");}catch(err){}

try{document.location="/locale/"+$("#language-combo").val();}catch(err){}
 });

// change

// $(this).select2.on("change", function() { $("#e15_val").html($("#e15").val());});

</script>
     @show
</body>
</html>