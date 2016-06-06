@extends('vcms.main')
@section('content')

<div style=""></div>

<div class="row">
    
    <div class="col-md-9 col-md-offset-2">
        
        <section class="widget" style="position: absolute; top: 80px; width: 100%; ">
            <header>
                <h5>
                    <i class="fa fa-magic"></i>
                    Log Encontrado
                </h5>
            </header>
            
            <div class="body">
                <div class="modal" style="position: relative; top: auto; right: auto; left: auto; bottom: auto; z-index: 1; display: block; overflow: hidden;">
                    <div class="modal-dialog" style="width: auto; padding: 0;">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                    {{Form::open(array('method'=> 'GET','url' => '/logsTable/'.$vod_id))}}
                                    {{Form::button('×',array('type' => 'submit', 'class' => 'close','data-dismiss'=>'modal','aria-hidden'=>'true'))}}
                                    {{Form::close()}}

                                <h4 class="modal-title">Contenido del Log</h4>
                            </div>
                            <div class="modal-body">
                                <p>{{$logShow}}</p>
                            </div>
                            <div class="modal-footer">
                                {{Form::open(array('method'=> 'GET','url' => '/logsTable/'.$vod_id))}}
                                {{Form::button('Close',array('type' => 'submit', 'class' => 'btn btn-default','data-dismiss'=>'modal'))}}
                                {{Form::close()}}
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>
            </div>
            
        </section>
        
    </div>

</div> 







         
      


