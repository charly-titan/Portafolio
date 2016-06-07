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
				<h2>{{Lang::get('comments.mainForm')}}</h2> 
				
			</header>
			<div>
				{{Form::open(array('url'=>'/comments/save','method'=>'POST','name'=>'save'))}}
					<div class="form-group">	
						{{ Form::hidden('comment_guid', $data[0]->comment_guid) }}
						{{ Form::hidden('channel', $channel) }}
						{{ Form::hidden('nota_guid', $data[0]->nota_guid) }}
						{{ Form::textarea('comment', $data[0]->comment_txt)}}
	                	{{$errors->first('descriptionContest','<span class="error">:message</span>')}}
					</div>
					<div class="form-group">
	                	{{Form::button(Lang::get('comments.guardar'),array('class'=>'btn btn-primary','onclick'=>'save.submit()'))}}
	           	 	</div>
           	 	{{Form::close()}}
			</div>
		</div>
	</article>
</div>
@stop






