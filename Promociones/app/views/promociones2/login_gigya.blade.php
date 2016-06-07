@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

    <article class="left-container">
        <div class="iu-texto">
            <div class="terminos-condiciones">
                <h2 class="title">{{isset($info->properties['titleMechanical'])?$info->properties['titleMechanical']:''}}</h2>
                
                <div>{{isset($contentText->textMechanical)?$contentText->textMechanical:''}}</div>
            </div>
	        <div class="registro">
	            <h2 class="title">{{Lang::get('promociones.registroTitle')}}</h2>
	            <h4 class="resumen_login">
	            <b>{{Lang::get('promociones.registroLogin')}}</b>&nbsp;{{Lang::get('promociones.registroLogin2')}}</h4>
	            <div class="vs-sec-ganaste hidden-smartphone hidden-tablet">
		            <b id ="login_gigya"></b>
		            <div id ="login_gigya_social"></div>
		        </div>

		        <div class="vs-sec-ganaste hidden-desktop">
		            <b id ="login_gigya"></b>
		            <div id ="login_gigya_social"></div>
		        </div>
	        </div>
	    </div>
	</article>

	  
@stop

@section('scripts')
	@parent


<script>

    var social_engage_external_config ={
        callbacks       : {
            "islogged"      : "isLoged", 
            "isnotlogged"   : "isNotLoged" 
        },
        modal           :   false,  
        templates       : {
            usernotlogged   :   '',
            
            userlogged      :   '<div class="alert alert-info" role="alert" style="text-align: center;">'+
                                '<img src="../img/loading.gif">'+
                                '</div>'
                                
        }   
                                
    };

    function isNotLoged(){
    	social_engage.displayLoginOptions();
        
    }

    function isLoged(uid){
    	$.ajax({
                type: 'POST',
                url: '/{{(isset($info->properties['channel'])?$info->properties['channel']:'')}}/{{$info->short_name}}/valida-user',
                data: {uid: uid},
                success: function (data) {
                	console.log('datos: '+data);
                	if (data==1) {
                		window.location.reload(false); 	
                	}
                	else{
                		if (data=="Unauthorized user") {
                			social_engage.destroySesion();
                			alert("Loguéate de nuevo por favor");
                			social_engage.displayLoginOptions();
                		} else{
                			social_engage.destroySesion();
                			alert("Ocurrio un error");
                		};
                	};
                   
                },
                error: function(errors){
                	alert("Ocurrio un error");
                    console.log("error: "+errors);
                }
        });
    }

</script>
<script src="https://s3-us-west-1.amazonaws.com/communities-dev/social_engage/social_promo.js"></script>

@stop



