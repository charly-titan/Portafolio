@extends('vcms.main')
@section('content')
<div class="row">
        <div class="col-md-9">
            <section class="widget" style="position: absolute; top: 80px; left: 22%; width: 100%;">
                <header>
                    @if (file_exists($dir))
                    <div id="video_generate">
                        <i class="glyphicon glyphicon-facetime-video"></i>
                        El directorio existe, procesando archivos de contenido ...
                    </div>
                    @endif
                </header>

                <div  class="body" style="overflow-x: hidden;">
                    
                            <?php $i=1; ?> 
                            <table class="table table-striped table-editable no-margin">

                                <thead class="table table-striped table-editable no-margin">
                                    <tr>
                                        <th style="text-align:center;"><small><strong>#</strong></small></th>
                                        <th style="text-align:center;"><small><strong>Archivo</strong></small></th>
                                        <th style="text-align:center;"><small><strong>Procesar</strong></small></th>
                                    </tr>
                                </thead>
                                
                                <tbody class="table table-striped table-editable no-margin">
                                
                                @while (($file = readdir($dh)) !== false)                                                                  
                                        @if( strpos($file,'log') != false )
                                                <?php $explodFile = explode('_', $file);
                                                      $vod_id = $explodFile[0]; 
                                                ?>
                                                @if( $vod_id == $short_name)

                                                    
                                                        <tr>
                                                            <td style="text-align:center;">{{$i}}</td>
                                                            <td id="{{$i}}" style='text-align:center;'>{{$file}}</td>
                                                            <td style="text-align:center;">
                                                                {{Form::open(array('url' =>'logs/process/'.$vid))}}
                                                                <input type="text" value="{{$file}}" name='archivo' style="display: none;">
                                                                {{Form::button('<i class="fa fa-cogs"></i>',array('type' => 'submit', 'id'=>'postFile','class' => 'btn btn-danger'))}}
                                                                {{Form::close()}}
                                                            </td>
                                                        </tr>
                                                    

                                                    <?php $i = $i + 1;?>
                                                @endif
                                        @endif
                                @endwhile
                                
                                </tbody>
                            </table>

                    
                </div>
                
            </section>
        </div>   
    </div> 





         
      


