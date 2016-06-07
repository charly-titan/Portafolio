@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')
<style>
	.modal-content{width: 750px;}
</style>
@if ($userPermission["view"])

	{{Form::open(array('url'=>'/contest/contestownerinf','method'=>'POST','name'=>'save'))}}
	           										
	   {{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}    
	   
	    <div class="tab-pane active">

			<br>
			<legend></legend>

			<fieldset>
				<section>
					<div class="row">
						<div class="col-sm-12">
							<label>{{Lang::get('contest.startDateContest')}}</label>

						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group">
									{{Form::text('startDate',isset($datesAll->startDate)? $datesAll->startDate:null,array('class'=>'form-control datepicker','placeholder'=>Lang::get('contest.selectDateContest'),'id'=>'startDate','data-dateformat'=>'yy/mm/dd',isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>{{$errors->first('startDate','<span class="error">:message</span>')}}
							</div>
						</div>
						<div class="col-sm-6">
						
							<div class="form-group">
								<div class="input-group">
									{{Form::text('startTime',isset($datesAll->startTime)? $datesAll->startTime:null,array('class'=>'form-control timepicker','placeholder'=>Lang::get('contest.selectTimeContest'),isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>{{$errors->first('startTime','<span class="error">:message</span>')}}
							</div>
						</div>
					</div>
				</section>
													
				<section>
					<div class="row">
						<div class="col-sm-12">
							<label>{{Lang::get('contest.closingDateContest')}}</label>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group">
									{{Form::text('closingDate',isset($datesAll->closingDate)? $datesAll->closingDate:null,array('class'=>'form-control datepicker','placeholder'=>Lang::get('contest.selectDateContest'),'data-dateformat'=>'yy/mm/dd',isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>{{$errors->first('closingDate','<span class="error">:message</span>')}}
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group">
									{{Form::text('closingTime',isset($datesAll->closingTime)? $datesAll->closingTime:null,array('class'=>'form-control timepicker','placeholder'=>Lang::get('contest.selectTimeContest'),isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>{{$errors->first('closingTime','<span class="error">:message</span>')}}
							</div>
						</div>
					</div>
				</section>
													
				<section>
					<div class="row">
						<div class="col-sm-12">
							<label>{{Lang::get('contest.activationDateContest')}}</label>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group">
									{{Form::text('activationDate',isset($datesAll->activationDate)? $datesAll->activationDate:null,array('class'=>'form-control datepicker','placeholder'=>Lang::get('contest.selectDateContest'),'data-dateformat'=>'yy/mm/dd',isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>{{$errors->first('activationDate','<span class="error">:message</span>')}}
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<div class="input-group">
									{{Form::text('activationTime',isset($datesAll->activationTime)? $datesAll->activationTime:null,array('class'=>'form-control timepicker','placeholder'=>Lang::get('contest.selectTimeContest'),isset($datesAll->statusRate)?'disabled':''))}}
									<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
								</div>{{$errors->first('activationTime','<span class="error">:message</span>')}}
							</div>
						</div>
					</div>
				</section>
				<input type="hidden" value='{{$datesAll->contestType or null}}' id='typeContestOpt'>
				<section class="smart-form">
					<label class="label">{{Lang::get('contest.typeContest')}}</label>
					<div class="inline-group">
						<label class="radio">
							{{Form::radio('typeContest','quiz','',array('id'=>'quiz',isset($datesAll->statusRate)?'disabled':''))}}
							<i></i>Quiz</label>
						<label class="radio">
							{{Form::radio('typeContest','frase','',array('id'=>'frase',isset($datesAll->statusRate)?'disabled':''))}}
							<i></i>Frase</label>
						<label class="radio">
							{{Form::radio('typeContest',Lang::get('contest.typePhotoContest'),'',array('id'=>Lang::get('contest.typePhotoContest'),isset($datesAll->statusRate)?'disabled':''))}}
							<i></i>{{Lang::get('contest.typePhotoContest')}}</label>
						<label class="radio">
							{{Form::radio('typeContest','video','',array('id'=>'video',isset($datesAll->statusRate)?'disabled':''))}}
							<i></i>Video</label>
						<label class="radio">
							{{Form::radio('typeContest','versus','',array('id'=>'versus',isset($datesAll->statusRate)?'disabled':''))}}
							<i></i>Versus</label>
							{{$errors->first('typeContest','<span class="error">:message</span>')}}
					</div>

				</section>

			</fieldset>

			<div class="form-actions">

				@if ($userPermission["update"])

					@if(isset($datesAll->statusRate))
						{{ HTML::linkAction('ContestController@getContestownerinf', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
					@else
						{{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-primary','onclick'=>'save.submit();stopRKey()'))}}
					@endif	
															
				@else
					{{ HTML::linkAction('ContestController@getContestownerinf', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}

				@endif
			
				{{ HTML::linkAction('ContestController@getContestdetails', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
			</div>

		</div>

	{{Form::close()}}
				
@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getContestownerinf', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
                {{ HTML::linkAction('ContestController@getContestdetails', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif

@stop

					

