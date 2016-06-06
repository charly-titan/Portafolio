   <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <section class="widget">
            <header>
                <h4>
                    <i class="eicon-window"></i>
                    {{Lang::get('feeds.generate_new')}}
                    <small>Feed</small>
                </h4>
            </header>
            <div class="body">
                        <div class="widget-controls">
                            <a data-widgster="close" title="Close" href="/adminFeeds" id='aCancel'>Cancel <i class="glyphicon glyphicon-remove"></i></a>
                        </div>
                <div id="wizard" class="form-wizard">
                    <ul class="wizard-navigation nav-justified nav nav-pills">
                        <li><a href="#tab1" data-toggle="tab"><small>1.</small><strong>{{Lang::get('feeds.name')}}</strong></a></li>
                        <li><a href="#tab2" data-toggle="tab"><small>2.</small> <strong>{{Lang::get('feeds.days')}}</strong></a></li>
                        <li><a href="#tab3" data-toggle="tab"><small>3.</small> <strong>{{Lang::get('feeds.frequency')}}</strong></a></li>
                        <li><a href="#tab4" data-toggle="tab"><small>4.</small> <strong>{{Lang::get('feeds.date')}}</strong></a></li>
                    </ul>
                    <div id="bar" class="progress progress-small">
                        <div class="progress-bar progress-bar-inverse" style="width: 25%;"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <form class="form-horizontal form-condensed formNewFeed" action="" method="POST">
                                <fieldset>
                                    <div class="control-group">
                                        <!-- Feed -->
                                        <label class="control-label"  for="nameFeed">{{Lang::get('feeds.feed_name')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                                <input type="text" id="nameFeed" name="nameFeed" placeholder="" class="form-control">
                                                <span class='bg-danger' id='_nameFeed'>{{$errors->first('nameFeed')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_feed_name')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <!-- Url Feed -->
                                        <label class="control-label"  for="urlFeed">{{Lang::get('feeds.feed_url')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                                <input type="text" id="urlFeed" name="urlFeed"
                                                                          placeholder="" class="form-control">
                                                <span class='bg-danger' id='_urlFeed'>{{$errors->first('urlFeed')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_feed_url')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group" >
                                        <div id='lblOrder'>
                                            <label class="control-label"  for="cl">{{Lang::get('feeds.program_key')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-8">
                                                 <input type="text" id="cl" name="cl"
                                                                          placeholder="" class="form-control" onkeypress='validate(event)'>
                                                <span class='bg-danger' id='_cl'>{{$errors->first('cl')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_program_key')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div id='lblOrder'>
                                            
                                            <label class="control-label" for="dateEnd">{{Lang::get('feeds.idChannel')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-8">
                                                    <select name="idChannel"  class='chzn-select select-block-level' required="required" id='idChannel'>
                                                        
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <option value="{{$i}}">{{ $i }}</option>
                                                        @endfor
                                                    </select>   
                                                    <span class='bg-danger' id='_idChannel'>{{$errors->first('idChannel')}}</span>
                                                    <span class="help-block">{{Lang::get('feeds.msg_idChannel')}}</span>
                                               </div>
                                            </div>
                                        </div>
                                    </div>

                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form class="form-horizontal form-condensed formNewFeed" action="" method="POST">
                                <fieldset>
                                   <div class="control-group">
                                        <label class="control-label"  for="nameDays">{{Lang::get('feeds.consult_day')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">

                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Monday' class="iCheck">
                                                            {{Lang::get('feeds.monday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Tuesday' class="iCheck">
                                                            {{Lang::get('feeds.tuesday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Wednesday' class="iCheck">
                                                            {{Lang::get('feeds.wednesday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Thursday' class="iCheck">
                                                            {{Lang::get('feeds.thursday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Friday' class="iCheck">
                                                            {{Lang::get('feeds.friday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Saturday' class="iCheck">
                                                            {{Lang::get('feeds.saturday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' value='Sunday' class="iCheck">
                                                            {{Lang::get('feeds.sunday')}}</label>
                                            </div>
                                        </div>
                                        <span class='bg-danger' id='_nameDays'>{{$errors->first('nameDays')}}</span>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <form class="form-horizontal formNewFeed" action="" method="POST">
                                <fieldset>
                                     <div class="form-row control-group">
                                            <label for="courier" class="control-label" for='timeConsultation'>{{Lang::get('feeds.consult_each')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-md-10">

                                                    <div class="input-group ">
                                                <input type="text" class="form-control timeConsultation" id="type-dropdown-appended" name='timeConsultation' onkeypress='validate(event)' >
                                                <div class="input-group-btn">
                                                    <select id="phone-type" class="selectpicker" name='hourOminute'
                                                        data-style="btn-primary">
                                                    <option>Min</option>
                                                    <option>Hr</option>
                                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <span class='bg-danger' id='_timeConsultation'>{{$errors->first('timeConsultation')}}</span>
                                            <p class="help-block">{{Lang::get('feeds.msg_consult_each')}}</p>

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="mask-time">{{Lang::get('feeds.from_time')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-md-10"><input type="text" name='initiationTime' id="mask-time" placeholder="13:43" class="form-control">
                                                <span class='bg-danger' id='_initiationTime'>{{$errors->first('initiationTime')}}</span>
                                                <p class="help-block">{{Lang::get('feeds.msg_from_time')}}</p></div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="mask-time2">{{Lang::get('feeds.until_time')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-md-10"><input type="text" name='endTime' id="mask-time2" placeholder="13:43" class="form-control" maxlength="5">
                                                <span class='bg-danger' id='_endTime'>{{$errors->first('endTime')}}</span>
                                                <p class="help-block">{{Lang::get('feeds.msg_until_time')}}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab4">
                             <form class="form-horizontal form-condensed formNewFeed" action='' method="POST">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="dateInitiation">{{Lang::get('feeds.start_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                            <input type="text" name="dateInitiation" placeholder="mm/dd/yyyy" class="form-control date-picker"  data-date='today()' id='dpd1'>
                                            <span class='bg-danger' id='_dateInitiation'>{{$errors->first('dateInitiation')}}</span>
                                            <p class="help-block">{{Lang::get('feeds.msg_start_date')}}</p></div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="dateEnd">{{Lang::get('feeds.ending_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                            <input type="text" name="dateEnd" placeholder="mm/dd/yyyy" class="form-control date-picker" data-date='today()' id='dpd2'>
                                            <span class='bg-danger' id='_dateEnd'>{{$errors->first('dateEnd')}}</span>
                                            <p class="help-block">{{Lang::get('feeds.msg_ending_date')}}</p></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="description">
                            <ul class="pager wizard">
                                <li class="previous">
                                    <button class="btn btn-primary pull-left"><i class="fa fa-caret-left"></i> {{Lang::get('feeds.previous')}}</button>
                                </li>
                                <li class="next">
                                    <button class="btn btn-primary pull-right" >{{Lang::get('feeds.next')}} <i class="fa fa-caret-right"></i></button>
                                </li>
                                <li class="finish" style="display: none">
                                    <button class="btn btn-success pull-right" id='saveNewFeed'>{{Lang::get('feeds.save')}} <i class="fa fa-check"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        </div>
    </div>



{{ HTML::script('js/escaletasFeeds.js') }}



