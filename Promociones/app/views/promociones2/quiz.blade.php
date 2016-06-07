@extends(Config::get( 'app.main_template' ).'.main')

@section('content')

@if(isset($info->properties['colorFont']))
<style>
.fcontainer-img .box-img .red{background: {{$info->properties['colorHeader']}}!important; }
div.respuestas{ background: {{$info->properties['colorHeader']}}!important; }
input[type="submit"].btn-confirmar{background: {{$info->properties['colorHeader']}}!important;}
</style>
@endif
<div class="container">
	<article class="left-container">
        <div class="quiz-form">
            <h2 class="pregunta-titulo">{{Lang::get('promociones.preguntaTitulo',['name' => Session::get("user.firstname")])}}</h2>
            <h3>{{--isset($info->properties['descriptionContest'])?$info->properties['descriptionContest']:'';--}}</h3>
            <div class="descrip">
                <p>{{isset($info->properties['descriptionContest'])?$info->properties['descriptionContest']:'';}}</p>
            </div>

            {{Form::open(array('url'=>'canal-5/'.$short_name."/save-quizz",'id'=>'contact-form-confirm','method' => 'post'))}}
                
                @foreach($data as $dat)

                    
                    @if($dat['questions']->questionType=='radio')
                        <div class="box-radio">
                            <h3>{{$dat['questions']->questionText}}</h3>
                            <p class="msg">{{$dat['questions']->errorText}}</p>
                            @if($dat['questions']->img!='')
                                <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                            @endif
                            <div id="vradio" class="fcontainer">
                                @foreach($dat['options'] as $option)
                                    <div class="form-box">
                                        {{Form::radio($dat['questions']->id.'_radio',$option->id, false,array('id'=>'radio'.$option->id,'data-requiere'=>'true'))}}
                                        <span>{{$option->text}}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($dat['questions']->questionType=='checkbox')
                        <div class="box-check">
                            <h3>{{$dat['questions']->questionText}}</h3>
                            <p class="msg">{{$dat['questions']->errorText}}</p>
                            @if($dat['questions']->img!='')
                                <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                            @endif
                            Puedes seleccionar m&aacute;ximo: <span class="{{'max_'.$dat['questions']->id}}">{{$dat['questions']->numElemetMaxSel}}</span>
                            <div id="vcheck" class="fcontainer">
                                @foreach($dat['options'] as $option)
                                    <div class="form-box">
                                        {{Form::checkbox($dat['questions']->id.'_checkbox[]',$option->id, false, array('id'=>'check-'.$option->id,'data-requiere'=>'true'))}}
                                        <span>{{$option->text}}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif    

                    @if($dat['questions']->questionType=='text')
                        <div id="vtext" class="fcontainer">
                            <div class="form-box">
                                <label>{{$dat['questions']->questionText}}</label>
                                <p class="msg">{{$dat['questions']->errorText}}</p>
                                @if($dat['questions']->img!='')
                                    <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                    {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                                @endif
                                {{$errors->first($dat['questions']->id.'_textarea', '<p class="msg" style="display: block;">'.$dat['questions']->errorText.'</p>') }}
                                {{Form::text($dat['questions']->id.'_textarea',"",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','data-format'=>'text','id'=>'respuesta2'))}}
                            </div>
                        </div>
                         
                    @endif

                    @if($dat['questions']->questionType=='abierta')
                        <div id="varea" class="fcontainer">
                            <div class="form-box">
                                <label>{{$dat['questions']->questionText}}</label>
                                <p class="msg">{{$dat['questions']->errorText}}</p>
                                @if($dat['questions']->img!='')
                                    <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                    {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                                @endif 
                                {{$errors->first($dat['questions']->id.'_text', '<p class="msg" style="display: block;">'.$dat['questions']->errorText.'</p>') }}
                                {{Form::textarea($dat['questions']->id.'_text',"",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','data-format'=>'text','id'=>'respuesta4'))}}
                                
                            </div>
                        </div>

                    @endif

                    @if($dat['questions']->questionType=='select')
                        <div id="vselect" class="fcontainer">
                            <div class="form-box">
                                <label>{{$dat['questions']->questionText}}</label>
                                <p class="msg">{{$dat['questions']->errorText}}</p>
                                @if($dat['questions']->img!='')
                                    <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                    {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                                @endif
                                {{Form::select($dat['questions']->id.'_select', $dat['selectOptions'])}}
                            </div>
                        </div>                                        
                    @endif


                    @if($dat['questions']->questionType=='imagen')                        
                        <div class="box-img-radio">
                            <h3 class="h16">{{$dat['questions']->questionText}}</h3>
                            <p class="msg">{{$dat['questions']->errorText}}</p>
                            @if($dat['questions']->img!='')
                                <img src="{{$dat['questions']->img}}" class="img-responsive" width='300px'>
                                {{-- html_entity_decode(HTML::image($dat['questions']->img, "image",['width'=>'300px', 'class'=>'img-responsive'])) --}}                            
                            @endif
                            <div id="vimage" class="fcontainer-img"><div class="boxy-img"> 
                                @foreach($dat['options'] as $option)
                                    <div class="form-box-img">
                                        {{Form::radio($dat['questions']->id.'_radio',$option->id, false,array('id'=>'checks', 'data-requiere'=>'true'))}}
                                        <div class="box-img">
                                            <div class="radio-button">
                                                <img src="/img/felcha.svg" alt="" />
                                            </div>
                                            <div class="img">                                                        
                                                {{ html_entity_decode(HTML::image($option->img))}}
                                                <div class="respuestas" data-ellipsis="{{$option->text}}">{{$option->text}}</div>
                                                <div class="box-img-full">
                                                    <div class="box-respuestas-full red"></div>
                                                    <div class="respuestas-full">{{$option->text}}</div>
                                                </div>
                                                {{$option->img}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div></div>
                        </div>
                    @endif

                    
                    
                  
                @endforeach
                <div class="btn-send">    
                    {{Form::submit('Enviar',array('id'=>'enviar','class'=>'btn-confirmar','name'=>'enviar'))}}
                </div>
                
            {{Form::close()}}


        </div>                       
    </article>
    
    
@stop

@section('scripts')
    @parent

<script type="text/javascript">
$( document ).ready(function() {
    $("form input:checkbox" ).click(function(){
        var elementName = $(this).attr('name');

        var total = $("input[name='"+elementName+"']:checked").length;
        
        var eleMax = elementName.split('_');        
        var numEleMax = $(".max_"+eleMax[0]).html();    

        if(parseInt(total)>parseInt(numEleMax)){
            alert('Solo es posible elegir ' + numEleMax + ' opciones');
            $(this).attr('checked', false);
        }    
    });
/*
    $(".cambiaRadio").click(function(){
        var imgId = $(this).attr('id').replace('image_','');                             
        $("#radio"+imgId).click();
        var inputName = $("#radio"+imgId).attr('name');
        $("input[name='"+inputName+"']").prev().css('border','none');
        $("#radio"+imgId).prev().css('border','solid 3px #e70030');
        $("#radio"+imgId).prev().css('padding','3px');
    });
    

    /*$("#enviar").click(function(){
        var errors = 0 ;
        var inputs = new Array();        

        $(":input").each(function(){            
            inputs.push($(this).attr('name')) ;
        });        

        $(".errorInputs").remove();
        var nameInputs = jQuery.unique(inputs);

        /*$.each(nameInputs, function(ind, val){            
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
    });*/
});    


</script>

@stop