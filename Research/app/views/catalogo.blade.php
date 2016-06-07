@extends(Config::get( 'app.main_template' ).'.main')


@section('content')

<div class="row">
				
						<!-- NEW COL START -->
						<article class="col-sm-12 col-md-12 col-lg-6">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>Creación de Catalogo </h2>
				
								</header>
				
								<!-- widget div-->
								<div>
				
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
				
									</div>
									<!-- end widget edit box -->
				
									<!-- widget content -->
									<div class="widget-body no-padding">
				
										<form class="smart-form">
											<header>
												Opciones
											</header>
				
											<fieldset>
											
												<section>
													<label class="label">Texto</label>
													<label class="input">
														<input type="text">
													</label>
												</section>
												<section>
													<label class="label">Value</label>
													<label class="input">
														<input type="text">
													</label>
												</section>

												<section>
													<label class="label">Nombre Catalogo</label>
													<label class="select">
														<select>
															<option value="0"></option>
															<option value="1">Alexandra</option>
															<option value="2">Alice</option>
															<option value="3">Anastasia</option>
															<option value="4">Avelina</option>
															<option value="otro">Otro</option>
														</select> <i></i> </label>
												</section>

											</fieldset>
										
				
											<footer>
												<button type="submit" class="btn btn-primary">
													Submit
												</button>
												<button type="button" class="btn btn-default" onclick="window.history.back();">
													Back
												</button>
											</footer>
										</form>
				
									</div>
									<!-- end widget content -->
				
								</div>
								<!-- end widget div -->
				
							</div>
							<!-- end widget -->
				
						</article>
						<!-- END COL -->
	</div>					
@stop
