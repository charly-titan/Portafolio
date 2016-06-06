      <div class="row">
            <div class="col-md-12">
                <section class="widget">
                    <header>
                        <h4>
                            {{Lang::get('feeds.status_feed')}}
                            <small>
                                ({{Lang::get('feeds.current_week')}})
                            </small>
                        </h4>
                        <div class="actions">
                            <button class="btn btn-transparent btn-xs" id='newFeed'>{{Lang::get('feeds.create_new')}}<i class="fa fa-plus"></i></button>
                        </div>
                    </header>
                    <div class="body">
                        <table class="table table-striped no-margin sources-table">
                            <thead>
                            <tr>
                                <th class="source-col-header">{{Lang::get('feeds.name')}}</th>
                                <th class="hidden-xs">{{Lang::get('feeds.last_update')}}</th>
                                <th class="hidden-xs">{{Lang::get('feeds.next_update')}}</th>
                                <th class="hidden-xs">{{Lang::get('feeds.last_error')}}</th>
                                <th>{{Lang::get('feeds.status')}}</th>
                                <th>{{Lang::get('feeds.edit')}}</th>
                                <th >{{Lang::get('feeds.update')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                             @for ($i=0; $i < count($nameFeed); $i++)

                                <tr>
                                    <td class="source-col-header">{{$nameFeed[$i]['nameFeed']}}</td>
                                    <td class="hidden-xs">{{$nameFeed[$i]['lastUpdate']}}</td>
                                    <td class="hidden-xs">{{$nameFeed[$i]['proxAct']}}</td>
                                    <td class="hidden-xs">{{$nameFeed[$i]['lastError']}}</td>
                                    <td>
                                         @if($nameFeed[$i]['estatus'] == 'ok')
                                            <span class="label label-success">{{$nameFeed[$i]['estatus']}}</span>
                                         @else
                                            <span class="label label-danger">{{$nameFeed[$i]['estatus']}}</span> 
                                         @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-warning glyphicon glyphicon-edit updFeed" id="{{$nameFeed[$i]['id_feed']}}"></button>
                                    </td>
                                    <td >
                                    {{ Form::open(array('url' => 'escaletas/actualizafeed/'.$nameFeed[$i]['id_feed'], 'class' => 'pull-right')) }}
                                                        {{ Form::hidden('_method', 'GET') }}
                                                        <button type="" class="btn btn-success" ><i class="fa fa-refresh"></i></button>
                                    {{ Form::close() }}

                                    </td>
                                    
                                </tr>
                                 
                             @endfor

                            </tbody>
                        </table>
                    </div>
                </section>
                
            </div>
           
    </div>

{{ HTML::script('js/escaletasFeeds.js') }}