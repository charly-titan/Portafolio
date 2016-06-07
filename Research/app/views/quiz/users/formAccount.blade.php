@extends(Config::get( 'app.main_template' ).'.main')

@section('content')
   <style>
    .error{color: red;}
    #CurrentPermission,#tableAccountSetting, #example_length,.dataTables_length{display: none;}
    .btnDel,.btndelete{margin: .3em;}
    .delPermision{width: 12%}
    .delPermision1{width: 100%}

   </style>

@if ($userPermission["view"])

    <div class="row">

        <article class="col-sm-12 col-md-12 col-lg-8"> 

        <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
            <header>
                <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                <h2>{{isset($profiles->id_users)?Lang::get('formAccount.upd_user'):Lang::get('formAccount.add_user')}}</h2>                        
            </header>
                        
            <div>          
                    <div class="widget-body no-padding">

                                @if(isset($profiles->id_users))
                                    {{Form::open(array('method' => 'POST','url' => 'user/editprofile/'.$profiles->id_users,'class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                                @else
                                    {{Form::open(array('method' => 'POST','url' => 'user/formaccount','class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                                @endif
                                {{Form::hidden('id_users',isset($profiles->id_users)?$profiles->id_users:null,array('id' => 'id_users'))}}
                                {{Form::hidden('valUserPermissionRoles',isset($userPermissionRoles)?json_encode($userPermissionRoles):null,array('id'=>'valUserPermissionRoles'))}} 
                                <header>{{Lang::get('formAccount.personal_info')}}</header>
                                    <fieldset>
                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                    {{Form::text('first_name',isset($profiles->first_name)?$profiles->first_name:null, array('placeholder'=> Lang::get('formAccount.first_name')))}}
                                                </label>{{$errors->first('first_name', '<span class="error">:message</span>')}}
                                            </section>
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                     {{Form::text('last_name',isset($profiles->last_name)?$profiles->last_name:null,array('placeholder' => Lang::get('formAccount.last_name')))}}
                                                </label>{{$errors->first('last_name', '<span class="error">:message</span>')}}
                                            </section>
                                        </div>

                                        @if(!isset($profiles->id_users))
                                            <div class="row">
                                                <section class="col col-6">
                                                    <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                                        {{Form::password('password',array('placeholder'=> Lang::get('formAccount.password')))}}
                                                    </label>{{$errors->first('password', '<span class="error">:message</span>')}}
                                                </section>
                                                <section class="col col-6">
                                                    <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                                         {{Form::password('password_repeat',array('placeholder'=> Lang::get('formAccount.password_repeat')))}}
                                                    </label>{{$errors->first('password_repeat', '<span class="error">:message</span>')}}
                                                </section>
                                            </div>
                                        @endif

                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                                    {{Form::text('email',isset($profiles->email)?$profiles->email:null,array('placeholder' => Lang::get('formAccount.email')))}}
                                                </label>{{$errors->first('email', '<span class="error">:message</span>')}}
                                            </section>
                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-lg fa-fw fa-mobile"></i>
                                                    {{Form::text('phone',isset($profiles->phone)?$profiles->phone:null, array('placeholder' => Lang::get('formAccount.phone')))}}

                                                </label>{{$errors->first('phone', '<span class="error">:message</span>')}}
                                            </section>
                                        </div>

                                        {{Form::hidden('gender',isset($profiles->gender)?$profiles->gender:null, array('id'=>'gender'))}}
                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="select">
                                                    <select name="gender" id='genders'>
                                                        <option value="0" selected="" disabled="">{{Lang::get('formAccount.gender')}}</option>
                                                        <option value='Male'>{{Lang::get('formAccount.male')}}</option>
                                                        <option value='Female'>{{Lang::get('formAccount.female')}}</option>
                                                    </select> <i></i> 
                                                </label>{{$errors->first('gender', '<span class="error">:message</span>')}}
                                            </section>

                                            <section class="col col-6">
                                                <label class="input"> <i class="icon-append fa fa-calendar"></i>


                                                    {{Form::text('birthdate',isset($profiles->birthdate)?$profiles->birthdate:null, array('class' => 'datepicker','placeholder'=>Lang::get('formAccount.dateBirth'),'data-dateformat'=>'yy/mm/dd'))}}
                                                </label>{{$errors->first('birthdate', '<span class="error">:message</span>')}} 
                                            </section>
                                        </div>  
                                         <div class="row">
                                           <section class="col col-6">
                                                <label class="input"> <i class="icon-prepend fa fa-phone"></i>
                                                    {{Form::text('fax',isset($profiles->fax)?$profiles->fax:null, array('placeholder' => 'Fax'))}}
                                                </label>
                                            </section>
                                        </div>  
                                    </fieldset>

                                    <header>{{Lang::get('formAccount.address')}}</header>
                                    <fieldset>
                                    <div class="row">

                                            <section class="col col-6">
                                                <label class="label">{{Lang::get('formAccount.country')}}</label>
                                                <label class="input">
                                                    {{Form::text('country',isset($profiles->country)?$profiles->country:null, array('placeholder' => Lang::get('formAccount.country')))}}
                                                </label>{{$errors->first('country', '<span class="error">:message</span>')}}
                                            </section>


                                            <section class="col col-6">
                                                <label class="label">{{Lang::get('formAccount.city')}}</label>
                                                <label class="input">
                                                    {{Form::text('city',isset($profiles->city)?$profiles->city:null, array('placeholder' => Lang::get('formAccount.city')))}}
                                                </label>{{$errors->first('city', '<span class="error">:message</span>')}}
                                            </section>
                                        </div>
                                        <div class="row">

                                            <section class="col col-6">
                                                <label class="label">{{Lang::get('formAccount.state')}}</label>
                                                <label class="input">
                                                    {{Form::text('state',isset($profiles->state)?$profiles->state:null, array('placeholder' => Lang::get('formAccount.state')))}}
                                                </label>{{$errors->first('state', '<span class="error">:message</span>')}}
                                            </section>

                                            <section class="col col-6">
                                                <label class="label">{{Lang::get('formAccount.zip_code')}}</label>
                                                <label class="input">
                                                    {{Form::text('zip_code',isset($profiles->zip_code)?$profiles->zip_code:null, array('placeholder' => Lang::get('formAccount.zip_code')))}}
                                                </label>{{$errors->first('zip_code', '<span class="error">:message</span>')}}
                                            </section>
                                        </div>

                                        <section>
                                            <label for="address2" class="input"><i>{{Lang::get('formAccount.address')}}</i>
                                                {{Form::text('address',isset($profiles->address)?$profiles->address:null, array('placeholder' =>  Lang::get('formAccount.address')))}}
                                            </label>{{$errors->first('address', '<span class="error">:message</span>')}}
                                        </section>
                                    </fieldset>

                                    <footer>
                                        {{ HTML::link('user/',Lang::get('formAccount.cancel'),array('class' => 'btn btn-default')) }}
                                        {{Form::submit(Lang::get('formAccount.save'),array('class'=>'btn btn-primary'))}}
                                    </footer>
                                    <div id='valSitePerm'></div>
                                {{Form::close()}}
                            </div>
                    </div>
            </div>
         </article> 

    <article class="col-sm-12 col-md-12 col-lg-4">
        <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-cogs"></i> </span>
                    <h2>{{Lang::get('formAccount.account_setting')}}</h2>                        
                </header>
                            
                <div>          
                        <div class="widget-body no-padding">

                                {{Form::open(array('class'=>'smart-form','id'=>'order-form','novalidate'=>'novalidate'))}}
                                        <div id='tableAccountSetting'> 
                                        <fieldset>
                                        @if (Session::has('msg'))
                                            {{ Form::hidden('', Session::get('inputCheck'), array('id' => 'gender')) }}
                                                <div class="alert alert-info" style='text-align: center'>{{Lang::get('formAccount.msg_account')}}</div>
                                        @endif
                                        
                                            <div class="row">
                                                <section class="col col-10">
                                                    <label class="label">{{Lang::get('formAccount.sites')}}</label>
                                                    <label class="select">
                                                        {{ Form::select('selectSite', $sites, null, ['id' => 'selectSite']) }}<i></i> 
                                                    </label>
                                                </section>
                                            </div>
                                            <div class="row">
                                                <section class="col col-10">
                                                    <label class="label">Roles</label>
                                                    <label class="select select-multiple">
                                                    {{ Form::select('selectRol[]',array(), null, ['id' => 'selectRol','class' => 'custom-scroll','multiple']) }}
                                                    </label>
                                                </section>
                                            </div>
                                            <div class="row">
                                                <section class="col col-10">
                                                    {{ Form::button(Lang::get('formAccount.add_permission'), array('class' => 'btn btn-sm btn-success','id' => 'addPermission')) }}    
                                                </section>
                                            </div>
                                        
                                        </fieldset>
                                        </div>
                                           @if(!isset($perfilPermission)) 
                                            <div id='CurrentPermission'>


                                                <fieldset >
                                                    <p class="alert alert-info">
                                                        <i class="fa fa-cogs"></i></i><strong>{{Lang::get('formAccount.current_permission')}}</strong> 
                                                    </p>
                                                    <div class="row">
                                                        <section class="col col-lg-12">
                                                                    <table id='tablePermNew' class='table'></table>     
                                                        </section>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        @endif
                                    
                                    {{Form::close()}}

                                    @if(isset($perfilPermission))

                                        @if ($userPermissionRoles['view'])
    
                                           {{Form::open(array('method' => 'GET','class'=>'smart-form formDelete','id' => 'order-form','novalidate'=>'novalidate'))}} 
                                               <div>
                                                    <fieldset >
                                                        <p class="alert alert-info">
                                                            <i class="fa fa-cogs"></i></i><strong>{{Lang::get('formAccount.current_permission')}}</strong> 

                                                            @if ($userPermissionRoles['update'])
                                                                {{Form::button(Lang::get('formAccount.edit_permission'),array('id'=>'editPerm','class'=>'btn btn-success btn-xs pull-right'))}}
                                                            @endif
                                                        </p>
                                                    
                                                            <div class="row">
                                                                <section class="col col-lg-12">
                                                                    
                                                                        <table id='tablePerm' class='table'></table>
                                                                    
                                                                </section>
                                                            </div>
                                                       
                                                        
                                                    </fieldset>
                                                </div>
                                            {{Form::close()}}  
                                        @endif   
                                    @endif

                                    {{ Form::hidden('', isset($perfilPermission)?$perfilPermission:null, array('id' => 'perfilPermission')) }}
                                       

                                
                        </div>
                </div>
        </div>
    </article>

    </div>
@endif

@stop


@section('scripts')
 @parent

    {{ HTML::script("js/plugin/select2/select2.min.js") }}
    {{ HTML::script('js/contest/formAccount.js') }}

    
@stop