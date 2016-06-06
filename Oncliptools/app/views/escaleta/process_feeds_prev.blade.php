 <div class="row">
          
            <div id="col_md" class="col-md-9 col-md-offset-1">

                <section class="widget">
                    <header>
                        <h4>
                            <i class="fa fa-list-alt"></i>
                            {{Lang::get('feeds.feeds_process')}}
                        </h4>
                    </header>
                    <div class="body">

                    {{Form::open(array('url' => '/escaletas/feedsprev', 'method' => 'POST','class'=>'form-horizontal label-left','id'=>'formFeedsPrev'))}}
                            <fieldset>

                                <div class="control-group">
                                    <label class="control-label">{{Lang::get('feeds.feed_name')}}</label>
                                    <div class="controls form-group">
                                        <div class="input-group col-sm-9">
                                            {{ Form::select('idFeeds', $proccessFeedsPrev, null, ['id' => 'idFeeds','class' => 'chzn-select select-block-level']) }}
                                        </div>{{$errors->first('feedsprev', '<span class="error">:message</span>')}}  
                                    </div>
                                </div>

                                    <div class="control-group" >
                                    <div id='lblOrder'>
                                        <label class="control-label" for="dateInitiation">{{Lang::get('feeds.start_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-8">
                                            <input type="text" name="dateInitiation" placeholder="mm/dd/yyyy" class="form-control date-picker"  data-date='today()' id='dpd1'>
                                            <span class='bg-danger' id='_dateInitiation'>{{$errors->first('dateInitiation')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id='lblOrder'>
                                        
                                        <label class="control-label" for="dateEnd">{{Lang::get('feeds.ending_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-8">
                                            <input type="text" name="dateEnd" placeholder="mm/dd/yyyy" class="form-control date-picker" data-date='today()' id='dpd2'>
                                            <span class='bg-danger' id='_dateEnd'>{{$errors->first('dateEnd')}}</span>
                                           </div>
                                        </div>
                                    </div>
                                    
                                        
                                    </div>
                            </fieldset>

                            <div class="row">
                                <div class="col-xs-4 col-sm-offset-4">
                                    <button type="button" class="btn btn-success btn-primary" data-placement="top" id='btnFeed'>
                                     {{Lang::get('feeds.update')}}
                                    </button>
                                    <div id='espera'></div>
                                </div>
                            </div>

                            

                    {{ Form::close() }}
                       
                    </div>
                </section>
            </div>
</div>

{{ HTML::script('js/process_feeds_prev.js') }}
