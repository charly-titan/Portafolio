@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
	<link type="text/css" rel="stylesheet" href="/css/flickr.css">
@endsection
@section('content')
<div id="wrapper">
	<div id="page-wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h1 class="page-title txt-color-blueDark">
						<i class="glyphicon glyphicon-qrcode"></i>
						Explora las Galerias
					</h1>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading ">
								<i class="glyphicon glyphicon-qrcode"></i> Gallery's
							</div>
							<div class="panel-body">
								@foreach ($photos as $photo)
								<div class="col-xs-6 col-md-3">
									<div class="thumbnail-container">
										<div class="thumbnail-body">
											<a href="{{ url('photos/gallery', [$photo['keyword']]) }}" >
												<img class="img-responsive thumbnail-img" data-src="{{$photo['s3_url']}}"
												src="{{$photo['s3_url']}}">
											</a>
										</div>
										<div class="thumbnail-footer" >

										<h6 class="text-center">{{$photo['code']}}</h6>
									</div>
									</div>
								</div>
								@endforeach

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
