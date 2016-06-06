@extends('vcms.main')

@section('content')

{{App::setLocale(Session::get('locale'))}}

@section('titulo')
{{Lang::get('formAccount.upd_user')}}
@stop
<div class="row">
    <div class="col-md-7">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-edit"></i>
                    {{Lang::get('formAccount.upd_user')}}
                </h4>
            </header>
            <div  class="body">

                <input type='hidden' id='formUserPermission' value='formUserPermission'>
                {{Form::open(array('method' => 'POST','url' => 'userPermission/editprofile/'.$profiles[0]->id_users,'class'=>'form-horizontal'))}}

                <fieldset>
                    <legend class="section">{{Lang::get('formAccount.personal_info')}}</legend>
                    {{Form::hidden('id_users',$profiles[0]->id_users,array('id' => 'id_users'))}}


                    <div class="control-group">
                        {{Form::label('first_name',Lang::get('formAccount.first_name'),array('class' => 'control-label '))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{Form::text('first_name',Crypt::decrypt($profiles[0]->first_name),array('class' => 'form-control'))}}
                            </div>{{$errors->first('first_name', '<span class="error">:message</span>')}}
                        </div>

                    </div>

                    <div class="control-group">
                        {{Form::label('last_name',Lang::get('formAccount.last_name'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{Form::text('last_name',Crypt::decrypt($profiles[0]->last_name),array('class' => 'form-control'))}}
                            </div>{{$errors->first('last_name', '<span class="error">:message</span>')}}
                        </div> 
                    </div>


                    <div class="control-group">
                        {{Form::hidden('gender',$profiles[0]->gender, array('id'=>'gender'))}}
                        <label class="control-label">{{Form::label('gender',Lang::get('formAccount.gender'),array('class' => 'control-label'))}}</label>
                        <div class="controls form-group" id='radioGender'>
                            <div class="input-group col-sm-8">
                                <label class="radio">
                                    <input type="radio" id="female" class="iCheck" name="gender" value="female" style="position: absolute; opacity: 0;">
                                    {{Lang::get('formAccount.female')}}</label>
                                <label class="radio">
                                    <input type="radio" name="gender" class="iCheck" id="male" value="male" style="position: absolute; opacity: 0;">
                                    {{Lang::get('formAccount.male')}}</label>
                            </div> {{$errors->first('gender', '<span class="error">:message</span>')}}       
                        </div>
                    </div>

                    <div class="control-group">
                        {{Form::label('birthdate',Lang::get('formAccount.dateBirth'),array('class' => 'control-label '))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                {{Form::text('birthdate',$profiles[0]->birthdate, array('class' => 'form-control'))}}
                                <span class="input-group-btn"><a href="#" class="btn btn-danger date-picker" data-date-format="yyyy/mm/dd" data-date="today();">
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                </span>

                            </div>{{$errors->first('birthdate', '<span class="error">:message</span>')}} 

                        </div>

                    </div>

                </fieldset>

                <fieldset>
                    <legend class="section">{{Lang::get('formAccount.contact')}}</legend>

                    <div class="control-group">
                        {{Form::label('email',Lang::get('formAccount.email'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                {{Form::text('email',$profiles[0]->email,array('class' => 'form-control'))}}
                            </div>{{$errors->first('email', '<span class="error">:message</span>')}}
                        </div> 

                    </div>


                    <div class="control-group">
                        {{Form::label('phone',Lang::get('formAccount.phone'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                {{Form::text('phone',Crypt::decrypt($profiles[0]->phone), array('class' => 'form-control'))}}

                            </div>{{$errors->first('phone', '<span class="error">:message</span>')}}
                        </div> 
                    </div> 

                    <div class="control-group">
                        {{Form::label('fax','Fax',array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                                {{Form::text('fax',Crypt::decrypt($profiles[0]->fax), array('class' => 'form-control'))}}
                            </div>
                        </div> 
                    </div>


                </fieldset>
                <fieldset>
                    <legend class="section">{{Lang::get('formAccount.address')}}</legend>


                    <div class="control-group">
                        {{Form::label('address',Lang::get('formAccount.address1'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                {{Form::text('address',Crypt::decrypt($profiles[0]->address), array('class' => 'form-control'))}}
                            </div>{{$errors->first('address', '<span class="error">:message</span>')}}
                        </div>
                    </div>

                    <div class="control-group">
                        {{Form::label('city',Lang::get('formAccount.city'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                {{Form::text('city',$profiles[0]->city, array('class' => 'form-control'))}}
                            </div>{{$errors->first('city', '<span class="error">:message</span>')}}
                        </div> 
                    </div>

                    <div class="control-group">
                        {{Form::label('zip_code',Lang::get('formAccount.zip_code'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                {{Form::text('zip_code',$profiles[0]->zip_code, array('class' => 'form-control'))}}
                            </div>{{$errors->first('zip_code', '<span class="error">:message</span>')}}
                        </div> 
                    </div>

                    <div class="control-group">
                        {{Form::label('state',Lang::get('formAccount.state'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                {{Form::text('state',$profiles[0]->state, array('class' => 'form-control'))}}
                            </div>{{$errors->first('state', '<span class="error">:message</span>')}}
                        </div> 
                    </div>

                    <div class="control-group">
                        {{Form::label('country',Lang::get('formAccount.country'),array('class' => 'control-label'))}}
                        <div class="controls form-group">
                            <div class="input-group col-sm-9">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                {{Form::text('country',$profiles[0]->country, array('class' => 'form-control'))}}
                            </div>{{$errors->first('country', '<span class="error">:message</span>')}}
                        </div> 
                    </div>


                </fieldset>

                <div class="form-actions">
                    <a href="{{ URL::to('userPermission/')}}" class='btn btn-default'>{{Lang::get('formAccount.cancel')}}</a>
                    {{Form::submit(Lang::get('formAccount.save1'),array('class'=>'btn btn-primary'))}}

                </div>



                <div id='valSitePermAct'></div>
                {{Form::close()}}    

            </div>
        </section>
    </div>
    <div class="col-md-4">
        <section class="widget">
            <header>
                <h4><i class="fa fa-cogs"></i>{{Lang::get('formAccount.permission_assigned')}}</h4>
                <div style='text-align: right'>
                    <input type="button" value="{{Lang::get('formAccount.edit_permission')}}" id="editPerm" class="btn btn-success btn-sm">
                </div>
                @if (Session::has('msg'))
                {{ Form::hidden('', Session::get('inputCheck'), array('id' => 'sex')) }}
                <div class="alert alert-info" style='text-align: center'>{{Lang::get('formAccount.msg_account')}}</div>
                @endif
            </header>

            <div class="body">   
                <div class="form-group">
                    {{Form::open(array('method' => 'GET','class'=>'form-horizontal label-left','id' => 'formDelete'))}}

                    {{ Form::hidden('', $perfilPermission, array('id' => 'perfilPermission')) }}

                    <table id='tablePerm' class='table'></table>

                    {{Form::close()}} 
                </div>
            </div>                    
        </section>
    </div>
    <div class="col-md-4" id='tableAccountSetting'>
        <section class="widget">
            <header>
                <h4><i class="fa fa-cogs"></i>{{Lang::get('formAccount.account_setting')}}</h4>
            </header>

            <div class="body">
                <div class="form-group">
                    {{Form::label('sites',Lang::get('formAccount.sites'))}} 
                    {{ Form::select('selectSite', $sites, null, ['id' => 'selectSite','class' => 'chzn-select select-block-level']) }}
                </div>

                <div class="controls form-group">
                    {{Form::label('roles','Roles')}}
                    {{ Form::select('rol[]',array(), null, ['id' => 'selectRol','class' => 'chzn-select select-block-level','multiple'=>'multiple']) }}
                </div>
                <div class="well well-sm well-white"> 
                    <div class="row">
                        <div class="col-xs-4 col-sm-offset-4">
                            {{ Form::button(Lang::get('formAccount.add_permission'), array('class' => 'btn btn-success','id' => 'addPermission')) }}
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

@stop

@section('scripts')
@parent

{{ HTML::style('css/formAccount.css')}} 

{{ HTML::script('light-blue/lib/jquery-pjax/jquery.pjax.js') }}
{{ HTML::script('light-blue/lib/icheck.js/jquery.icheck.js') }}
{{ HTML::script('light-blue/lib/jquery.autogrow-textarea.js') }}
{{ HTML::script('light-blue/lib/bootstrap/tooltip.js') }}
{{ HTML::script('light-blue/lib/bootstrap-datepicker.js') }}
{{ HTML::script('light-blue/lib/bootstrap-colorpicker.js') }}
{{ HTML::script('light-blue/lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}
{{ HTML::script('js/formAccountNewUpd.js') }} 
{{ HTML::script('js/formAccountUpd.js') }}
{{ HTML::script('light-blue/js/forms-elemets.js') }}         

@stop