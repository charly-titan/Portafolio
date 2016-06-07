@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('content')

<style>
	td.btnAlign{text-align: center;}
</style>

<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2>Responder</h2> 
				
			</header>
			<div>
				{{Form::open(array('url'=>'/comments/saveanswer','method'=>'POST','name'=>'save'))}}
					<div class="form-group">	
						{{ Form::hidden('channel', $channel) }}
						{{ Form::hidden('nota_guid', $data[0]->nota_guid) }}
						{{ Form::hidden('comment_id', $data[0]->comment_id) }}
						{{ $data[0]->comment_txt}}
	                </div>
	                <div class="form-group">
						Contestar como:
					</div>
	                <div class="form-group">
						{{ Form::select('autor', $admins)}}	
					</div>
					<div class="form-group">
						Respuesta:
					</div>
					<div class="form-group">
						{{ Form::textarea('comment')}}	
					</div>
					<div class="form-group">
	                	{{Form::button(Lang::get('comments.contestar'),array('class'=>'btn btn-primary','onclick'=>'save.submit()'))}}
	           	 	</div>
           	 	{{Form::close()}}
			</div>
			
			
		</div>
	</article>
</div>
@stop






