@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

@if ($userPermission["view"])
{{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}    
        <div class="tab-pane active">                                       
            <br>
            <legend></legend>

            <div class="well well-sm well-light">
            <div id="tabs">
                <ul>
                    <li>
                        <a href="#tabs-a">{{Lang::get('contest.login')}}</a>
                    </li>
                    @if ($contestType=="frase")
                    <li>
                        <a href="#tabs-b">{{Lang::get('contest.phrase')}}</a>
                    </li>
                    @endif
                    <li>
                        <a href="#tabs-c">{{Lang::get('contest.previous')}}</a>
                    </li>
                    <li>
                        <a href="#tabs-d">{{Lang::get('contest.thanks')}}</a>
                    </li>
                    <li>
                        <a href="#tabs-e">{{Lang::get('contest.waiting')}}</a>
                    </li>
                    <li>
                        <a href="#tabs-f">{{Lang::get('contest.closure')}}</a>
                    </li>
                    <li>
                        <a href="#tabs-g">{{Lang::get('contest.img')}}</a>
                    </li>
                    @if ($cssPermission["update"])
                    <li>
                        <a href="#tabs-i">CSS</a>
                    </li>
                    <li>
                        <a href="#tabs-j">Opcionales</a>
                    </li>
                    

                    @endif
                </ul>

                {{Form::open(array('url'=>'/contest/text','method'=>'POST','class'=>'smart-form','name'=>'save','files' => true))}}

                        <div id="tabs-a">
                            <fieldset>
                                                
                                <section>
                                    {{Form::label('titleMechanical',Lang::get('contest.titleText'))}}
                                    <label class="input">
                                        {{Form::text('titleMechanical',isset($properties->titleMechanical)?$properties->titleMechanical:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titleText')))}}
                                    </label>
                                </section>
                                                                                
                                <section>
                                    {{Form::label('textMechanical',Lang::get('contest.text'),['class'=>'label'])}}
                                    {{ Form::textarea('textMechanical', isset($properties->textMechanical)?$properties->textMechanical:null, ['class' => 'editors','id'=>'textMechanical']) }}
                                </section>
                                  
                            </fieldset>           
                        </div>

                        @if ($contestType=="frase")
                        <div id="tabs-b">
                           <fieldset>
                                <section>
                                    {{Form::label('textPhrase',Lang::get('contest.instructionsText'),['class'=>'label'])}}
                                    {{ Form::textarea('textPhrase', isset($properties->textPhrase)?$properties->textPhrase:null, ['class' => 'editors','id'=>'textPhrase']) }}
                                </section>
                           </fieldset>
                        </div>
                        @endif

                        <div id="tabs-c">
                            <section>
                                {{Form::label('titlePrevious',Lang::get('contest.titleText'),['class'=>'label'])}}
                                <label class="input">
                                    {{Form::text('titlePrevious',isset($properties->titlePrevious)?$properties->titlePrevious:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titleText')))}}
                                </label>
                            </section>
                                                                                
                            <section>
                                {{Form::label('textPrevious',Lang::get('contest.text'),['class'=>'label'])}}
                                {{ Form::textarea('textPrevious', isset($properties->textPrevious)?$properties->textPrevious:null, ['class' => 'editors','id'=>'textPrevious']) }}
                            </section>

                            <div class="row">
                                <section class="col col-6">
                                    {{Form::label('urlPrevious',Lang::get('contest.url'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('urlPrevious',isset($properties->urlPrevious)?$properties->urlPrevious:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.url')))}}
                                    </label>
                                </section>

                                <section class="col col-6">
                                    {{Form::label('nameUrlPrevious',Lang::get('contest.nameUrl'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('nameUrlPrevious',isset($properties->nameUrlPrevious)?$properties->nameUrlPrevious:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.nameUrl')))}}
                                    </label>
                                </section>
                            </div>
                        </div>

                        <div id="tabs-d">
                            <section>
                                {{Form::label('titleThanks',Lang::get('contest.titleText'),['class'=>'label'])}}
                                <label class="input">
                                    {{Form::text('titleThanks',isset($properties->titleThanks)?$properties->titleThanks:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titleText')))}}
                                </label>
                            </section>
                                                                                
                            <section>
                                {{Form::label('textThanks',Lang::get('contest.text'),['class'=>'label'])}}
                                {{ Form::textarea('textThanks', isset($properties->textThanks)?$properties->textThanks:null, ['class' => 'editors','id'=>'textThanks']) }}
                            </section>

                            <div class="row">
                                <section class="col col-6">
                                    {{Form::label('urlThanks',Lang::get('contest.url'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('urlThanks',isset($properties->urlThanks)?$properties->urlThanks:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.url')))}}
                                    </label>
                                </section>

                                <section class="col col-6">
                                    {{Form::label('nameUrlThanks',Lang::get('contest.nameUrl'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('nameUrlThanks',isset($properties->nameUrlThanks)?$properties->nameUrlThanks:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.nameUrl')))}}
                                    </label>
                                </section>
                            </div>
                        </div>

                        <div id="tabs-e">
                            <section>
                                {{Form::label('titleWaiting',Lang::get('contest.titleText'),['class'=>'label'])}}
                                <label class="input">
                                    {{Form::text('titleWaiting',isset($properties->titleWaiting)?$properties->titleWaiting:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titleText')))}}
                                </label>
                            </section>
                                                                                
                            <section>
                                {{Form::label('textWaiting',Lang::get('contest.text'),['class'=>'label'])}}
                                {{ Form::textarea('textWaiting', isset($properties->textWaiting)?$properties->textWaiting:null, ['class' => 'editors','id'=>'textWaiting']) }}
                            </section>

                            <div class="row">
                                <section class="col col-6">
                                    {{Form::label('urlWaiting',Lang::get('contest.url'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('urlWaiting',isset($properties->urlWaiting)?$properties->urlWaiting:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.url')))}}
                                    </label>
                                </section>

                                <section class="col col-6">
                                    {{Form::label('nameUrlWaiting',Lang::get('contest.nameUrl'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('nameUrlWaiting',isset($properties->nameUrlWaiting)?$properties->nameUrlWaiting:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.nameUrl')))}}
                                    </label>
                                </section>
                            </div>
                        </div>

                        <div id="tabs-f">
                            <section>
                                {{Form::label('titleClosure',Lang::get('contest.titleText'),['class'=>'label'])}}
                                <label class="input">
                                    {{Form::text('titleClosure',isset($properties->titleClosure)?$properties->titleClosure:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titleText')))}}
                                </label>
                            </section>
                                                                                
                            <section>
                                {{Form::label('textClosure',Lang::get('contest.text'),['class'=>'label'])}}
                                {{ Form::textarea('textClosure', isset($properties->textClosure)?$properties->textClosure:null, ['class' => 'editors','id'=>'textClosure']) }}
                            </section>

                            <div class="row">
                                <section class="col col-6">
                                    {{Form::label('urlClosure',Lang::get('contest.url'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('urlClosure',isset($properties->urlClosure)?$properties->urlClosure:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.url')))}}
                                    </label>
                                </section>

                                <section class="col col-6">
                                    {{Form::label('nameUrlClosure',Lang::get('contest.nameUrl'),['class'=>'label'])}}
                                    <label class="input">
                                        {{Form::text('nameUrlClosure',isset($properties->nameUrlClosure)?$properties->nameUrlClosure:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.nameUrl')))}}
                                    </label>
                                </section>
                            </div>
                        </div>
                        <div id="tabs-i">
                        @if ($cssPermission["update"])
                            <section>
                                <label class="label">CCS GLOBAL</label>
                                <div class="input input-file">
                                    <span class="button">{{Form::file('fileCss', $attributes = array('accept'=>'.css','onchange'=>'this.parentNode.nextSibling.value = this.value'))}}{{Lang::get('contest.browse')}}</span>{{Form::text('',isset($properties->UrlCss)?'canal-5-promociones-global.css':'',array('placeholder'=>Lang::get('contest.includeFile')))}}
                                </div>
                            </section>
                        @endif
                        </div>
                        <div id="tabs-j">
                        @if ($cssPermission["update"])
                            <section>
                                <div class="row">
                                    <section class="col col-3">
                                        <label>Color header</label>
                                        <label class="input">
                                            {{Form::text('colorHeader',isset($properties->colorHeader)?$properties->colorHeader:null,array('class'=>'input-sm','id'=>'rgbpicker-1','data-color-format'=>'rgba','placeholder'=> ''))}}
                                        </label>
                                    </section>

                                    <section class="col col-3">
                                        <label>Color titulo header</label>
                                        <label class="input">
                                            {{Form::text('colorTitleHead',isset($properties->colorTitleHead)?$properties->colorTitleHead:null,array('class'=>'input-sm','id'=>'rgbpicker-2','data-color-format'=>'rgba','placeholder'=> '' ))}}
                                        </label>
                                    </section>
                                    
                                    <section class="col col-3">
                                        <label>Color stage</label>
                                        <label class="input">
                                            {{Form::text('colorStage',isset($properties->colorStage)?$properties->colorStage:null,array('class'=>'input-sm','id'=>'rgbpicker-5','data-color-format'=>'rgba','placeholder'=> '' ))}}
                                        </label>
                                    </section>
                                    
                                    <section class="col col-3">
                                    <label>Color Letra</label>
                                    <label class="input">
                                        {{Form::text('colorFont',isset($properties->colorFont)?$properties->colorFont:null,array('class'=>'input-sm','id'=>'rgbpicker-3','data-color-format'=>'rgba','placeholder'=> ''))}}
                                    </label>
                                    </section>

                                    <section class="col col-3">
                                        <label>Color footer</label>
                                        <label class="input">
                                            {{Form::text('colorFooter',isset($properties->colorFooter)?$properties->colorFooter:null,array('class'=>'input-sm','id'=>'rgbpicker-4','data-color-format'=>'rgba','placeholder'=> '' ))}}
                                        </label>
                                    </section>
                                </div>
                            </section>
                        @endif
                        </div>
                        <div id="tabs-g">
                        
                @if ($userPermission["update"])

                            <section>
                                    {{Form::label('titlePleca',Lang::get('contest.titleText'))}}
                                    <label class="input">
                                        {{Form::text('titlePleca',isset($properties->titlePleca)?$properties->titlePleca:null,array('class'=>'input-sm','placeholder'=> Lang::get('contest.titlePleca')))}}
                                    </label>
                            </section>
                            {{Form::hidden('UrlImgLogo',isset($properties->UrlImgLogo)? $properties->UrlImgLogo:null,array('id'=>'logoImg'))}}
                            {{Form::hidden('UrlImgStage',isset($properties->UrlImgStage)? $properties->UrlImgStage:null,array('id'=>'stageImg'))}}
                            {{Form::hidden('UrlImg1Versus',isset($properties->UrlImg1Versus)? $properties->UrlImg1Versus:null,array('id'=>'1VersusImg'))}}
                            {{Form::hidden('UrlImg2Versus',isset($properties->UrlImg2Versus)? $properties->UrlImg2Versus:null,array('id'=>'2VersusImg'))}}
            {{Form::close()}}

        

                @if(Session::has('SessionImg'))
                            
                            <label class="label">Logo</label>   
                            <div class=" imgDropzone "> 
                                <div class="box1 col-md-6 filtered">   
                                        {{Form::open(array('url'=>'/contest/uploadimg/logo','method'=>'POST','class'=>'dropzone updDropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}    
                                </div>
                                 <div class="box2 col-md-6 imgDropzone" id='imgLoadLogo'></div>
                            </div>
                            <br>
                            <div id="stage">
                                <label class="label">Stage</label>

                                <div class=" imgDropzone "> 
                                    <div class="box1 col-md-6 filtered">   
                                            {{Form::open(array('url'=>'/contest/uploadimg/stage','method'=>'POST','class'=>'dropzone updDropzone','id'=>'my-dropzone','file'=>true))}}
                                                {{Form::close()}}    
                                    </div>
                                     <div class="box2 col-md-6 imgDropzone" id='imgLoadStage'></div>
                                </div>
                            </div>
                            <br>
                        @if ($contestType=="versus")                            
                            <section class="smart-form">
                                <label class="label">{{Lang::get('contest.versusTextTwo')}}</label>
                                <div class="inline-group">
                                    <label class="radio">
                                        {{Form::checkbox('versusOptionTwo',true,false,['id'=>'versusOptionTwo'])}}
                                        <i></i>{{Lang::get('contest.versusOptionTwo')}}</label>
                                </div>
                            </section> 
                            <div id="versus2" style="display:none;">
                                <label class="label">{{Lang::get('contest.imageOne')}}</label>   
                                <div class=" imgDropzone "> 
                                    <div class="box1 col-md-6 filtered">   
                                            {{Form::open(array('url'=>'/contest/uploadimg/1Versus','method'=>'POST','class'=>'dropzone updDropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}    
                                    </div>
                                    <div class="box2 col-md-6 imgDropzone" id='imgLoad1Versus'></div>
                                </div>
                                <br>

                                <label class="label">{{Lang::get('contest.imageTwo')}}</label>
                                <div class=" imgDropzone "> 
                                    <div class="box1 col-md-6 filtered">   
                                            {{Form::open(array('url'=>'/contest/uploadimg/2Versus','method'=>'POST','class'=>'dropzone updDropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}    
                                    </div>
                                    <div class="box2 col-md-6 imgDropzone" id='imgLoad2Versus'></div>
                                </div>
                            </div>
                        @endif

                            

                @else

                            <section>
                                 <label for="">Logo</label>
                                        <div class="widget-body">
                                            {{Form::open(array('url'=>'/contest/uploadimg/logo','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}
                                        </div>
                            </section>
                            <section>
                                 <label for="">Stage</label>
                                        <div class="widget-body">
                                            {{Form::open(array('url'=>'/contest/uploadimg/stage','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}
                                        </div>
                            </section>
                            <br>
                        @if ($contestType=="versus")
                            <section class="smart-form">
                                <label class="label">{{Lang::get('contest.versusTextTwo')}}</label>
                                <div class="inline-group">
                                    <label class="radio">
                                        {{Form::checkbox('versusOptionTwo',true,false,['id'=>'versusOptionTwo'])}}
                                        <i></i>{{Lang::get('contest.versusOptionTwo')}}</label>
                                </div>
                            </section> 
                            <section>
                                 <label for="">{{Lang::get('contest.imageOne')}}</label>
                                        <div class="widget-body">
                                            {{Form::open(array('url'=>'/contest/uploadimg/1Versus','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}
                                        </div>
                            </section>
                            <section>
                                 <label for="">{{Lang::get('contest.imageTwo')}}</label>
                                        <div class="widget-body">
                                            {{Form::open(array('url'=>'/contest/uploadimg/2Versus','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                                            {{Form::close()}}
                                        </div>
                            </section>
                        @endif


                @endif
        
                        </div>
         @endif        
            </div>

        </div>
       
            <div class="form-actions">
                @if ($userPermission["update"])
                    {{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-sm btn-primary','onclick'=>'save.submit();stopRKey()'))}}
                                                                
                    {{ HTML::linkAction('ContestController@getMetric', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-sm btn-primary pull-left')) }}
                    
                @else
                    {{ HTML::linkAction('QuestionController@getQuiz', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-sm btn-primary')) }}
                                                            
                    {{ HTML::linkAction('ContestController@getMetric', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-sm btn-primary pull-left')) }}
                @endif
            </div>
        
    </div>  

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getMetric', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-sm btn-primary pull-left')) }}
                {{ HTML::linkAction('QuestionController@getQuiz', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
        </div>
    </div>

@endif

@stop