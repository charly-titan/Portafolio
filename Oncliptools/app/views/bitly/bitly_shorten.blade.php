@extends('vcms.main')
@section('content')

<div class="row">
    
    <div class="col-md-9 col-md-offset-2">
        
        <section class="widget" style="position: absolute; top: 80px; width: 100%; ">
            <header>
                <h5>
                    <i class="fa fa-magic"></i>
                </h5>
            </header>
            
            <div class="body">
                <div class="modal" style="position: relative; top: auto; right: auto; left: auto; bottom: auto; z-index: 1; display: block; overflow: hidden;">
                    <div class="modal-dialog" style="width: auto; padding: 0;">
                        <div class="modal-content">
                            
                            <div class="modal-header">
                                
                            </div>
                            
                            <div class="modal-body">
                                {{ Form::open(array('url' => 'bitly/shorturl')) }}
                                
                                    <div class="form-group">
                                        {{Form::label('url', 'Url', array('class'=>'section'))}}
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            {{Form::text('url', '', array('class'=>'form-control date-picker'))}}
                                        </div>
                                    </div>
                                
                                    <div class="form-group">
                                        {{Form::label('json', 'Json', array('class'=>'section'))}}
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            {{Form::text('json', $json, array('class'=>'form-control date-picker'))}}
                                        </div>
                                    </div>
                                
                                    <div class="form-actions" style="text-align: center;">
                                        
                                        {{Form::submit('Save',array('type'=>'button','class'=>'btn btn-success'))}}

<!--                                    {{ HTML::link('contactos', 'Cancelar',array('type'=>'button','class'=>'btn btn-success')); }}-->
                                    </div>
                                
                                {{ Form::close() }}
                            </div>
                            
                            <div class="modal-footer">

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
            
        </section>
        
    </div>

</div> 







         
      


