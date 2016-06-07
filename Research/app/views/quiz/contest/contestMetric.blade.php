@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

{{Form::hidden('userProviding',isset($userProviding)?$userProviding:null,array('id'=>'dataAutorizedDatabase'))}}

@if ($userPermission["view"])

    {{Form::open(array('class'=>'smart-form','url'=>'/contest/finalizeform','method'=>'POST','name'=>'save'))}}

        {{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}   

        <div class="tab-pane active">
            <fieldset>
                <legend><br></legend>
                 <section>
                    {{Form::label('uat',Lang::get('contest.uat'),array('class'=>'label'))}}
                    <label class="input">
                         {{Form::text('uat',isset($properties->uat)? $properties->uat:null,array('class'=>'form-control input-md','placeholder'=> Lang::get('contest.uat')))}}
                    </label>{{$errors->first('uat', '<span class="error">:message</span>')}}
                </section>
                <section>
                    {{Form::label('vertical',Lang::get('contest.vertical'),array('class'=>'label'))}}
                    <label class="input">
                         {{Form::text('vertical',isset($properties->vertical)? $properties->vertical:null,array('class'=>'form-control input-md','placeholder'=> Lang::get('contest.vertical')))}}
                    </label>{{$errors->first('vertical', '<span class="error">:message</span>')}}
                </section>
                <section>
                    {{Form::label('namePromotion',Lang::get('contest.namePromotion'),array('class'=>'label'))}}
                    <label class="input">
                          {{Form::text('namePromotion',isset($properties->namePromotion)? $properties->namePromotion:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.namePromotion')))}}
                    </label>{{$errors->first('namePromotion','<span class="error">:message</span>')}}
                </section>
                <section>
                    {{Form::label('nameSectionTable',Lang::get('contest.nameSectionTable'),array('class'=>'label'))}}
                    <label class="input">
                        {{Form::text('nameSectionTable',isset($properties->nameSectionTable)? $properties->nameSectionTable:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.nameSectionTable')))}}
                    </label>{{$errors->first('nameSectionTable','<span class="error">:message</span>')}}
                </section>
                
                <div class="row">
                    <section class="col col-10">
                        {{Form::label('provinStatistics',Lang::get('contest.provinStatistics'),array('class'=>'label'))}}
                        <select style="width:100%" class="select2" id='selectUser'>
                            <option></option>

                            @foreach ($users as $key => $value)
                                <option value="{{Crypt::decrypt($value->first_name)}}" id='{{$value->id}}'>{{Crypt::decrypt($value->first_name)}}</option>
                            @endforeach
                        </select>{{$errors->first('selectUser','<span class="error">:message</span>')}}
                    </section>
                    <section class="col col-2">
                        {{Form::label('A',"",array('class'=>'label','style'=>'color:white'))}}
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
            </fieldset> 
            {{Form::hidden('autorizedPerson',isset($autorizedPerson)?$autorizedPerson:null,array('id'=>'autorizedPerson'))}}

            <div class="form-actions">

                @if ($userPermission["update"])

                    {{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-sm btn-primary','onclick'=>'save.submit();stopRKey()'))}}  
                                                            
                @else
                    {{ HTML::linkAction('ContestController@getText', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-sm btn-primary')) }}

                @endif

                {{ HTML::linkAction('ContestController@getSales', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-sm btn-primary pull-left')) }}
            </div>  

        </div>
    {{Form::close()}}   

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getIndex', Lang::get('contest.close'),null,array('class'=>'btn btn-primary')) }}
                {{ HTML::linkAction('ContestController@getSales', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif

@stop

