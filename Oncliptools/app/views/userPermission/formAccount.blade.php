@extends('vcms.main')

@section('content')

    {{App::setLocale(Session::get('locale'))}}
    
    <div class="row">
        <div class="col-md-7">
            <section class="widget">
                <header>
                    <h4>
                        <i class="fa eicon-user-add"></i>
                        {{Lang::get('formAccount.add_user')}}
                    </h4>
                </header>

            <div  class="body">
                <input type='hidden' id='formUserPermission' value='formUserPermission'>
                    {{Form::open(array('method' => 'POST','url' => 'userPermission/formaccount','class'=>'form-horizontal label-left','id'=>'user-form','data-parsley-priority-enabled'=>'false'))}}

                     <fieldset>

                        <legend class="section">{{Lang::get('formAccount.personal_info')}}</legend>

                        <div class="control-group">
                        {{Form::label('first_name',Lang::get('formAccount.first_name'),array('class' => 'control-label'))}}
                            <div class="controls form-group">
                                <div class="input-group col-sm-8">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        {{Form::text('first_name','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.first_name')))}}
                                </div>
                                {{$errors->first('first_name', '<span class="error">:message</span>')}}
                            </div> 
                        </div>

                        <div class="control-group">
                                {{Form::label('last_name',Lang::get('formAccount.last_name'),array('class' => 'control-label'))}}
                                <div class="controls form-group">
                                    <div class="input-group col-sm-8">
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            {{Form::text('last_name','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.last_name')))}}
                                    </div>
                                    {{$errors->first('last_name', '<span class="error">:message</span>')}}
                                </div> 
                        </div>

                        <div class="control-group">
                            <label class="control-label">{{Form::label('gender',Lang::get('formAccount.gender'),array('class' => 'control-label'))}}</label>
                            <div class="controls form-group" id='radioGender'>
                                <div class="input-group col-sm-8">
                                    <label class="radio">
                                        <input type="radio" id="female" class="iCheck" name="gender" value="female" style="position: absolute; opacity: 0;">
                                        <i class='fa fa-female fa-lg'></i>  {{Lang::get('formAccount.female')}}</label>
                                    <label class="radio">
                                        <input type="radio" name="gender" class="iCheck" id="male" value="male" style="position: absolute; opacity: 0;">
                                        <i class='fa fa-male fa-lg'></i>  {{Lang::get('formAccount.male')}}</label>
                                </div> {{$errors->first('gender', '<span class="error">:message</span>')}}       
                            </div>
                        </div>

                                    <div class="control-group">
                                        {{Form::label('birthdate',Lang::get('formAccount.dateBirth'),array('class' => 'control-label'))}}
                                        <div class="controls form-group">
                                            <div class="input-group col-sm-8">
                                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                                {{Form::text('birthdate','', array('class' => 'form-control','format'=>'yyyy/mm/dd'))}}
                                                <span class="input-group-btn"><a href="#" class="btn btn-danger date-picker" data-date-format="yyyy/mm/dd" data-date="today();">
                                                    <i class="fa fa-calendar"></i>
                                                    </a>
                                                </span>
                                            </div>
                                            {{$errors->first('birthdate', '<span class="error">:message</span>')}}
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        {{Form::label('password',Lang::get('formAccount.password'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                     <input type="password" name='password' class="form-control" placeholder='{{Lang::get('formAccount.password')}}'>
                                                </div>
                                               {{$errors->first('password', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('password_repeat',Lang::get('formAccount.password_repeat'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                                    <input type="password" name='password_repeat' class="form-control" placeholder='{{Lang::get('formAccount.password_repeat')}}'>
                                                </div>
                                               {{$errors->first('password_repeat', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                </fieldset>

                                <fieldset>
                                    <legend class="section">{{Lang::get('formAccount.contact')}}</legend>

                                   <div class="control-group">
                                        {{Form::label('email',Lang::get('formAccount.email'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                                    {{Form::text('email','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.email')))}}
                                                </div>
                                               {{$errors->first('email', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                   <div class="control-group">
                                        {{Form::label('phone',Lang::get('formAccount.phone'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                                    {{Form::text('phone','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.phone')))}}
                                                </div>
                                               {{$errors->first('phone', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('fax','Fax',array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>
                                                    {{Form::text('fax','', array('class' => 'form-control','placeholder'=> 'Fax'))}}
                                                </div>
                                            </div> 
                                    </div>

                                </fieldset>
                                


                               <fieldset>
                                    <legend class="section">{{Lang::get('formAccount.address')}}</legend>

                                    <div class="control-group">
                                        {{Form::label('address',Lang::get('formAccount.address1'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    {{Form::text('address','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.address1')))}}
                                                </div>
                                                {{$errors->first('address', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('city',Lang::get('formAccount.city'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    {{Form::text('city','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.city')))}}
                                                </div>
                                                {{$errors->first('city', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('zip_code',Lang::get('formAccount.zip_code'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    {{Form::text('zip_code','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.zip_code')))}}
                                                </div>
                                                {{$errors->first('zip_code', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('state',Lang::get('formAccount.state'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    {{Form::text('state','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.state')))}}
                                                </div>
                                                {{$errors->first('state', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>

                                    <div class="control-group">
                                        {{Form::label('country',Lang::get('formAccount.country'),array('class' => 'control-label'))}}
                                            <div class="controls form-group">
                                                <div class="input-group col-sm-8">
                                                    <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                                    {{Form::text('country','', array('class' => 'form-control','placeholder'=> Lang::get('formAccount.country')))}}
                                                </div>
                                                {{$errors->first('country', '<span class="error">:message</span>')}}
                                            </div> 
                                    </div>


                                </fieldset>
                                 <div class="body text-align-center">
                                    <div class="well well-sm">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <a href="{{ URL::to('userPermission/')}}" class='btn btn-sm btn-default'>{{Lang::get('formAccount.cancel')}}</a>
                                            </div>
                                            <div class="col-xs-4">
                                                {{Form::reset(Lang::get('formAccount.clear'),array('class'=>'btn btn-sm btn-info')) }}
                                            </div>
                                            <div class="col-xs-4">
                                                {{Form::submit(Lang::get('formAccount.save'),array('class'=>'btn btn-sm btn-primary'))}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id='valSitePerm'></div>
                        {{Form::close()}}    

                        </div>
        </section>
    </div>

               <div class="col-md-4">
                    <section class="widget">
                        <header>
                            <h4><i class="fa fa-cogs"></i>{{Lang::get('formAccount.account_setting')}}</h4>
                         @if (Session::has('msg'))
                            {{ Form::hidden('', Session::get('inputCheck'), array('id' => 'gender')) }}
                                <div class="alert alert-info" style='text-align: center'>{{Lang::get('formAccount.msg_account')}}</div>
                         @endif
                        <div class="body">
                            <div class="form-group">
                               {{Form::label('sites',Lang::get('formAccount.sites'),array('class' => 'control-label'))}} 
                               {{ Form::select('selectSite', $sites, null, ['id' => 'selectSite','class' => 'chzn-select select-block-level']) }}
                            </div>



                            <div class="controls form-group">
                                 {{Form::label('roles','Roles',array('class' => 'control-label'))}}
                                 {{ Form::select('selectRol[]',array(), null, ['id' => 'selectRol','class' => 'chzn-select select-block-level','multiple']) }}
                            </div>
                            <div class="row">
                                    <div class="col-xs-4 col-sm-offset-4">
                                        {{ Form::button(Lang::get('formAccount.add_permission'), array('class' => 'btn btn-sm btn-success','id' => 'addPermission')) }}                                            
                                    </div>
                            </div>
                        </div>
                    </section>         
                </div>
        
             
                <div class="col-md-4" id='CurrentPermission'>
                    <section class="widget">
                        <header>
                            <h4><i class="fa fa-cogs"></i>{{Lang::get('formAccount.current_permission')}}</h4>
                        </header>
                        <div class="body" id='nestable'>
                                <table id='tablePermNew' class='table'></table>
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


{{ HTML::script('light-blue/js/forms-elemets.js') }}   

    
@stop