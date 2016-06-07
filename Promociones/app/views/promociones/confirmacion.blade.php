@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="main-form">
            <h2>{{Lang::get('promociones.formTitle')}}</h2>
                {{Form::open(array('url'=>'canal5/'.$short_name."/confirm-data",'id'=>'contact-form-confirm','method' => 'post'))}}

                    


                    <div class="form-box">
                        {{Form::label('nombres',Lang::get('promociones.formName'))}}
                        <span class="span"></span>
                        {{Form::text('nombres',(Session::has("user.firstname"))?Session::get("user.firstname"):"",array('placeholder'=>Lang::get('promociones.formName'),'data-requiere'=>'true','data-format'=>'text','data-null'=>Lang::get('promociones.formNameMsgNull'),'id'=>'nombres'))}}
                    </div>
                    <div class="form-box">
                        {{Form::label('apellidos',Lang::get('promociones.formLastname'))}}
                        <span class="span"></span>
                        {{Form::text('apellidos',(Session::has("user.lastname"))?Session::get("user.lastname"):"",array('placeholder'=>Lang::get('promociones.formLastname'),'data-requiere'=>'true','data-format'=>'text','data-null'=>Lang::get('promociones.formLastameMsgNull')))}}
                    </div>

                    @if(is_null(Session::get("user.email")) || Session::get("user.email")=="")
                    <div class="form-box">
                        {{Form::label('email',Lang::get('promociones.formEmail'))}}
                        <span class="span"></span>
                        {{Form::text('email',"",array('placeholder'=>Lang::get('promociones.formEmail'),'data-requiere'=>'true','data-invalid'=>Lang::get('promociones.invalidEmail'),'data-format'=>'email','data-null'=>Lang::get('promociones.formEmailMsgNull'),'id'=>'email'))}}
                    </div>
                    @endif
                    
                    <div class="form-box-50 content-radio">
                        {{Form::label('genero',Lang::get('promociones.formGender'))}}
                        <span class="span"></span>
                        <div class="radio">
                            {{Form::radio('genero','male',(Session::has("user.gender") && Session::get("user.gender")=="male")?true:false,array('data-requiere'=>'true','data-format'=>'masculino','data-null'=>Lang::get('promociones.formGenderMsgNull'),'id'=>'masculino'))}}
                            <span>{{Lang::get('promociones.formGenderM')}}</span>
                            {{Form::radio('genero','female',(Session::has("user.gender") && Session::get("user.gender")=="female")?true:false,array('data-requiere'=>'true','data-format'=>'femenino','data-null'=>Lang::get('promociones.formGenderMsgNull')))}}
                            <span>{{Lang::get('promociones.formGenderF')}}</span>
                        </div>
                    </div>
                    <div class="form-box-50">
                        {{Form::label('date',Lang::get('promociones.formBirthDate'))}}
                        <span class="span"></span>
                        {{Form::text('date',(!is_null(Session::get("user.birthyear")) && Session::get("user.birthyear")!="" && Session::get("user.birthyear")!="0" && Session::get("user.birthyear")!=0 )?Session::get("user.birthday")."/".Session::get("user.birthmonth")."/".Session::get("user.birthyear"):Lang::get('promociones.formDate'),array('placeholder'=>Lang::get('promociones.formDate'),'data-requiere'=>'true','data-format'=>'date','data-invalid'=>Lang::get('promociones.invalidDate'),'data-null'=>Lang::get('promociones.formDateMsgNull')))}}
                        <div class="btn" id="btn-date">
                            <i class="c5-calendario"></i>
                        </div>
                    </div>
                    <div class="form-box-100">
                        {{Form::label('pais',Lang::get('promociones.formPais'))}}
                        <span class="span"></span>
                        {{Form::select('pais', Config::get('paises'), '',array('data-requiere'=>'true','data-format'=>'pais','data-null'=>Lang::get('promociones.formPaisMsgNull')))}}
                        <div class="btn" id="btn-pais">
                            <i class="c5-abajo"></i>
                        </div>
                    </div>
                    <div class="form-box-100" id='estadoNone'>
                        {{Form::label('estados',Lang::get('promociones.formEstado'))}}
                        <span class="span"></span>
                         {{Form::select('estados', Config::get('estados'), '',array('data-requiere'=>'true','data-format'=>'pais','data-null'=>Lang::get('promociones.formEstadoMsgNull')))}}
                        <div class="btn" id="btn-estado">
                            <i class="c5-abajo"></i>
                        </div>
                    </div>
                    <div class="form-box-50-border cleared">
                        {{Form::label('tel',Lang::get('promociones.formTel'))}}
                        <span class="span"></span>
                         {{Form::text('tel','',array('placeholder'=>Lang::get('promociones.formPLaceTel'),'data-requiere'=>'true','data-format'=>'tel','data-invalid'=>Lang::get('promociones.invalidTel'),'data-null'=>Lang::get('promociones.formTelMsgNull')))}}
                    </div>
                    <div class="form-box-100 check">
                        <div class="checkbox">
                        {{Form::checkbox('condiciones', '',false,array('id'=>'condiciones','data-requiere'=>'true','data-format'=>'bases','data-null'=>Lang::get('promociones.formBaseCondMsgNull')))}}Acepto las 
                        {{ HTML::link('/canal5/'.$short_name.'/bases-concurso', Lang::get('promociones.formBaseCond'),array("target"=>"_blank")) }}
                        <p class="span1"></p></div>
                        <div class="checkbox">
                        {{Form::checkbox('aviso', '',false,array('id'=>'aviso','data-requiere'=>'true','data-format'=>'privacidad','data-null'=>Lang::get('promociones.formAvsPrivMsgNull')))}}
                        {{ HTML::link('/canal5/'.$short_name.'/aviso-privacidad', Lang::get('promociones.formAvsPriv'),array("target"=>"_blank")) }}
                        <p class="span2"></p></div>
                    </div>
                    <div class="form-box-100-no-margin">    
                        {{Form::submit('CONFIRMAR',array('name'=>'confirmar','id'=>'confirmar','class'=>'btn-confirmar'))}}
                    </div>
            {{Form::close()}}
        </div>
    </article>
   	
@stop

@section('scripts')
    @parent
    <script type="text/javascript">

       $("#pais").change(function(){
            if($(this).val()!='MX') {
                $("#estadoNone").hide();
                $("#estados").find('option:selected').removeAttr("selected");
                $('#estados option[value=otro]').attr('selected',true);
            }else{
                 $("#estadoNone").show();
            }
        });
    </script>
@stop