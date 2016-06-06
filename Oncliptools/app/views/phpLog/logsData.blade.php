@extends('vcms.main')
@section('content')

    <div class="row">
            <div class="col-md-12">
                <section class="widget" style="position: absolute; top: 80px; left: 20%;">
                    <header>
                        <div id="video_generate">
                            <i class="glyphicon glyphicon-facetime-video"></i>
                            Logs Procesados
                        </div>
                    </header>

                    <div  class="body" style="overflow-x: hidden;">

                        <style type="text/css">
                            .table_LogsProcess{
                                font-family: "Open Sans", sans-serif;
                                font-size: 13px;
                                line-height: 20px;
                                color: #f8f8f8;
                            }
                        </style>

                        <table class="table table-striped table-editable no-margin table_LogsProcess">
                            
                            <thead class="table table-striped table-editable no-margin">
                                <tr>
                                    <th style="text-align:center;"><small><strong>id</strong></small></th>
                                    <th style="text-align:center;"><small><strong>Short Name</strong></small></th>
                                    <th style="text-align:center;" ><small><strong>Timestamp</strong></small></th>
                                    <th style="text-align:center;"><small><strong>Action</strong></small></th>
                                    <th style="text-align:center;"><small><strong>Unix_Time_Start</strong></small></th>
                                    <th style="text-align:center;"><small><strong>Unix_Time_End</strong></small></th>
                                    <th style="text-align:center;"><small><strong>Delta_Unix_Time </strong></small></th>
                                    <th style="text-align:center;"><small><strong>Ver Log </strong></small></th>
                                </tr>
                            </thead>

                            <tbody class="table table-striped table-editable no-margin">
                                @foreach($LogsProcess as  $value)
                                    <tr  id="{{$value->id}}" style="text-align:center;">
                                        <td style="text-align:center;">{{ $value->id}}</td>
                                        <td style="text-align:center;">{{ $value->vod_id}}</td>
                                        <td style="text-align:center;">{{ $value->UnixTimeId}}</td>
                                        <td style="text-align:center;">{{ $value->action}}</td>
                                        <td style="text-align:center;">{{ $value->unixTimeStart}}</td>
                                        <td style="text-align:center;">{{ $value->unixTimeEnd}}</td>
                                        <td style="text-align:center;">{{ $value->deltaUnixTime}}</td>
                                        <td>
                                            {{Form::open(array('method'=> 'GET','url' => '/logShow'))}}
                                            <input type="text" value="{{$value->id}}" name='idLog' style="display: none;">
                                            {{Form::button('<i class="fa  fa-align-justify"></i>',array('type' => 'submit', 'id'=>'showLogs','class' => 'btn btn-danger'))}}
                                            {{Form::close()}}
                                        </td>
                                    </tr>
                                @endforeach   
                            </tbody>

                        </table>                     

                    </div>

                </section>
            </div>   
    </div> 







         
      


