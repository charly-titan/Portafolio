@section('banner')

<style type="text/css">
	
	.stage-container{
		background-image: url({{isset($info->properties['UrlImgStage'])?$info->properties['UrlImgStage']:'';}});
		@if (isset($info->properties['colorHeader']))
        	border-bottom: 6px solid {{$info->properties['colorHeader']}} !important; 
    	@endif
        @if(isset($info->properties['colorStage']))
            background-color: {{$info->properties['colorStage']}}!important;
        @endif
	}
    
	
</style>

	<article class="banner">
        <div class="stage-promo">
            <div class="stage-container" >
                <article class="stage-img"></article>
            </div>
        </div>
    </article>
    
@show
