@section('aside_right')

    <aside class="right-container">
        <div class="btns-share">
            @if (isset($info) & $info->contest_type=="foto")
                <h2>¡Comparte esta experiencia con tus amigos !</h2>    
            @else
                <h2>¡Comparte esta promoción con tus amigos!</h2>
            @endif
            <div class="share-container">
                <div id="widgetSocialShare2"></div>
            </div>
        </div>
        
        @if (isset($info) & $info->properties["advertisingOption"]==1)
        <div class="banners-desktop-1">
            <span>Publicidad</span>
            <div class="banner1" id="ban01_televisa">

    	        <script type="text/javascript" defer="defer" >
    	           googletag.display('ban01_televisa');
    	                        
    			</script>
            </div>
        </div>
        @endif

    </aside>
@show