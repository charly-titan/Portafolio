
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
					@if ($option==2)
					<h1 class="page-header"><i class="fa fa-video-camera"></i> Módulo de Aprobaci&oacute;n de Videos</h1>			
					@else
					<h1 class="page-header"><i class="fa fa-video-camera"></i> Módulo de Revisi&oacute;n de Videos Aprobados</h1>			
					@endif
				</div>
				
				@if ($videos && count($videos)>0)
                <div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading ">
								@if ($option==2)
								<i class="glyphicon glyphicon-check"></i> Selecciona al participante para <u><b>aprobar</b></u> su video
								<span class="fa-stack fa-lg"> 
								  <span class="fa fa-video-camera fa-stack-2x"></span> 
								  <span class="fa fa-check fa-stack-2x text-success"></span> 
								</span>
								@else
								<i class="glyphicon glyphicon-check"></i> Selecciona los videos que deseas <u><b>revertir la aprobaci&oacute;n</b></u> 
								<span class="fa-stack fa-lg"> 
								  <span class="fa fa-video-camera fa-stack-1x"></span> 
								  <span class="fa fa-ban fa-stack-2x text-danger"></span> 
								</span>
								@endif
							</div>
							<div class="panel-body">
								<div class="cc-selector">
									{{ Form::open(array('url' => array('videos/authorize', $id_contest,$option))) }}
									@foreach ($videos as $value)
									<div class="col-xs-12 col-md-12">
										<div class="col-xs-2 col-md-3">
											<!-- <div class="thumbnail-container">
												<div class="thumbnail-body">
													<img class="img-responsive thumbnail-img" data-src="{{$value->photo_url}}" src="{{$value->photo_url}}">
												</div>
												<div class="thumbnail-footer" >
													<h6 class="text-center">{{Crypt::decrypt($value->first_name)}} {{Crypt::decrypt($value->last_name)}}</h6>
												</div>
											</div> -->
											<div class="thumbnail">
												<input type="checkbox" id="{{$value->id}}" value="{{$value->id}}" name="video[]">
												<label class="drinkcard-cc" for="{{$value->id}}">
													<img class="img-responsive" data-src="{{$value->photo_url}}" onerror="this.src='/img/image-no.jpg'" alt="100%x180" src="{{$value->photo_url}}" data-holder-rendered="true" style="height: 180px; display: block;">
												</label>
												<h6 class="text-center">{{Crypt::decrypt($value->first_name)}} {{Crypt::decrypt($value->last_name)}}</h6>
											</div>
										</div>
									<div class="col-xs-6 col-md-3">
										<div class="margin-top-10">
										<iframe class="youtube-player" type="text/html" width="100%" height="210" src="http://www.youtube.com/embed/{{$value->youtube_id}}" frameborder="0"></iframe>
										</div>	
									</div>
									</div>
									@endforeach	

									<div class="col-xs-12 col-md-12">
										<div class="form-inline">
											<div class="input-group">
												@if ($option==2)
												<button type="submit" class="btn btn-success ">
													Aprobar videos seleccionados
												</button>
												@else
												<button type="submit" class="btn btn-warning ">
													Revertir aprobaci&oacute;n de videos seleccionados
												</button>
												@endif
												
											</div>
											@if (Session::has('error'))
												<span class="alert-danger">{{Session::get('error')}}</span>
											@endif
										</div>
									</div>
									
									{{ Form::close() }}
								</div>



							</div>
						</div>				
					</div>
				</div>
				@else
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							@if ($option==2)
							<div class="panel-heading">
								<i class="glyphicon glyphicon-check"></i> Videos
							</div>
							<div class="panel-body">
								<h1>No existen videos para aprobar</h1>
							</div>
							@else
							<div class="panel-heading">
								<i class="glyphicon glyphicon-check"></i> Videos
							</div>
							<div class="panel-body">
								<h1>No existen videos aprobadas</h1>
							</div>
							@endif
						</div>	
					</div>		
				</div>
				@endif

			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
	(function( $ ) {
		$.widget( "custom.combobox", {
			_create: function() {
				this.wrapper = $( "<span>" )
				.addClass( "custom-combobox" )
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
				.addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
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

@endsection




