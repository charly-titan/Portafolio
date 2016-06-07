@section('scripts')
	<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<!--script src="js/plugin/pace/pace.min.js"></script-->

	    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
	    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script> if (!window.jQuery) { document.write('<script src="/js/libs/jquery-2.1.1.min.js"><\/script>');} </script>

	    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script> if (!window.jQuery.ui) { document.write('<script src="/js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="/js/app.googleacode.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events 		
		<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

		<!-- BOOTSTRAP JS -->		
		<script src="/js/bootstrap/bootstrap.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="/js/plugin/jquery-validate/jquery.validate.min.js"></script>
		
		<!-- JQUERY MASKED INPUT -->
		<script src="/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="/js/smartwidgets/jarvis.widget.min.js"></script>

		<script src="/js/plugin/ckeditor/ckeditor.js"></script>
		
		<!--[if IE 8]>
			
			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>
			
		<![endif]-->
		

		{{ HTML::script("js/angular.min.js") }}
		{{ HTML::script("js/angular-resource.js") }}

		<!-- MAIN APP JS FILE -->
		<script src="/js/app.min.js"></script>
		<script >
		
		$("#smart-styles > li > a")
		   .on('click', function() {
		        var $this = $(this);
		        // var $logo = $("#logo img");
		        try{
		        	$.root_.removeClassPrefix('smart-style').addClass($this.attr("id"));
		        $('html').removeClassPrefix('smart-style').addClass($this.attr("id"));   
		        }catch(err){

		        }
		        
		        // $logo.attr('src', $this.data("skinlogo"));
		        // $("#smart-styles > a #skin-checked")
		        //     .remove();
		        // $this.prepend("<i class='fa fa-check fa-fw' id='skin-checked'></i>");
		    });
		
		</script>
@show