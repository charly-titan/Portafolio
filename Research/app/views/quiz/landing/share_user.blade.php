
<?php $page_id="extr-page"; ?>
@extends(Config::get( 'app.main_template' ).'.main')

@section('head')
@stop
@section('aside_left')
@stop

@section('content')


<!-- Widget ID (each widget will need unique ID)-->
			<div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false" data-widget-custombutton="false">
				<!-- widget options:
					usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
					
					data-widget-colorbutton="false"	
					data-widget-editbutton="false"
					data-widget-togglebutton="false"
					data-widget-deletebutton="false"
					data-widget-fullscreenbutton="false"
					data-widget-custombutton="false"
					data-widget-collapsed="true" 
					data-widget-sortable="false"
					
				-->
				<header>
					<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
					<h2>Postea en Facebook</h2>				
					
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
						
						
							 {{Form::open(array('url' => '/landing/share', 'method' => 'post', "novalidate"=>"novalidate","id"=>"order-for", "class"=>"smart-form"))}}
							

							<input name="url" type="hidden" value="{{$page_info["url"]}}"/>							

							<fieldset>
								<section>
									<label class="textarea"> <i class="icon-append fa fa-comment"></i> 										
										<textarea rows="5" name="message" placeholder="Compartelo en Facebook" rows="8" data-bv-field="message"></textarea> <i class="form-control-feedback" data-bv-icon-for="review" style="display: none;"></i>
													<small class="help-block" data-bv-validator="stringLength" data-bv-for="message" data-bv-result="NOT_VALIDATED" style="display: none;">The review must be less than 500 characters long</small>



										
									</label>
								</section>
								<div class="row">
									<section class="col col-12">
									

									<div class="media">
  <div class="media-left media-middle">
    <a href="#" class="thumbnail" style="text-decoration:none; border:none">
      <img class="media-object" src="{{$page_info["img"]}}" class="thumbnail" style="max-height:200px; ">
    </a>
  </div>
  <div class="media-body col-offset-5" style="padding-left:10px;">
    <h4 class="media-heading"><b>{{$page_info["title"]}}</b></h4>
    {{$page_info["description"]}}
  </div>
</div>




									

									</section>
									
								</div>

								
								
							</fieldset>
							<footer>
								<button type="submit" class="btn btn-primary">
									Compartir
								</button>
							</footer>
						{{ Form::close() }}

					</div>
					<!-- end widget content -->
					
				</div>
				<!-- end widget div -->
				
			</div>
			<!-- end widget -->		




		
		

		


@stop



@section('scripts')
    @parent



    <script>
    // DO NOT REMOVE : GLOBAL FUNCTIONS!
		
		$(document).ready(function() {
			
			pageSetUp();

			var $checkoutForm = $('#order-for').validate({
			// Rules for form validation
				rules : {
					message : {
						required : true
					}
				},
		
				// Messages for form validation
				messages : {
					message : {
						required : 'Ingresa un mensaje'
					}
				},
		
				// Do not change code below
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				}
			});
					
			


		
		});
    </script>

@stop


