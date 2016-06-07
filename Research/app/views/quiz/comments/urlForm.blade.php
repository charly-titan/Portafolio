@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('content')

<style>
	td.btnAlign{text-align: center;}
	.form-group input{width:700px;}
</style>

<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2>{{Lang::get('comments.mainForm')}}</h2> 
				@if ($user = Sentry::getUser())
				@endif
			</header>
			<div>
				{{Form::open(array('url'=>'/comments/showcomments','method'=>'POST','name'=>'save'))}}
					<div class="form-group" style="width:800px;" >	
						{{Form::label('descriptionContest',Lang::get('comments.url'))}} de Nota
	                	{{Form::text('url')}}
	                	{{$errors->first('descriptionContest','<span class="error">:message</span>')}}

					</div>
					<div class="form-group">
	                	{{Form::button(Lang::get('comments.consultar'),array('class'=>'btn btn-primary','onclick'=>'save.submit()'))}}	
	           	 	</div>
           	 	{{Form::close()}}

			</div>
		
		</div>
	</article>
</div>
@stop






