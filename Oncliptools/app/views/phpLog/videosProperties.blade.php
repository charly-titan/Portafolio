@extends('vcms.main')
@section('content')

    <style type="text/css">
        .table_LogsProcess{
            font-family: "Open Sans", sans-serif;
            font-size: 13px;
            line-height: 20px;
            color: #f8f8f8;
        }
    </style>

    <div class="row">
            <div class="col-md-10">
                <section class="widget" style="position: absolute; top: 80px; left: 20%;">
                    <header>
                        <div id="video_generate">
                            <i class="glyphicon glyphicon-facetime-video"></i>
                            Propiedades del Video
                        </div>
                    </header>

                    <div  class="body" style="overflow-x: hidden;">



                        <table class="table table-striped table-editable no-margin table_LogsProcess">
                            
                            <thead class="table table-striped table-editable no-margin">
                                <tr>
                                    <th style="text-align:center;"><small><strong>id</strong></small></th>
                                    <th style="text-align:center;"><small><strong>video_id</strong></small></th>
                                    <th style="text-align:center;"><small><strong>reference_guid</strong></small></th>
                                    <th style="text-align:center;"><small><strong>property_name</strong></small></th>
                                    <th style="text-align:center;"><small><strong>property_value</strong></small></th>
                                    <th style="text-align:center;"><small><strong>short_name</strong></small></th>
                                    <th style="text-align:center;"><small><strong>user_id</strong></small></th>
                                    <th style="text-align:center;"><small><strong>pid</strong></small></th>
                                    <th style="text-align:center;"><small><strong>title</strong></small></th>
                                </tr>
                            </thead>

                            <tbody class="table table-striped table-editable no-margin">
                                @foreach($videos_properties as $value)
                                        <tr>
                                            <td style="text-align:center;">{{$value->id}}</td>
                                            <td style="text-align:center;">{{$value->video_id}}</td>
                                            <td style="text-align:center;">{{$value->reference_guid}}</td>
                                            <td style="text-align:center;">{{$value->property_name}}</td>
                                            <td style="text-align:center;">{{$value->property_value}}</td>
                                            <td style="text-align:center;">{{$short_name}}</td>
                                            <td style="text-align:center;">{{$user_id}}</td>
                                            <td style="text-align:center;">{{$pid}}</td>
                                            <td style="text-align:center;">{{$title}}</td>
                                        </tr> 

                                @endforeach
                            </tbody>

                        </table><br>
                        

                        <div class="well" style="text-align: center">
                            {{Form::open(array('method'=> 'GET','url' => 'quality/'.$vid))}}
                            {{Form::button('Retornar',array('type' => 'submit', 'class' => 'btn btn-success','data-dismiss'=>'modal'))}}
                            {{Form::close()}}
                        </div>

                        

                    </div>

                </section>
            </div>   
    </div> 







         
      


