@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

	<article class="left-container">
        <div class="pregunta-container main-form">

            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>
            
            {{Form::open(array('url'=>'canal-5/'.$short_name."/save-quizz",'id'=>'formQuizz','method' => 'post'))}}                                      
                
                @foreach($data as $dat)

                    {{ $field = ''}}
                    {{ $error = ''}}
                                                      
                    <h3><br />{{$dat['questions']->questionText}}</h3>                    

                    @if($dat['questions']->img!='')
                        {{ html_entity_decode(HTML::image($dat['questions']->img, "",['width'=>'300px', 'class'=>'img-responsive'])) }}                            
                    @endif                    
                    <!--<div>Tipo:: {{$dat['questions']->questionType}}</div>-->                
                    <div><br />
                    @if($dat['questions']->questionType=='radio')
                        @foreach($dat['options'] as $option)

                            {{Form::radio($dat['questions']->id.'_radio',$option->id, false,array('id'=>'radio'.$option->id,'placeholder'=>Lang::get('promociones.pregPlaceName'),'data-requiere'=>'true','maxlength'=>"200",'data-format'=>'text','data-null'=>Lang::get('promociones.pregMsgNull')))}}
                            {{Form::label('radio'.$option->id, $option->text)}}

                        @endforeach
                    @endif

                       
                    @if($dat['questions']->questionType=='checkbox')
                        Maximo: <span class="{{'max_'.$dat['questions']->id}}">{{$dat['questions']->numElemetMaxSel}}</span>
                        <br />
                        @foreach($dat['options'] as $option)
                                                        
                            {{Form::checkbox($dat['questions']->id.'_checkbox[]',$option->id, false, array('id'=>'checkbox'.$option->id,'placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','maxlength'=>"200",'data-format'=>'text','data-null'=>Lang::get('promociones.pregMsgNull')))}}
                            {{Form::label('checkbox'.$option->id, $option->text)}}

                        @endforeach
                    @endif    

                    @if($dat['questions']->questionType=='imagen')                        
                        <br />
                        @foreach($dat['options'] as $option)
                        <div>
                            {{ html_entity_decode(HTML::image($option->img, "",['width'=>'250px', 'class'=>'cambiaRadio img-responsive ', 'id'=>'image_'.$option->id])) }}                                                        
                            {{Form::radio($dat['questions']->id.'_radio',$option->id, false,array('id'=>'radio'.$option->id,'placeholder'=>$dat['questions']->placeholder,'class'=>'elementHide','data-requiere'=>'true','maxlength'=>"200",'data-format'=>'text','data-null'=>Lang::get('promociones.pregMsgNull')))}}
                            {{Form::label('radio'.$option->id, $option->text)}}
                        <div>    
                        @endforeach
                    @endif

                    @if($dat['questions']->questionType=='text')
                        <?php $field=$dat['questions']->id.'_textarea' ?>   
                        <?php $error=$dat['questions']->errorText?>   
                        {{Form::textarea($dat['questions']->id.'_textarea',"",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','data-invalid'=>Lang::get('promociones.invalidEmail'),'data-format'=>'textarea','data-null'=>Lang::get('promociones.formEmailMsgNull'),'id'=>'textarea'))}}
                         
                    @endif

                    @if($dat['questions']->questionType=='abierta')
                        <?php $field=$dat['questions']->id.'_text' ?>
                        <?php $error=$dat['questions']->errorText?>   

                        {{Form::text($dat['questions']->id.'_text',"",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','data-invalid'=>Lang::get('promociones.invalidEmail'),'data-format'=>'text','data-null'=>Lang::get('promociones.formEmailMsgNull'),'id'=>'text'))}}

                    @endif

                    @if($dat['questions']->questionType=='select')                                        

                        {{Form::select($dat['questions']->id.'_select', $dat['selectOptions'])}}

                    @endif

                    @if($errors->has())                         
                         @if ($errors->has($field))
                              <p class="errorInputs">{{$error}}</p>
                         @endif                         
                    @endif                    
                    </div>
                @endforeach
                <br />
                <br />    
                    {{Form::submit('',array('id'=>'enviarForm','class'=>'elementHide','name'=>'submit'))}}
                    {{Form::button('Enviar',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                
            {{Form::close()}}


        </div>                       
    </article>
    
    
@stop

<script src="/fasi/js/jquery.js"></script>

<script type="text/javascript">
$( document ).ready(function() {
    $("form input:checkbox" ).click(function(){
        var elementName = $(this).attr('name');

        var total = $("input[name='"+elementName+"']:checked").length;
        
        var eleMax = elementName.split('_');        
        var numEleMax = $(".max_"+eleMax[0]).html();    

        if(parseInt(total)>parseInt(numEleMax)){
            alert('solo es posible elegir ' + numEleMax + ' opciones');
            $(this).attr('checked', false);
        }    
    });

    $(".cambiaRadio").click(function(){
        var imgId = $(this).attr('id').replace('image_','');                             
        $("#radio"+imgId).click();
        var inputName = $("#radio"+imgId).attr('name');
        $("input[name='"+inputName+"']").prev().css('border','none');
        $("#radio"+imgId).prev().css('border','solid 3px #e70030');
        $("#radio"+imgId).prev().css('padding','3px');
    });
    

    $("#enviar").click(function(){
        var errors = 0 ;
        var inputs = new Array();        

        $(":input").each(function(){            
            inputs.push($(this).attr('name')) ;
        });        

        $(".errorInputs").remove();
        var nameInputs = jQuery.unique(inputs);

        $.each(nameInputs, function(ind, val){            
            if(val.indexOf('text')!=-1){
                if($("input[name='"+val+"']").val()=='' || $("input[name='"+val+"']").val()==' '){                    
                    $("input[name='"+val+"']").after('<div class="errorInputs">Ingresa un valor dentro del campo</div>');                
                    errors = 1;
                }    
            }            
            if(val.indexOf('textarea')!=-1){
                if($("textarea[name='"+val+"']").val()=='' || $("textarea[name='"+val+"']").val()==' '){                    
                    $("textarea[name='"+val+"']").after('<div class="errorInputs">Ingresa un valor dentro del campo</div>');                
                    errors = 1;
                }    
            } 

            if(val.indexOf('radio')!=-1 || val.indexOf('checkbox')!=-1 ){                
                if($("input[name='"+val+"']:checked").length==0){                    
                    $("input[name='"+val+"']").last().next().after('<div class="errorInputs">Selecciona alguna de las opciones anteriores</div>');                
                    errors = 1;
                }    
            }           

        });        

        if(errors==1){
            return false;
        }
        else{
            $("#enviarForm").click();
        }        
    });
});    
</script>
<style type="text/css">
    .elementHide{
        display: none;
    }
    .errorInputs{
        color: #E70030;
    }
</style>