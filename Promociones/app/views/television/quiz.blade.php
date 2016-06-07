@extends(Config::get( 'app.main_template' ).'.main')

<style>
    .dropzone{min-height: 100px;}
    /*#demo .dropzone .dz-preview{font-size: 12px;} */
    img {max-width: 100%;max-height: 100%;}
    @media all and (max-width: 1000px){
        img{
        width:800px;
        height: 250px;
        }
    }

    #upimg{max-width: 650px;}
    .checkbox {padding: 1em;}
    
    
</style>

@section('content')

@if(isset($info->properties['colorFont']))
<style>
.fcontainer-img .box-img .red{background: {{$info->properties['colorFont']}}!important; }
div.respuestas{ background: {{$info->properties['colorFont']}}!important; }
input[type="submit"].btn-confirmar{background: {{$info->properties['colorFont']}}!important;}
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

            {{Form::open(array('url'=>'/'.(isset($info->properties['channel'])?$info->properties['channel']:'').'/'.$short_name."/save-quizz",'id'=>'contact-form-confirm','method' => 'post'))}}
                
                @foreach($data as $dat)

                    @if($dat['questions']->img!='')
                        {{ html_entity_decode(HTML::image($dat['questions']->img, "",['width'=>'300px', 'class'=>'img-responsive'])) }}                            
                    @endif
                    
                    
                    @if($dat['questions']->questionType=='radio')
                        <div class="box-radio">
                            <h3>{{$dat['questions']->questionText}}</h3>
                            <p class="msg">{{$dat['questions']->errorText}}</p>
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
                                {{$errors->first($dat['questions']->id.'_text', '<p class="msg" style="display: block;">'.$dat['questions']->errorText.'</p>') }}
                                @if($dat['questions']->request=='1')
                                    {{Form::textarea($dat['questions']->id.'_text',"",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'true','data-format'=>'text','id'=>'respuesta4'))}}
                                @else
                                    {{Form::textarea($dat['questions']->id.'_text',$dat['questions']->placeholder,array('placeholder'=>$dat['questions']->placeholder,'data-format'=>'text','id'=>'respuesta4'))}}
                                @endif
                            </div>
                        </div>

                    @endif

                    @if($dat['questions']->questionType=='select')
                        <div id="vselect" class="fcontainer">
                            <div class="form-box">
                                <label>{{$dat['questions']->questionText}}</label>
                                <p class="msg">{{$dat['questions']->errorText}}</p>
                                {{Form::select($dat['questions']->id.'_select', $dat['selectOptions'])}}
                            </div>
                        </div>                                        
                    @endif


                    @if($dat['questions']->questionType=='imagen')                        
                        <div class="box-img-radio">
                            <h3 class="h16">{{$dat['questions']->questionText}}</h3>
                            <p class="msg">{{$dat['questions']->errorText}}</p>
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

                    @if($dat['questions']->questionType=='foto')
                    	<div id="vtext" class="fcontainer">
                    		<!--div class="descrip">
                                <p>¡Ya casi terminas!</p>
                            </div-->
                            <div class="form-box">
                                <h3>¡Ya casi terminas!</h3>
                                <p class="msg">{{$dat['questions']->errorText}}</p>
                                {{$errors->first($dat['questions']->id.'_foto', '<p class="msg" style="display: block;">'.$dat['questions']->errorText.'</p>') }}
                                {{Form::text($dat['questions']->id.'_foto',"0",array('placeholder'=>$dat['questions']->placeholder,'data-requiere'=>'false','data-format'=>'text','id'=>'urlImage', 'style'=>"display: none;"))}}
                            </div>
                            <div id="demo" class="dropzone">
								<span class="text-center">
								<span class="font-lg visible-xs-block visible-sm-block visible-lg-block">
								<span class="font-lg">
								<h4 class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i>{{$dat['questions']->questionText}}</h4>
								</span>
								</span>
								</span>
							</div>
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

    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/smartadmin-production-plugins.min.css') }}
    {{ HTML::style('css/smartadmin-rtl.min.css') }}
    {{ HTML::script("js/dropzone/dropzone.min.js") }}
                              

    <script>

    /************** DropZone *******************/
    Dropzone.autoDiscover = false;
    $("div#demo").dropzone({
       		url: '/'+'{{(isset($info->properties['channel'])?$info->properties['channel']:'')}}'+'/'+'{{$short_name}}'+'/uploadimg',
       		maxFiles: 1,
            paramName: "file",
            addRemoveLinks : true,
            //maxFilesize: 500,
            acceptedFiles: ".jpg, .jpeg, .gif, .png",
            dictDefaultMessage: '<h4 class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i></h4><span>&nbsp&nbsp<h4 class="text-center"> (O haz Click)</h4></span>',
            dictResponseError: 'Error al subir la foto!',
            method: 'post',
   			
            init: function() {
            this.on("success", function(file, responseText) {
                    $("#urlImage").val(responseText);
            });
            this.on("maxfilesexceeded", function(file){
                alert("Se permite solo una imagen");
                this.removeFile(file);
            });
            this.on("removedfile", function(file){
                    $("#urlImage").val("0");
                         
            });
          }
	});

    $(document).ready(function () {
    	
        $("#botonGuardar").click(function (){
            if( $("#urlImage").val() == "" ){
                alert("No hay imagen para guardar");
                return false;
            }
        });


        
    });
        
    </script>



@stop