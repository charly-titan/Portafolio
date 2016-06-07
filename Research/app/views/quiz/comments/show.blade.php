@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('content')

<style>
	td.btnAlign{text-align: center;}
	.comm-date{width:90px;}
	/*.comm-autor{width:100px;}
	.comm-email{width:100px;}*/
	/*.comm-txt{width:250px;}*/
	.comm-edit{width:50px;}
</style>

<div class="row">
	<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="jarviswidget " id="wid-id-0" data-widget-editbutton="false">

			<header>
				<span class="widget-icon"> <i class="fa fa-table"></i> </span>
				<h2>Comentarios</h2> 
			<div>
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
					<thead>			                
						<tr>
							<th data-class="expand"><i class="fa fa-fw fa-calendar fa-user text-muted hidden-md hidden-sm hidden-xs"></i> Fecha</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw  txt-color-blue hidden-md hidden-sm hidden-xs"></i> Usuario</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw  txt-color-blue hidden-md hidden-sm hidden-xs"></i> Correo</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw txt-color-blue hidden-md hidden-sm hidden-xs"></i> Comentario</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw txt-color-blue hidden-md hidden-sm hidden-xs"></i> Borrar</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw txt-color-blue hidden-md hidden-sm hidden-xs"></i> Editar</th>
							<th data-hide="phone,tablet"><i class="fa fa-fw txt-color-blue hidden-md hidden-sm hidden-xs"></i> Contestar</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($data as  $d)
						<tr>
							<td class="comm-date">{{$d->creation_date}}</td>
							<td class="comm-autor">{{$d->autor}}</td>
							<td class="comm-email">{{$d->email}}</td>
							<td class="comm-txt">{{$d->comment_txt}}</td>
							<td class="comm-edit"><a href="/comments/delate?nota_guid={{$d->nota_guid}}&channel={{$channel}}&comment_guid={{$d->comment_guid}}"><button class="btn btn-danger">Borrar</button></a></td>
							<td class="comm-edit"><a href="/comments/detail?nota_guid={{$d->nota_guid}}&channel={{$channel}}&comment_guid={{$d->comment_guid}}"><button class="btn btn-primary">Editar</button></a></td>
							<td class="comm-edit"><a href="/comments/answer?nota_guid={{$d->nota_guid}}&channel={{$channel}}&comment_guid={{$d->comment_guid}}&comment_id={{$d->comment_id}}"><button class="btn btn-success">Contestar</button></a></td>
						</tr>
							@foreach ($sons as $key2=> $d2)
								@if($key2===$d->comment_id)
									@foreach ($d2 as $d3)
										<tr >
											<td class="comm-date"><i class="fa fa-lg fa-fw fa-level-up"></i></td>
											<td class="comm-autor">{{$d3['autor']}}</td>
											<td class="comm-email">{{$d3['email']}}</td>
											<td class="comm-txt">{{$d3['comment_txt']}}</td>
											<td class="comm-edit"><a href="/comments/delate?nota_guid={{$d3['nota_guid']}}&channel={{$channel}}&comment_guid={{$d3['comment_guid']}}"><button class="btn btn-danger">Borrar</button></a></td>
											<td class="comm-edit"><a href="/comments/detail?nota_guid={{$d3['nota_guid']}}&channel={{$channel}}&comment_guid={{$d3['comment_guid']}}"><button class="btn btn-primary">Editar</button></a></td>
											<td class="comm-edit"></td>
										</tr>
									@endforeach
								@endif
							@endforeach
						@endforeach	
										
					</tbody>
				</table>
				<table class="table table-striped table-bordered table-hover" width="10%">
					<tr align="center">
						
						<td>
						@if ($page > 0) 
							<a href="/comments/showcomments?page={{$page-1}}&nota_guid={{$nota_guid}}&channel={{$channel}}">Anterior</a>
						@endif
						</td>
						<td >
							<a href="/comments/showcomments?page={{$page+1}}&nota_guid={{$nota_guid}}&channel={{$channel}}">Siguiente</a>
						</td>
					</tr>	
				</table>
			</div>
		</div>
	</article>
</div>
@stop