    <div class="row">

            <div id="col_md" class="col-md-10 col-md-offset-1">

                <section class="widget">

                    <header>
                        <h4>
                            <i class="fa fa-list-alt"></i>
                            Feeds 
                        </h4>
                    </header>

                    <table class="fc-header" style="width:100%">
                        <tbody>
                            <tr>
                                <td class="fc-header-left">

                                    <span class="fc-state-default">
                                        <span class="fc-button-inner">
                                                <a href="#" class="glyphicon glyphicon-chevron-left left" id="/escaletas/statusweek/prev/{{strtotime($firstDayWeek)}}"></a>
                                        </span>
                                    </span>
                                </td>
                                <input type='hidden' id='month' value="{{date('n',strtotime($firstDayWeek))}}">
                                <td class="fc-header-center">
                                    <span class="fc-header-title">
                                        <h3> <span id='weekR'></span>   {{date('d',strtotime($firstDayWeek))}} - {{date('d',strtotime($lastDayWeek))}}   {{date('Y',strtotime($lastDayWeek))}}</h3>
                                    </span>
                                </td>
                                <td class="fc-header-right">
                                    <span class="fc-button fc-state-default fc-corner-left fc-corner-right">
                                        <span class="fc-button-inner">
                                                <a href='#' id="/escaletas/statusweek/next/{{strtotime($lastDayWeek)}}" class="glyphicon glyphicon-chevron-right right"></a>
                                        </span>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="table-dynamic">
                        <table class="table table-striped table-editable no-margin">
                            <thead class="table table-striped table-editable no-margin">
                                <tr>
                                     <th><strong>{{Lang::get('feeds.feed_name')}}</strong></th>

                                        @foreach ($dateWeek as $key)
                                           <th ><strong>{{date('m/d',strtotime($key))}}</strong></th>
                                        @endforeach
                               
                                </tr>
                            </thead>
                           
                            <tbody class="table table-striped table-editable no-margin">
                                <tr>
                                    
                                    @foreach ($dataFeeds as $idFeed => $valueFeed)
                                            @foreach ($valueFeed as $keyNameFeed => $valueNameFeed)
                                                
                                                <tr>
                                                    <td>{{$keyNameFeed}}</td>

                                                    @foreach ($dateWeek as $keyW)
                                                        <td class='centerFeed'>
                                                            <span>{{ $valueNameFeed[ $keyW ] }}</span> 
                                                            <span class='update' id='{{$idFeed."@".$keyW}}'><a href="#" class="btn-sm  glyphicon glyphicon-edit glyEdit" ></a></span>
                                                        </td>
                                                        
                                                    @endforeach

                                                </tr>    

                                            @endforeach
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
    </div>


{{ HTML::script('js/table_feeds.js') }}

