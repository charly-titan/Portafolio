@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

{{Form::hidden('ownerIDselect',isset($ownerIDselect)?$ownerIDselect:null,array('id'=>'ownerIDselect'))}}
{{Form::hidden('dataAutorizedDatabase',isset($dataAutorizedDatabase)?$dataAutorizedDatabase:null,array('id'=>'dataAutorizedDatabase'))}}

@if ($userPermission["view"])

	{{Form::open(array('class'=>'smart-form','url'=>'/contest/tos/','method'=>'POST','name'=>'save'))}}

		{{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}   

	    <div class="tab-pane active">
			<fieldset>
				
				<legend>
				<br>
					{{Lang::get('contest.OwnersInformation')}}
				</legend>
															
				<div class="row">
					<section class="col col-10">
						<select style="width:100%"  class="select2" name='ownerInformationID' id='ownerInformationID'>
								<option></option>
							@foreach ($users as $key => $value)
								<option value='{{$value}}' id='{{$value}}' name='"{{Crypt::decrypt($key)}}"'>{{Crypt::decrypt($key)}}</option>
							@endforeach
						</select>{{$errors->first('ownerInformationID','<span class="error">:message</span>')}}
					</section>
				</div>

				<section>
					<legend>
						{{Lang::get('contest.authorizedUsers')}}
					</legend>
				</section>

				<div class="row">
					<section class="col col-10">
						<select style="width:100%" class="select2" id='selectUser' name='selectUser'>
						<option></option>
							@foreach ($users as $key => $value)
								<option value="{{Crypt::decrypt($key)}}" id='{{$value}}'>{{Crypt::decrypt($key)}}</option>
							@endforeach
						</select>{{$errors->first('selectUser','<span class="error">:message</span>')}}
					</section>
					<section class="col col-2">
							<button type="button" class="btn btn-success btn-sm" id='addUser'>
								<i class="fa fa-plus"></i> {{Lang::get('contest.add')}}
							</button>
					</section>
				</div>

				<section>
					<div id='datos'>
						<div class="table-responsive">
							<table class="table table-hover" id='userAdd'>
								<thead>
									<tr>
										<th>{{Lang::get('contest.firstName')}}</th>
										<th></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</section>

				{{Form::hidden('autorizedPerson',isset($autorizedPerson)?$autorizedPerson:null,array('id'=>'autorizedPerson'))}}
			</fieldset>	

			<div class="form-actions">

				@if ($userPermission["update"])

					{{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-sm btn-primary','onclick'=>'save.submit();stopRKey()'))}}
															
				@else
					{{ HTML::linkAction('ContestController@getTos', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-sm btn-primary')) }}

				@endif
			
				{{ HTML::linkAction('ContestController@getContestdate', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-sm btn-primary pull-left')) }}
			</div>

		</div>
	{{Form::close()}}	

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getTos', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
                {{ HTML::linkAction('ContestController@getContestdate', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif

@stop

