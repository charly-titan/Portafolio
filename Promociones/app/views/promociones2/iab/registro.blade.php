@extends(Config::get( 'app.main_template' ).'.iab.main')

@section('content')
<style>
.lbl-error{
    color: red;
    font-size: 12px;
    font-weight: normal;
    display: none;
}
</style>
                <section class="slice"  id="contactSlice" >
                    <div class="container">
                        <div class="row">

                            <div class="col-sm-4">
                                <h4>Lorem ipsum</h4>
                                <address>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. <br>Expedita nisi doloremque quod quae nihil cumque dolore repudiandae <br>mollitia facere odio ipsa voluptatum eveniet eligendi tenetur<br> excepturi minima sed delectus molestias.
                                </address>

                            </div>
                             {{Form::open(array('url'=>'/ventas/registro','id'=>'contact-form-confirm','method' => 'post', 'name'=>'form_registro', 'onsubmit' => 'return form_validate.start()'))}}
                                <div class="col-sm-4"> 
                                    <div class="form-group">
                                        <label for="usrname">Nombre(s)</label>
                                        <input type="text" class="form-control" name="usrname" id="usrname" placeholder="Tu nombre"  title="Tu nombre" autocomplete="off"/>
                                        <label class="lbl-error" id="lbl_1">por favor, ingresa tu nombre</label>
                                        {{ $errors->first('usrname', '<div class="error">:message</div>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@televisa.com" autocomplete="off" />
                                        <label class="lbl-error" id="lbl_2">por favor, ingresa un email valido</label>
                                        {{ $errors->first('email', '<div class="error">:message</div>') }}
                                    </div>
                                    <div class="form-group">
                                        <label for="cargo">Cargo</label>
                                        <input name="cargo" id="cargo" class="form-control required" type="text" placeholder="Tu cargo" autocomplete="off" >
                                        <label class="lbl-error" id="lbl_3">por favor, ingresa tu cargo</label>
                                        {{ $errors->first('cargo', '<div class="error">:message</div>') }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="empresa">Empresa</label>
                                        <input type="text" name="empresa" id="empresa" class="form-control" placeholder="Tu empresa" autocomplete="off">
                                        <label class="lbl-error" id="lbl_4">por favor, ingresa tu empresa</label>
                                        {{ $errors->first('empresa', '<div class="error">:message</div>') }}
                                    </div>
                                    <fieldset class="clearfix securityCheck">
                                        <div class="form-group">
                                            <input id="terms" type="checkbox" name="terms">
                                            <label for="field_terms">Acepto <u>terminos y condiciones</u></label>
                                            <label class="lbl-error" id="lbl_5">por favor, acepta los terminos</label>
                                        </div>
                                    </fieldset>
                                        <input id="codigo" type="hidden" name="codigo" value='{{$codigo}}'>
                                </div>                        
                                <div class="col-md-8 col-md-offset-4">
                                    <div class="result"></div>
                                    <button name="submit" type="submit" class="btn btn-lg" id="submit"><i class="icon-ok"></i> Submit</button>
                                </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </section>

                <!-- content -->
@stop

@section('scripts')
    @parent
    <script type="text/javascript">
    
    var form_validate = {
        start : function(){
            txt_usrname = document.form_registro.usrname.value;
            txt_email = document.form_registro.email.value;
            txt_cargo = document.form_registro.cargo.value;
            txt_empresa = document.form_registro.empresa.value;
            txt_terms = document.form_registro.terms;
            $('.lbl-error').hide();
            if(txt_usrname == "" || /^\s+$/.test(txt_usrname)){
                document.getElementById('lbl_1').style.display = "block";
                document.form_registro.usrname.focus();
                return false;
            }else if(this.validate_email(txt_email)){
                document.getElementById('lbl_2').style.display = "block";
                return false;
            }else if(txt_cargo == "" || /^\s+$/.test(txt_cargo)){
                document.getElementById('lbl_3').style.display = "block";
                document.form_registro.cargo.focus();
                return false;
            }else if(txt_empresa == "" || /^\s+$/.test(txt_empresa)){
                document.getElementById('lbl_4').style.display = "block";
                document.form_registro.empresa.focus();
                return false;
            }else if(!txt_terms.checked){
                document.getElementById('lbl_5').style.display = "block";
                return false;
            }else{
                return true;
            }
        },
        validate_email : function(email){
             expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if ( !expr.test(email) ){
                return true;
            }else{ 
                return false;
            }
        }
    }
    </script>
@stop
