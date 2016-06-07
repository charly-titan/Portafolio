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
					@foreach ($code as $title)
					<h1 class="page-title txt-color-blueDark">
						<i class="glyphicon glyphicon-picture"></i> 
						{{$title['code']}}
					</h1>
					@endforeach
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading ">
								<i class="glyphicon glyphicon-picture"></i> Fotos - Selecciona las fotos para mover
							</div>
							@if (count($key) >= 1)
							<div class="panel-body">
								@if (count($errors) > 0)
								<div class="alert alert-danger" role="alert">
									<a class="close" data-dismiss="alert" href="#">×</a>									
									<ul>
										@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
								@endif
								@if(Session::has('message'))
								<div class="alert alert-success" role="alert">
									<a class="close" data-dismiss="alert" href="#">×</a>									
									<ul>
										<li>{{ Session::get('message') }}</li>
									</ul>
								</div>
								@endif
								<div class="cc-selector">
									{{ Form::open(array('url' => 'photos/reasign')) }}
									<input type="hidden" value="{{$title['code']}}" name="old_code">
									@foreach ($key as $photo)
									<div class="col-xs-6 col-md-3" >
										<div class="thumbnail-container">
											<div class="thumbnail-body">
												<input type="checkbox" id="{{$photo['flickr_id']}}" value="{{$photo['flickr_id']}}" name="photo[]">
												<label class="drinkcard-cc" for="{{$photo['flickr_id']}}"> 
													<img class="img-responsive thumbnail-img" data-src="{{$photo['s3_url']}}" alt="100%x180" src="{{$photo['s3_url']}}" data-holder-rendered="true">
												</label>
											</div>
											<div class="smart-form thumbnail-footer" >
												<label class="toggle">
													<input type="radio" id="{{$photo['flickr_id']}}" value="{{$photo['id']}}" name="radio" onClick="myFunc(this.id);"/>
													<i data-swchon-text="Si" data-swchoff-text="No"></i>Soy QR
												</label>
											</div>
										</div>
									</div>
									@endforeach	
									<div class="col-xs-12 col-md-12"></div>
									<div class="col-xs-1 col-md-1">
										<div class="input-group">
											<label class="input-group-addon redondoizq ">Codigo</label>

											<div class="input-group-btn">
												<select name="urlShort" class="form-control input-group-addon" id="combobox">
													<option value="">Selecciona</option>
													@foreach ($select as $code)
													<option value="{{$code->code}}">{{$code->code}}</option>
													@endforeach
												</select>
												<button type="submit" class="btn btn-default" id="move">Mover</button>
											</div><!-- /btn-group -->

										</div><!-- /input-group -->
									</div><!-- /.col-lg-1 -->
									{{ Form::close() }}
								</div>
							</div>
							@else
							<div class="panel-body">
								<h1><span class="glyphicon glyphicon-fire" aria-hidden="true"></span>No existen imagenes para este QR</h1>
							</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			@endsection
			@section("scripts")
			@parent
			<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
			<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
			<script>//autocompletar en barra de busqueda
				(function( $ ) {
					$.widget( "custom.combobox", {
						_create: function() {
							this.wrapper = $( "<span>" )
							.insertAfter( this.element );
							this.element.hide();
							this._createAutocomplete();
							this._createShowAllButton();
						},

						_createAutocomplete: function() {
							var selected = this.element.children( ":selected" ),
							value = selected.val() ? selected.text() : "";

							this.input = $( "<input class='form-control'> " )
							.appendTo( this.wrapper )
							.val( value )
							.attr( "title", "" )
							.autocomplete({
								delay: 0,
								minLength: 0,
								source: $.proxy( this, "_source" )
							})
							.tooltip({
								tooltipClass: "ui-state-highlight"
							});
							this._on( this.input, {
								autocompleteselect: function( event, ui ) {
									ui.item.option.selected = true;
									this._trigger( "select", event, {
										item: ui.item.option
									});
								},
								autocompletechange: "_removeIfInvalid"
							});
						},

						_createShowAllButton: function() {
							var input = this.input,
							wasOpen = false;
							$( "<a>" )
							.attr( "tabIndex", -1 )
							.tooltip()
							.appendTo( this.wrapper )
							.button({
								icons: {
									primary: "ui-icon-triangle-1-s"
								},
								text: false
							})
							.removeClass( "ui-corner-all" )
							.addClass( "custom-combobox-toggle ui-corner-right" )
							.mousedown(function() {
								wasOpen = input.autocomplete( "widget" ).is( ":visible" );
							})

							.click(function() {
								input.focus();
						// Close if already visible
						if ( wasOpen ) {
							return;
						}
						// Pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
					});
						},

						_source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( this.element.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text,
										value: text,
										option: this
									};
								}) );
						},

						_removeIfInvalid: function( event, ui ) {
			// Selected an item, nothing to do
			if ( ui.item ) {
				return;
			}
				// Search for a match (case-insensitive)
				var value = this.input.val(),
				valueLowerCase = value.toLowerCase(),
				valid = false;
				this.element.children( "option" ).each(function() {
					if ( $( this ).text().toLowerCase() === valueLowerCase ) {
						this.selected = valid = true;
						return false;
					}
				});
				// Found a match, nothing to do
				if ( valid ) {
					return;
				}
				// Remove invalid value
				this.input
				.val( "" )
				.attr( "title", value + " - sin coincidencia" )
				.tooltip( "open" );
				this.element.val( "" );
				this._delay(function() {
					this.input.tooltip( "close" ).attr( "title", "" );
				}, 2500 );
				this.input.autocomplete( "instance" ).term = "";
			},

			_destroy: function() {
				this.wrapper.remove();
				this.element.show();
			}
		});
})( jQuery );

$(function() {

	$( "#combobox" ).combobox();

	$( "#toggle" ).click(function() {

		$( "#combobox" ).toggle();

	});

});

</script>



<script type='text/javascript'>//selecciona checbox con radio_button



	function myFunc(id){

		document.getElementById(id).checked = true;

	}

</script>



<script type='text/javascript'>//Loading page

	$(function() {

		var loading = function() {

			var over = '<div id="overlay">' +

			'<img id="loading" src="/img/load_ing.gif">' +

			'</div>';

			$(over).appendTo('#wrapper');

		};

		$('#move').click(loading);

	});

</script>
@endsection