@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

@if ($userPermission["view"])

	{{Form::open(array('url'=>'/contest/metric','method'=>'POST','name'=>'save'))}}
	    
	    {{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}      										
	   
	     <div class="tab-pane active">                                       
            <br>
            <legend></legend>

            <div class="form-group">
                {{Form::label('promoSales',Lang::get('contest.promoSales'))}}
                {{Form::text('promoSales',isset($properties->promoSales)? $properties->promoSales:null,array('class'=>'form-control input-md','placeholder'=> Lang::get('contest.promoSales')))}}
                {{$errors->first('promoSales', '<span class="error">:message</span>')}}
            </div>

			{{Form::hidden('advertising',isset($properties->advertisingOption)? $properties->advertisingOption:null,['id'=>'advertising'])}}
           
				<section class="smart-form">
					<label class="label">{{Lang::get('contest.advertisingOption')}}</label>
					<div class="inline-group">
						<label class="radio">
							{{Form::checkbox('advertisingOption',true,'',['id'=>'advertisingOption'])}}
							<i></i>{{Lang::get('contest.advertisEnable')}}</label>
					</div>
				</section>

			<div class="form-actions">

				@if ($userPermission["update"])

					{{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-primary','onclick'=>'save.submit();stopRKey()'))}}	
															
				@else
					{{ HTML::linkAction('ContestController@getMetric', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}

				@endif
			
				{{ HTML::linkAction('ContestController@getNetworkservice', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
			</div>

		</div>

	{{Form::close()}}

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getMetric', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
                {{ HTML::linkAction('ContestController@getNetworkservice', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif

@stop


