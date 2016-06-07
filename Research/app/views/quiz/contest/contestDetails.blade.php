@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

@if ($userPermission["view"])

    {{Form::open(array('url'=>'/contest/contestdate','method'=>'POST','name'=>'save'))}}
        {{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}    

        <div class="tab-pane active">                                       
            <br>
            <legend></legend>

            <div class="form-group">
                {{Form::label('titleContest',Lang::get('contest.title'))}}
                {{Form::text('titleContest',isset($properties->titleContest)? $properties->titleContest:null,array('class'=>'form-control input-md','placeholder'=> Lang::get('contest.title'), isset($properties->status_contests)?'readonly':'' ))}}
                {{$errors->first('titleContest', '<span class="error">:message</span>')}}
            </div>
            <div class="form-group">
                {{Form::label('nameContest',Lang::get('contest.name'))}}
                {{Form::text('nameContest',isset($properties->nameContest)? $properties->nameContest:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.name'),isset($properties->status_contests)?'readonly':''))}}
                {{$errors->first('nameContest','<span class="error">:message</span>')}}
            </div>

            <div class="form-group">
                {{Form::label('descriptionContest',Lang::get('contest.description'))}}
                {{Form::textarea('descriptionContest',isset($properties->descriptionContest)? $properties->descriptionContest:null,array('class'=>'form-control input-md custom-scroll','placeholder'=>Lang::get('contest.description'),'rows'=>3,'id'=>'descriptionContest',isset($properties->status_contests)?'readonly':''))}}
                {{$errors->first('descriptionContest','<span class="error">:message</span>')}}
            </div>

            <div class="form-group">
                {{Form::label('keywordContest',Lang::get('contest.keywords'))}}
                {{Form::text('keywordContest',isset($properties->keywordContest)? $properties->keywordContest:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.keywords'),isset($properties->status_contests)?'readonly':''))}}
                {{$errors->first('keywordContest','<span class="error">:message</span>')}}
            </div>




            <section>
                <label>URL's</label>
                                                                    
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">{{Config::get('app.urlContest')}}</span>
                                <span class="input-group-addon">
                                
                                    <select class="select2" name='channel' <?php isset($properties->status_contests)?(($properties->status_contests==1)?print('disabled'):''):''?>>
                                        <option></option>
                                        <option value='canal-5' name='' <?php isset($properties->channel)?(($properties->channel=='canal-5')?print('selected'):''):''?>>canal-5/</option>
                                        <option value='canal-2' name='' <?php isset($properties->channel)?(($properties->channel=='canal-2')?print('selected'):''):''?>>canal-2/</option>
                                        <option value='bandamax' name='' <?php isset($properties->channel)?(($properties->channel=='bandamax')?print('selected'):''):''?>>bandamax/</option>
                                        <option value='pepsi' name='' <?php isset($properties->channel)?(($properties->channel=='pepsi')?print('selected'):''):''?>>pepsi/</option>
                                        <option value='parodiando' name='' <?php isset($properties->channel)?(($properties->channel=='parodiando')?print('selected'):''):''?>>parodiando/</option>
                                        <option value='television' name='' <?php isset($properties->channel)?(($properties->channel=='television')?print('selected'):''):''?>>television/</option>
                                        <option value='ninos' name='' <?php isset($properties->channel)?(($properties->channel=='ninos')?print('selected'):''):''?>>ninos/</option>
                                    </select>
                                </span>
                                <span class="input-group-lg">
                                    {{Form::text('urlContest',isset($properties->shortName)? $properties->shortName:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.url'),isset($properties->status_contests)?'readonly':''))}}
                               </span>
                            </div>{{$errors->first('channel','<span class="error">:message</span>')}}{{$errors->first('urlContest','<span class="error">:message</span>')}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">{{Config::get('app.shortUrlContest')}}</span>
                                {{Form::text('shortUrlContest',isset($properties->shortUrlContest)? $properties->shortUrlContest:null,array('class'=>'form-control input-md','placeholder'=>Lang::get('contest.shortUrl'),isset($properties->status_contests)?'readonly':''))}}
                            </div>{{$errors->first('shortUrlContest','<span class="error">:message</span>')}}
                        </div>
                    </div>
                </div>
            </section>
            {{Form::hidden('contestImg',isset($properties->contestImg)? $properties->contestImg:null,array('id'=>'contestImg'))}}
    {{Form::close()}}

        @if ($userPermission["update"])

                @if(Session::has('SessionImg'))

                        <div class="bootstrap-duallistbox-container row imgDropzone"> 
                            <div class="box1 col-md-6 filtered">   
                                    {{Form::open(array('url'=>'/contest/uploadimg/contest','method'=>'POST','class'=>'dropzone updDropzone','id'=>'my-dropzone','file'=>true))}}
                                        {{Form::close()}}    
                            </div>
                             <div class="box2 col-md-6 imgDropzone" id='imgLoad'>  
                                     
                            </div>
                        </div>    
                @else
                    <section>
                         <label for="">Imagen</label>
                                <div class="widget-body">
                                    {{Form::open(array('url'=>'/contest/uploadimg/contest','method'=>'POST','class'=>'dropzone','id'=>'my-dropzone','file'=>true))}}
                                    {{Form::close()}}
                                </div>
                    </section>
                @endif
       

            <div class="form-actions">
                {{Form::button(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-primary','onclick'=>'save.submit();stopRKey()'))}}
            </div>
        @else
            <div class="form-actions">
                {{ HTML::linkAction('ContestController@getContestdate', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
            </div>
        @endif


        </div>  

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getContestdate', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
        </div>
    </div>

@endif

@stop
