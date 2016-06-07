@extends(Config::get( 'app.main_template' ).'.main')


@section('content')
@if ($user = Sentry::getUser())
<style>
	.styleInputText{
		border: none;
		background-color: #fbfbfb;
	}
	#nameSettingsService{
		border: none;
		background-color: #d6dde7;
		padding-left: 20px;
		text-align: right;
	}
	#dvTypeService,#listPerfiles,#listHashtags,#listList,#dvLists,#dvSettingsService,#saveSettingsService,#check-status-service,#dvNumTweets,.ddTypeService,#listInstagram{
		display: none;
	}
	.dd3-content{
		font-size: 12px;
	}
	.tweetOpacity{
		opacity: .2;
	}
	img{
		height: 40px;
	}

</style>
					<!-- START ROW -->
					<div class="row">
						<!-- NEW COL START -->
						<article class="col-sm-12 col-md-12 col-lg-8">
				
							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>{{Lang::get('servicesTwitter.twitter_settings_service')}}</h2>
				
								</header>
				
								<!-- widget div-->
								<div>
									<!-- widget content -->
									<div class="widget-body form-horizontal">
											<fieldset>			

												<div class="form-group">
													<section>
														<label class="control-label col-md-2" >{{Lang::get('servicesTwitter.name_service')}}</label>
														<div class="col-md-7">
															<div class="row">
																<div class="col-sm-12">
																	<div class="input-group">
																		@if ($user->hasAccess('twitter.update'))
																			{{Form::text('', isset($service['name_service']) ? $service['name_service']:'',['class'=>'form-control','id'=>'serviceName'])}}
																			<div class="input-group-btn">
																				<button class="btn btn-success" type="button" id='btnServiceName'>
																					<i class="fa fa-check fa-fw"></i>
																				</button>
																			</div>
																		@else
																			{{Form::text('', isset($service['name_service']) ? $service['name_service']:'',['class'=>'form-control','id'=>'serviceName','readonly'])}}
																			<div class="input-group-btn">
																			<button class="btn btn-success" type="button" id='btnServiceName' disabled="disabled">
																					<i class="fa fa-check fa-fw"></i>
																				</button>
																			</div>
																		@endif
																		

																	</div>
																</div>
																
															</div>
														</div>
													</section>
													<section id='check-status-service'>
														@if ($user->hasAccess('twitter.create') or $user->hasAccess('twitter.update'))
															<div class="col-md-3">	
																<div class="input-group checkbox">
																	
																	<label>
																		@if(isset($service) && $service['status-service'] == 1)
																			
																			{{Form::checkbox('status_service', '', true,['id'=>'status_service','class'=>"checkbox style-0"])}}
																			
																		@else
																			
																			{{Form::checkbox('status_service', '', false,['id'=>'status_service','class'=>"checkbox style-0"])}}
																		@endif

																		<span id='status-type-service'>Activar</span>
																	</label>
																</div>
																<p class="note"><strong>Nota:</strong> Activar o desactivar servicio</p>
															</div>
														@endif
													</section>
													
												</div>

												<div class="form-group" id="dvNumTweets">
													
													<section>
													<label class="control-label col-md-2">{{Lang::get('servicesTwitter.activate_date')}}:</label>
														<div class="col-md-4">
															<div class="input-group">
																
																@if(isset($service['active_date']))
																	{{Form::text('ServiceSettings[from]',$service['active_date'],['class'=>'form-control','id'=>"active_date",'name'=>'ServiceSettings[from]'])}}
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																@else
																	<input class="form-control" id="active_date" type="text" placeholder="From" name='ServiceSettings[from]' >
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																@endif

															</div>
														</div>
													</section>
													<section>
														<label class="control-label col-md-2">{{Lang::get('servicesTwitter.inactive_date')}}:</label>
														<div class="col-md-4">	
															<div class="input-group">
																@if(isset($service['inactive_date']))
																	{{Form::text('ServiceSettings[to]',$service['inactive_date'],['class'=>'form-control','id'=>"inactive_date",'name'=>'ServiceSettings[to]'])}}
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																@else
																	<input class="form-control" id="inactive_date" type="text" placeholder="Select a date" name='ServiceSettings[to]'>
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																@endif
																
															</div>
														</div>
													</section>
												</div>

												<div class="form-group" id="dvNumTweets">
												<label class="control-label col-md-2">{{Lang::get('servicesTwitter.num_tweets')}}</label>
													<div class="col-md-10" id='numTweets'>

													</div>
												</div>


												<div class="form-group" id="dvTypeService">
													@if ($user->hasAccess('twitter.update') or $user->hasAccess('twitter.create'))
														<label class="control-label col-md-2">{{Lang::get('servicesTwitter.type_service')}}</label>
														<div class="col-md-10">
															{{Form::select('services_hub', Config::get('services_hub'), '',array('class'=>'form-control','id'=>'typeService'))}}
															<p class="note"><strong>Note:</strong> Selecciona un tipo de servicio a configurar</p>
														</div>


														
													@endif
												</div>

												<div class="form-group" id='inputTypeService'></div>
												
											</fieldset>
									</div>
									<!-- end widget content -->
								</div>
								<!-- end widget div -->
							</div>
							<!-- end widget -->
							@if(isset($tweets))

								<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

									<header style="padding: .2em;">
										<span class="widget-icon"> <i class="fa fa-twitter"></i> </span>
										<span> Tweets 
											@if ($user->hasAccess('twitter.refresh'))
											
											<span>
												<button class='btn btn-primary btn-xs pull-right' id='UpdConfigSocial' data-service="{{$service['id']}}">{{Lang::get('servicesTwitter.btnUpdate')}}</button>
											</span>
											@endif
											<span>
												<button class='btn btn-xs bg-color-blueDark txt-color-white pull-right' id='generateJson' data-service="{{$service['id']}}">{{Lang::get('servicesTwitter.btnUpdateJson')}}</button>
											</span>
											
										</span>
										
									</header>
					
									<!-- widget div-->
									<div>
										<!-- widget content -->
										<div class="widget-body no-padding chat-body  profile-message">
					
											<table id="dt_basic" class="table table-hover" width="100%">
												<thead>			                
													<tr>
														<th></th>
														<th></th>
													</tr>
												</thead>
												<tbody id='tableTweets'>

													
													@foreach($tweets as $tweet)
															@foreach($tweet as $tweetField)																
	
																@for ($i = 0; $i < count($tweetField); $i++)
																	<tr>
																		<td>
																			<li class="message {{($tweetField[$i]['status_tweet']==1)?'':'tweetOpacity'}}">
																				{{isset($tweetField[$i]['photo_profile']) ? HTML::image($tweetField[$i]['photo_profile'], 'sunny') : (isset($tweetField[$i]['photo']) ? HTML::image($tweetField[$i]['photo'], 'sunny'):'')}}
																				{{--isset($tweetField[$i]['photo']) ? HTML::image($tweetField[$i]['photo'], 'sunny') : '' --}}
																				<span class="message-text"> <a href="javascript:void(0);" class="username">{{isset($tweetField[$i]['name'])?$tweetField[$i]['name']:''}}</a>  {{isset($tweetField[$i]['text'])?$tweetField[$i]['text']:'.'}}</span>
																			</li>
																		</td>
																		<td>
																			@if ($user->hasAccess('twitter.hide'))
																			@if($tweetField[$i]['status_tweet'] == 0)
																				{{ Form::button('Mostrar', array('class' => 'btn btn-success btn-xs pull-right idTweet','id'=>$tweetField[$i]['id_item'],'data-idService'=>$service['id'])) }}
																			@else
																				{{ Form::button('Ocultar', array('class' => 'btn btn-info btn-xs pull-right idTweet','id'=>$tweetField[$i]['id_item'],'data-idService'=>$service['id'])) }}
																			@endif
																			@endif
																		</td>
																	</tr>
																@endfor


															@endforeach
													@endforeach	


												</tbody>
											</table>

										</div>
									</div>
								</div>
							@endif

						</article>
						<!-- END COL -->
				
						<!-- NEW COL START -->
						<article class="col-sm-12 col-md-12 col-lg-4">
							
				
							<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-custombutton="false">

							

								<header>
									<span class="widget-icon"> <i class="fa fa-edit"></i> </span>
									<h2>{{Lang::get('servicesTwitter.service_set')}}</h2>
				
								</header>

								<div>
				
									<article class="col-sm-12 sortable-grid ui-sortable">
				
										<div class="widget-body">
											@if(isset($service))
												@if ($user->hasAccess('twitter.update'))
												{{Form::open(array('url'=>'/social-hub/update-service/'.$service['id'],'method'=>'POST','class'=>'smart-form','name'=>'save'))}}
												@else
												{{Form::open(array('url'=>'#'.$service['id'],'method'=>'POST','class'=>'smart-form','name'=>'save'))}}
												@endif
											@else
												@if ($user->hasAccess('twitter.create'))
												{{Form::open(array('url'=>'/social-hub/save-service','method'=>'POST','class'=>'smart-form','name'=>'save'))}}
												@else
												{{Form::open(array('url'=>'#','method'=>'POST','class'=>'smart-form','name'=>'save'))}}
												@endif
											@endif
											
												
											
													<div class="row">

														<div class="alert alert-info fade in">
															<strong>{{Lang::get('servicesTwitter.name_service')}}: </strong> <input type="text" id='nameSettingsService' class='styleInputText' readonly="true" name='ServiceSettings[name_service]'>
														</div>

														<div class="col-sm-6 col-lg-12">

															<div class="dd" id="nestable3">

																{{Form::hidden('ServiceSettings[status-service]', isset($service['num_tweets']) ? $service['status-service']:0,['id'=>'val_status_service'])}}
																
																{{Form::hidden('ServiceSettings[num_tweets]', isset($service['num_tweets']) ? $service['num_tweets']:0,['id'=>'val_num_tweets'])}}

																{{Form::hidden('ServiceSettings[dateFrom]', isset($service['active_date']) ? $service['active_date']:'',['id'=>'dateFrom'])}}
																{{Form::hidden('ServiceSettings[dateTo]', isset($service['inactive_date']) ? $service['inactive_date']:'',['id'=>'dateTo'])}}


																<ol class="dd-list" id='listPerfiles'>
																	
																	@if(isset($service['type_services']['profiles']))
																		
																		<li class="dd-item">
																			<div class="dd3-content">
																				Perfiles
																			</div>

																			@foreach($service['type_services']['profiles'] as $profiles)
																					
																				<ol class="dd-list" id='perfil'>
																					<li class="dd-item">
																						<div class="dd3-content">
																							{{Form::text('ServiceSettings[type_services][profiles][]',$profiles,['class'=>'styleInputText','readonly'=>true])}}
																							<em class="label pull-right">
																								@if ($user->hasAccess('twitter.update'))
																								<button type="button" class="btn btn-danger btn-xs btnDel">x</button>
																								@endif
																							</em>
																						</div>
																					</li>
																				</ol>

																			@endforeach

																		</li>
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Perfiles
																			</div>
																			<ol class="dd-list" id='perfil'></ol>
																		</li>

																	@endif
																</ol>

																<ol class="dd-list" id='listHashtags'>
																	

																	@if(isset($service['type_services']['hashtags']))

																		<li class="dd-item">
																			<div class="dd3-content">
																				Hashtag
																			</div>
																				@foreach($service['type_services']['hashtags'] as $hastags)
																					
																					<ol class="dd-list" id='hashtag' >
																						<li class="dd-item">
																							<div class="dd3-content">
																								{{Form::text('ServiceSettings[type_services][hashtags][]',$hastags,['class'=>'styleInputText','readonly'=>true])}}
																								<em class="label pull-right">
																									<button type="button"  class="btn btn-danger btn-xs btnDel">x</button>
																								</em>
																							</div>
																						</li>
																					</ol>
																				@endforeach
																		</li>
																		</li>
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Hashtag
																			</div>
																			<ol class="dd-list" id='hashtag'></ol>
																		</li>	
																	@endif	
																</ol>
																<ol class="dd-list" id='listList'>
																	

																			@if(isset($service['type_services']['lists']))

																				<li class="dd-item">
																					<div class="dd3-content">
																						Listas
																					</div>

																					@foreach($service['type_services']['lists'] as $profile => $lists)

																						

																							<ol class="dd-list" id="lista">
																								<li class="dd-item" id="{{substr($profile,1)}}">
																									<div class="dd3-content">
																										{{Form::text('',$profile,['class'=>'styleInputText','readonly'=>true])}}
																										<em class="label pull-right">
																											<button type="button"  class="btn btn-danger btn-xs btnDel">x</button></em>
																									</div>

																									@foreach($lists as $nameSlug => $name)
																										<ol class="dd-list">
																											<li class="dd-item">
																												<div class="dd3-content">
																													
																													{{Form::text('ServiceSettings[type_services][lists]['.$profile.']['.$nameSlug.'][]',$name[0],['class'=>'styleInputText','readonly'=>true,'id'=>substr($profile,1)."_".$nameSlug])}}
																													<em class="label pull-right">
																														<button type="button" class="btn btn-danger btn-xs btnDel" data-nameprof='{{substr($profile,1)}}' >x</button>
																													</em>
																												</div>
																											</li>
																										</ol>
																									@endforeach
																								</li>
																								
																							</ol>
																						
																					@endforeach
																				</li>
																			@else
																				<li class="dd-item ddTypeService">
																					<div class="dd3-content">
																						Listas
																					</div>
																					<ol class="dd-list" id="lista"></ol>
																				</li>	
																			@endif
																</ol>

																<ol class="dd-list" id='listInstagram'>
																	
																	@if(isset($service['type_services']['instagrams']))
																		<li class="dd-item">
																			<div class="dd3-content">
																				Instagram
																			</div>
																			<ol class="dd-list" id='lista_instagram' >
																					@foreach($service['type_services']['instagrams'] as $instagram)
																						
																							<li class="dd-item">
																								<div class="dd3-content">
																									{{Form::text('ServiceSettings[type_services][instagrams][]',$instagram,['class'=>'styleInputText','readonly'=>true])}}
																									<em class="label pull-right">
																										<button type="button"  class="btn btn-danger btn-xs btnDel">x</button>
																									</em>
																								</div>
																							</li>
																					@endforeach
																			</ol>
																		</li>
																	@else

																		<li class="dd-item">
																			<div class="dd3-content">
																				Instagram
																			</div>
																			<ol class="dd-list" id="lista_instagram"></ol>
																		</li>

																	@endif
	
																</ol>

																<ol class="dd-list" id='listFacebookFeeds'>
																	

																	@if(isset($service['type_services']['facebook_feeds']))

																		<li class="dd-item">
																			<div class="dd3-content">
																				Facebook Feeds
																			</div>
																				@foreach($service['type_services']['facebook_feeds'] as $facebook_page)
																					
																					<ol class="dd-list" id='facebook-feeds' >
																						<li class="dd-item">
																							<div class="dd3-content">
																								{{Form::text('ServiceSettings[type_services][facebook_feeds][]',$facebook_page,['class'=>'styleInputText','readonly'=>true])}}
																								<em class="label pull-right">
																									<button type="button"  class="btn btn-danger btn-xs btnDel">x</button>
																								</em>
																							</div>
																						</li>
																					</ol>
																				@endforeach
																		</li>
																		</li>
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Facebook Feeds
																			</div>
																			<ol class="dd-list" id='facebook-feeds'></ol>
																		</li>	
																	@endif	
																</ol>

																<ol class="dd-list" id='listFacebookVideos'>
																																	
																	@if(isset($service['type_services']['facebook_videos']))

																		<li class="dd-item">
																			<div class="dd3-content">
																				Facebook Videos
																			</div>
																				@foreach($service['type_services']['facebook_videos'] as $facebook_video)
																					
																					<ol class="dd-list" id='facebook-videos' >
																						<li class="dd-item">
																							<div class="dd3-content">
																								{{Form::text('ServiceSettings[type_services][facebook_videos][]',$facebook_video,['class'=>'styleInputText','readonly'=>true])}}
																								<em class="label pull-right">
																									<button type="button"  class="btn btn-danger btn-xs btnDel">x</button>
																								</em>
																							</div>
																						</li>
																					</ol>
																				@endforeach
																		</li>
																		</li>
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Facebook Videos
																			</div>
																			<ol class="dd-list" id='facebook-videos'></ol>
																		</li>	
																	@endif	
																</ol>

																<ol class="dd-list" id='listYoutubeVideos'>
																																	
																	@if(isset($service['type_services']['youtube_videos']))

																		<li class="dd-item">
																			<div class="dd3-content">
																				Canal Youtube
																			</div>
																				@foreach($service['type_services']['youtube_videos'] as $youtube_video)
																					
																					<ol class="dd-list" id='youtube-videos' >
																						<li class="dd-item">
																							<div class="dd3-content">
																								{{Form::text('ServiceSettings[type_services][youtube_videos][]',$youtube_video,['class'=>'styleInputText','readonly'=>true])}}
																								<em class="label pull-right">
																									<button type="button"  class="btn btn-danger btn-xs btnDel">x</button>
																								</em>
																							</div>
																						</li>
																					</ol>
																				@endforeach
																		</li>
																		</li>
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Canal Youtube
																			</div>
																			<ol class="dd-list" id='youtube-videos'></ol>
																		</li>	
																	@endif	
																</ol>

																<ol class="dd-list" id='PlayListsYoutube'>
																																	
																	@if(isset($service['type_services']['playlists-videos']))

																				<li class="dd-item">
																					<div class="dd3-content">
																						Canal Youtube
																					</div>

																					@foreach($service['type_services']['playlists-videos'] as $canal => $lists)

																						

																							<ol class="dd-list" id="lista">
																								<li class="dd-item" id="{{$canal}}">
																									<div class="dd3-content">
																										{{Form::text('',$canal,['class'=>'styleInputText','readonly'=>true])}}
																										<em class="label pull-right">
																											<button type="button"  class="btn btn-danger btn-xs btnDel">x</button></em>
																									</div>

																									@foreach($lists as $nameSlug => $name)
																										<ol class="dd-list">
																											<li class="dd-item">
																												<div class="dd3-content">
																													
																													{{Form::text('ServiceSettings[type_services][playlists-videos]['.$canal.']['.$nameSlug.'][]',$name[0],['class'=>'styleInputText','readonly'=>true,'id'=>$canal."_".$nameSlug])}}
																													<em class="label pull-right">
																														<button type="button" class="btn btn-danger btn-xs btnDel" data-nameprof='{{$canal}}' >x</button>
																													</em>
																												</div>
																											</li>
																										</ol>
																									@endforeach
																								</li>
																								
																							</ol>
																						
																					@endforeach
																				</li>

																		
																	@else
																		<li class="dd-item ddTypeService">
																			<div class="dd3-content">
																				Canal Youtube
																			</div>
																			<ol class="dd-list" id='playlists-videos'></ol>
																		</li>	
																	@endif	
																</ol>
															</div>
														</div>
													</div>
													
													
													@if(isset($service))
														@if ($user->hasAccess('twitter.update'))
															<footer id='updateSettingsService'>
																<button type="submit" class="btn btn-primary btn-xs">
																	{{Lang::get('servicesTwitter.btnSaveChanges')}}
																</button>
															</footer>
														@endif
													@else
														@if ($user->hasAccess('twitter.create'))
															<footer id='saveSettingsService'>
																<button type="submit" class="btn btn-primary btn-xs">
																	{{Lang::get('servicesTwitter.btnSave')}}
																</button>
															</footer>
														@endif
													@endif
													
											{{Form::close()}}

										</div>
									</article>
								</div>
							</div>
							
						</article>
					</div>
				
				

				

@endif				
@stop

@section('scripts')
    @parent
    	<script src="/js/notification/SmartNotification.min.js"></script>
		<script src="/js/plugin/jquery-nestable/jquery.nestable.min.js"></script>
		<script src="/js/plugin/ion-slider/ion.rangeSlider.min.js"></script>
		<script src="/js/servicesTwitter.js"></script>


		<script src="/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>


		<script type="text/javascript">
		
		// DO NOT REMOVE : GLOBAL FUNCTIONS!

		$(document).ready(function() {
			
			pageSetUp();



			/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;

				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
				var numTweets = parseInt( $("#val_num_tweets").val() );

				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					},
					bFilter: false,
					bSort : false,
					"lengthMenu": [[numTweets, numTweets*2, (numTweets*2)*2], [numTweets, numTweets*2, (numTweets*2)*2]]
				});
	
			/* END BASIC */

			/* CALENDAR */

				// Date Range Picker
				$("#active_date").datepicker({
				    defaultDate: "+1w",
				    changeMonth: true,
				    numberOfMonths: 1,
				   	dateFormat: 'dd/mm/yy',
				    prevText: '<i class="fa fa-chevron-left"></i>',
				    nextText: '<i class="fa fa-chevron-right"></i>',
				    onClose: function (selectedDate) {
				        $("#inactive_date").datepicker("option", "minDate", selectedDate);
				    },
				    onSelect: function() {

    					dateTo = (new Date($(this).val()).getTime() / 1000).toFixed(0)
    					$("#dateFrom").val($(this).val());
  					}
			
				});


				$("#inactive_date").datepicker({
				    defaultDate: "+1w",
				    changeMonth: true,
				    numberOfMonths: 1,
				    dateFormat: 'dd/mm/yy',
				    prevText: '<i class="fa fa-chevron-left"></i>',
				    nextText: '<i class="fa fa-chevron-right"></i>',
				    onClose: function (selectedDate) {
				        $("#active_date").datepicker("option", "maxDate", selectedDate);
				        
				    },
				    onSelect: function() {

    					dateFrom = (new Date($(this).val()).getTime() / 1000).toFixed(0)
				    	$("#dateTo").val($(this).val())
				    }
				});

			});

		


			$(".idTweet").on('click',function(){
				idService = $(this).attr('data-idService');
				idTweet = $(this).attr('id');
				statusTweet = false;

				if( $(this).parent().closest('tr').find('.tweetOpacity').length == 0 ){
					
					$(this).text('Mostrar').removeClass('btn-info').addClass('btn-success');
					$(this).parent().closest('tr').find('li').addClass('tweetOpacity');
					statusTweet = false;
				
				}else{
					
					$(this).text('Ocultar').removeClass('btn-success').addClass('btn-info');
					$(this).parent().closest('tr').find('li').removeClass('tweetOpacity');
					statusTweet = true;
				}


				$.ajax({
						url: "../hide-tweet",
						type:'GET',
						data: {idTweet:idTweet,statusTweet:statusTweet,idService:idService},
						dataType:'JSON',
						success:function(data){

							console.log(data)

						}
				})
			});


			/* Actualiza Tweet*/

			$("#UpdConfigSocial").one('click',function(){

				var UpdConfigSocial = $(this);
				
				$(UpdConfigSocial).removeClass('btn-primary').addClass('btn-warning').html("Actualizando  ").append($("<i>").addClass('fa fa-gear fa-spin'));
				
				idConfigureService = $(this).attr("data-service");
					
					$.ajax({
							url: "../update-config-social",
							type:'GET',
							data: {idConfigureService:idConfigureService},
							dataType:'JSON',
							success:function(data){

								var updateProfiles = setInterval(function(){
										$.ajax({
											url:'../status-config-social',
											type:'GET',
											data:{data:data},
											dataType:'JSON',
											success:function(data){

												if(data == 'Finish'){

													$(UpdConfigSocial).removeClass('btn-warning fa fa-gear fa-spin').addClass('btn-success').html("Actualizado");
													clearInterval(updateProfiles);

													$("#UpdConfigSocial").before($("<button>",{text:'Da Clik para refrescar y ver cambios','id':'btnRefresh'}).addClass('btn btn-warning btn-xs pull-right'));

													$("#btnRefresh").one('click',function(){
														location.reload();
													});

												}
											}
										});
									}, 30000);
							}
					})				
			});


			/* Genera Json*/

			$("#generateJson").on('click',function(){

				var generateJson = $(this);
					id = $(generateJson).attr("data-service");

				$(generateJson).html("Actualizando Json ").append($("<i>").addClass('fa fa-gear fa-spin'));
				
				$.ajax({
					url: "../generate-json",
					type:'GET',
					data:{id:id},
					dataType:'JSON',
					success:function(data){
						$(generateJson).removeClass('fa fa-gear fa-spin').html("Json actualizado");
					}
				})
			});


		</script>



@stop