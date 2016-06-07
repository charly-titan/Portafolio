@extends(Config::get( 'app.main_template' ).'.tabs.tabs')

@section('contentTabs')

<style>
    .modal-content{width: 750px;}
</style>
<br>
<br>
                                            
<div class="tab-pane active">

    {{Form::hidden('privacyPolicy',isset($contentPages->privacyPolicy)?$contentPages->privacyPolicy:null,array('id'=>'privacyPolicy'))}}
    {{Form::hidden('tos',isset($contentPages->tos)?$contentPages->tos:null,array('id'=>'tos'))}}
    {{Form::hidden('contestRules',isset($contentPages->contestRules)?$contentPages->contestRules:null,array('id'=>'contestRules'))}}

@if ($userPermission["view"])

    {{Form::hidden('valUserPermission',$userPermission["update"],array('id'=>'valUserPermission'))}}    
    <section id="widget-grid" class="">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <div class="well">
                                        
                            <div class="btn-toolbar">
                                <section>
                                    <div class="row">
                                        <div class="col-sm-3 uno ">
                                            <div class="form-group">
                                                <div class="input-group">
                                                      <button class="btn bg-color-yellow txt-color-white optService" data-toggle="modal" data-target="#myModal" data-service='privacyPolicy'>
                                                        {{Lang::get('contest.privacyPolicy')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    @if(Session::has('privacyPolicy'))
                                                            <button class="btn btn-success btn-circle btn-sm optService"><i class="glyphicon glyphicon-ok"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <br>
                                <section>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                      <button class="btn bg-color-yellow txt-color-white optService" data-toggle="modal" data-target="#myModal" data-service='tos'>
                                                        TOS
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    @if(Session::has('tos'))
                                                        <button class="btn btn-success btn-circle btn-sm optService"><i class="glyphicon glyphicon-ok"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <br>
                                <section>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <div class="input-group">
                                                      <button class="btn bg-color-yellow txt-color-white optService" data-toggle="modal" data-target="#myModal" data-service='contestRules'>
                                                       {{Lang::get('contest.contestRules')}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    @if(Session::has('contestRules'))
                                                        <button class="btn btn-success btn-circle btn-sm optService"><i class="glyphicon glyphicon-ok"></i></button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    &times;
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Editor</h4>
                            </div>
                            {{Form::open(array('url'=>'/contest/tosupd','method'=>'POST','name'=>'save','id'=>'optionParameter'))}}
                                <!--  Cuerpo modal -->
                                <div class="modal-body">
                                        <div class="form-group">
                                            <textarea name="descripcion" id='editContent' class='editors'></textarea>
                                        </div>
                                </div>
                                  <input type="hidden" id='typeDescription' name='typeTOS'>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">
                                        {{Lang::get('contest.cancel')}}
                                    </button>
                                    <button type="button" class="btn btn-primary" onclick='save.submit()'>
                                        {{Lang::get('contest.create')}}
                                    </button>
                                </div>
                            {{Form::close()}}     
                        </div>
                    </div>
                </div>
                

   
        <div class="form-actions">
            {{Form::open(array('url'=>'/contest/networkservice','method'=>'POST'))}}
                {{Form::submit(Lang::get('contest.btnNextSave'),array('class'=>'btn btn-primary'))}}
                {{ HTML::linkAction('ContestController@getContestownerinf', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
            {{Form::close()}}                               
        </div>              
    

    </div>

@else

    <div class="tab-pane active">                                       
        <br>
        <legend></legend>
        <h3>No cuentas con los permisos necesarios</h3>
        <div class="form-actions">
                {{ HTML::linkAction('ContestController@getTos', Lang::get('contest.btnNext'),null,array('class'=>'btn btn-primary')) }}
                {{ HTML::linkAction('ContestController@getContestdate', Lang::get('contest.btnPrevious'),null,array('class'=>'btn btn-primary pull-left')) }}
        </div>
    </div>

@endif


@stop

