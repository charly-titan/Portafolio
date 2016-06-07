
@extends(Config::get( 'app.main_template' ).'.main')

@section('content')
	<section id="widget-grid" class="">

					<div class="row">
				
						<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false">
								<header>
									<span class="widget-icon"> <i class="fa fa-table"></i> </span>
									<h2>Generador de URLs con campa&ntilde;as de m&eacute;tricas </h2>
				
								</header>

								<div>
									<div class="widget-body no-padding">
									

										<form class="url-generator__form">
					<div class="panel panel-default">
						<div class="panel-body">
							<h2 class="url-generator__title--small"><i class="icon fa fa-link"></i> Url Destino</h2>
							<p class="url-generator__inputhelp"> Página destino de la URL</p>
							<select name="urlDestino" id="urlDestino" class="form-control" id="cuenta" required>
								<option value="http://www.televisa.com" selected>http://www.televisa.com</option>
								<option value="http://espectaculos.televisa.com">http://espectaculos.televisa.com</option>
								<option value="http://estilodevida.televisa.com">http://estilodevida.televisa.com</option>
							</select>
							<h2 class="url-generator__title--small"><i class="icon fa fa-external-link"></i> Url Destino vía NoteFly</h2>
							<p class="url-generator__inputhelp"> Nota que se compartirá por NoteFly</p>
							<input type="url" name="urlNotefly" id="urlNotefly" class="form-control" placeholder="Escribe la URL destino vía NoteFly" required />
							<h2 class="url-generator__title--small"><i class="icon fa fa-list"></i> Red social en donde se va a compartir el link</h2>
							<p class="url-generator__inputhelp"> Red social</p>
							<select name="red_social" class="form-control" id="redsocial" required>
								<option value="facebook" data-utm-source='facebook' selected>Facebook</option>
								<option value="twitter" data-utm-source='twitter' >Twitter</option>
								<option value="googleplus" data-utm-source='googleplus' >Google Plus</option>
								<option value="instagram" data-utm-source='instagram' >Instagram</option>
							</select>
							<h2 class="url-generator__title--small"><i class="icon fa fa-list"></i> Cuenta de la red social seleccionada</h2>
							<p class="url-generator__inputhelp"> Cuenta que comparte el link</p>
							<select name="cuenta" class="form-control" id="cuenta" required>
								<option value="televisapuntocom" selected data-red="facebook">televisapuntocom</option>
								<option value="TelevisaEspectaculosMexico" data-red="facebook">TelevisaEspectaculosMexico</option>
								<option value="televisaestilodevida" data-red="facebook">televisaestilodevida</option>
								<option value="EsmasFarandula" data-red="twitter" disabled>EsmasFarandula</option>
								<option value="TelevisaDotCom" data-red="twitter" disabled>TelevisaDotCom</option>
								<option value="TelevisaEstilo" data-red="twitter" disabled>TelevisaEstilo</option>
								<option value="TelevisaPuntoCom" data-red="googleplus" disabled>TelevisaPuntoCom</option>
								<option value="televisa_espectaculos" data-red="instagram" disabled>televisa_espectaculos</option>
								<option value="Televisa_Estilo_de_Vida" data-red="instagram" disabled>Televisa_Estilo_de_Vida</option>
							</select>
						</div>
					</div>
					<button  class="btn btn-primary url-generator__submit" type="button" value="Generar URLs"><i class="icon-prepend fa fa-gears"></i>Generar URLs</button>
				</form>
				<div class="url-generator__result"></div>


										
									</div>
								</div>
							</div>
						</article>
					</div>
				</section>

			
@stop

@section('css')
@parent
<!-- page related CSS -->
		<link rel="stylesheet" type="text/css" media="screen" href="/sharedlink/css/url-generator.css">
@stop

@section('scripts')
 @parent

    {{ HTML::script("/sharedlink/js/additional-methods.min.js") }}
    {{ HTML::script('/sharedlink/js/url-generator.js') }}

    
@stop