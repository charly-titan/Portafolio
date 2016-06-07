@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

{{Form::hidden('socialNetworkOpt',isset($socialNetworkOpt)?$socialNetworkOpt:null,array('id'=>'socialNetworkOpt'))}}

@if ($userPermission["view"])

	{{Form::open(array('url'=>'/contest/sales','method'=>'POST','name'=>'save'))}}

		{{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}} 
	                										
	    <div class="tab-pane active">

			<br>
			<legend></legend>
			
			<fieldset>
				<section>
					<div class="form-group">
						<label class="col-md-2 control-label">{{Lang::get('contest.socialNetworks')}}</label>
							<div class="col-md-10">
								<label class="checkbox-inline">
											<input type="checkbox" class="checkbox style-0" name='socialNetwork[]' value='facebook' id='facebook' {{isset($gigyaOption)&&$gigyaOption?"disabled='disabled'":''}}>
											<span>Facebook</span>
								</label>
								<label class="checkbox-inline">
											<input type="checkbox" class="checkbox style-0" name='socialNetwork[]' value='twiter' id='twiter' {{isset($gigyaOption)&&$gigyaOption?"disabled='disabled'":''}}>
											<span>Twiter</span>
								</label>
								<label class="checkbox-inline">
											<input type="checkbox" class="checkbox style-0" name='socialNetwork[]' value='google' id='google' {{isset($gigyaOption)&&$gigyaOption?"disabled='disabled'":''}}>
											<span>Google +</span>
								</label>
							</div>
					</div>{{$errors->first('socialNetwork','<span class="error">:message</span>')}}
					<br><br>
					<div class="col-md-10">
							<div class="smart-form">
				                    <div class=" inline-group">
				                        <label class="radio">
				                        	{{Form::checkbox('optionGigya',isset($gigyaOption)?$gigyaOption:'0',isset($gigyaOption)?$gigyaOption:false,['id'=>'optionGigya'])}}
				                            <i></i><strong> {{Lang::get('contest.optionGigya')}}</strong></label>
				                    </div>
				                </div> 
				    </div>
				</section>

			</fieldset>

	            {{--{{Form::button(Lang::get('contest.close'),array('class'=>'btn btn-primary','onclick'=>'save.submit();stopRKey()'))}}--}}
	                                         
	        <div class="form-actions">

				@if ($userPermission["update"])

					{{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-primary','onclick'=>'save.submit();stopRKey()'))}}	
															
				@else
					{{ HTML::linkAction('ContestController@getSales', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}

				@endif

				{{ HTML::linkAction('ContestController@getTos', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
			</div>  
		</div>
	{{Form::close()}}

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
            {{ HTML::linkAction('ContestController@getTos', Lang::get('contest.close'),null,array('class'=>'btn btn-primary')) }}
            {{ HTML::linkAction('ContestController@getTos', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif


@stop

