@section('scripts')
	
	{{ HTML::script('js/promociones/tvsyload.js') }}
	{{ HTML::script('js/promociones/jquery-2.1.1.min.js') }}
	{{ HTML::script('js/promociones/tvsa.loadimg.js') }}
	{{ HTML::script('http://i2.esmas.com/finalpage/rga-2014/js/headertelevisaConfigurable.js',array('async'=>'async','charset'=>'utf-8')) }}
	{{ HTML::script('http://i2.esmas.com/hf/footer/footertelevisaCQconfig.min.js') }}
	{{ HTML::script('js/promociones/head.load.min.js') }}
	{{ HTML::script('js/promociones/finalpage-libs.js',array('id'=>'libs')) }}
@show