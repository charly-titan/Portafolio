<div class="row">

    @foreach ($feed as $key)


        <div class="col-md-10 col-md-offset-1">
            <section class="widget">
            <header>
                <h4>
                    <i class="eicon-window"></i>
                    {{Lang::get('feeds.generate_new')}}
                    <small>feed</small>
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
                            <form class="form-horizontal form-condensed formUpdFeed"  action="" method="POST">
                                <fieldset>
                                    <div class="control-group">
                                        <!-- Feed -->
                                        <label class="control-label"  for="nameFeed">{{Lang::get('feeds.feed_name')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                                {{Form::text('nameFeed',$key->nameFeed,array('class' => 'form-control'))}}
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
                                                {{Form::text('urlFeed',$key->urlFeed,array('class' => 'form-control'))}}
                                                <span class='bg-danger' id='_urlFeed'>{{$errors->first('urlFeed')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_feed_url')}}</span>
                                            </div>
                                        </div>
                                    </div>


                                   <!-- <div class="control-group">
                                        
                                        <label class="control-label"  for="cl">{{Lang::get('feeds.program_key')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                                 {{Form::text('cl',$key->cl,array('class' => 'form-control','onkeypress' => 'validate(event)'))}}
                                                <span class='bg-danger' id='_cl'>{{$errors->first('cl')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_program_key')}}</span>
                                            </div>
                                        </div>
                                    </div>-->




                                    <div class="control-group" >
                                        <div id='lblOrder'>
                                            <label class="control-label"  for="cl">{{Lang::get('feeds.program_key')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-8">
                                                 {{Form::text('cl',$key->cl,array('class' => 'form-control','onkeypress' => 'validate(event)'))}}
                                                <span class='bg-danger' id='_cl'>{{$errors->first('cl')}}</span>
                                                <span class="help-block">{{Lang::get('feeds.msg_program_key')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                       <div id='lblOrder'>
                                            
                                            <label class="control-label" for="dateEnd">{{Lang::get('feeds.idChannel')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-8">
                                                    <select name="idChannel"  class='chzn-select select-block-level' required="required" id='idChannelUpd'>
                                                        
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

                                    {{Form::hidden('channel',$key->channel,array('class' => 'form-control','id' => 'channel'))}}



                                </fieldset>
                            </form>
                        </div>
                           <div class="tab-pane" id="tab2">
                            <form class="form-horizontal form-condensed formUpdFeed" action="" method="POST">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label"  for="nameDays">{{Lang::get('feeds.consult_day')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">

                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Monday'value='Monday' class="iCheck">
                                                            {{Lang::get('feeds.monday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Tuesday' value='Tuesday' class="iCheck">
                                                            {{Lang::get('feeds.tuesday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Wednesday' value='Wednesday' class="iCheck">
                                                            {{Lang::get('feeds.wednesday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Thursday' value='Thursday' class="iCheck">
                                                            {{Lang::get('feeds.thursday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Friday' value='Friday' class="iCheck">
                                                            {{Lang::get('feeds.friday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Saturday' value='Saturday' class="iCheck">
                                                            {{Lang::get('feeds.saturday')}}</label>
                                                        <label class="checkbox">
                                                            <input type="checkbox" name='nameDays[]' id='Sunday' value='Sunday' class="iCheck">
                                                            {{Lang::get('feeds.sunday')}}</label>
                                            </div>
                                        </div>
                                        <span class='bg-danger' id='_nameDays'>{{$errors->first('nameDays')}}</span>
                                    </div>
                                    {{Form::hidden('hourOminuteSel',$key->hourOminute,array('class' => 'form-control','id' => 'hourOminuteSel'))}}
                                    {{Form::hidden('nameDaysAct',$key->nameDays,array('class' => 'form-control','id' => 'nameDaysAct'))}}
                                    {{Form::hidden('idFeed',$key->id_feed,array('class' => 'form-control','id' => 'idFeed'))}}


                                    
                                    
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <form class="form-horizontal formUpdFeed" action="" method="POST">
                                <fieldset>
                                    <div class="form-row control-group">
                                            <label for="courier" class="control-label" for='timeConsultation'>{{Lang::get('feeds.consult_each')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-md-10">

                                                    <div class="input-group ">
                                                 {{Form::text('timeConsultation',$key->timeConsultation,array('class'=>'form-control','onkeypress' =>'validate(event)'))}}
                                                <div class="input-group-btn">
                                                    <select id="phone-type" class="selectpicker" name='hourOminute'
                                                        data-style="btn-primary">
                                                        <option id='Min'>Min</option>
                                                        <option id='Hr'>Hr</option>
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
                                                <div class="col-md-10">
                                                {{Form::text('initiationTime',date("H:i",strtotime($key->initiationTime)),array('class'=>'form-control','id'=>'mask-time'))}}
                                                <span class='bg-danger' id='_initiationTime'>{{$errors->first('initiationTime')}}</span>
                                                <p class="help-block">{{Lang::get('feeds.msg_from_time')}}</p></div>
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label" for="mask-time2">{{Lang::get('feeds.until_time')}}</label>
                                            <div class="controls form-group">
                                                <div class="col-md-10">
                                                {{Form::text('endTime',date("H:i",strtotime($key->endTime)),array('class'=>'form-control','id'=>'mask-time2'))}}
                                                <span class='bg-danger' id='_endTime'>{{$errors->first('endTime')}}</span>
                                                <p class="help-block">{{Lang::get('feeds.msg_until_time')}}</p></div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                            <div class="tab-pane" id="tab4">
                            <form class="form-horizontal form-condensed formUpdFeed" action='' method="POST">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="dateInitiation">{{Lang::get('feeds.start_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                            {{Form::text('dateInitiation',$key->dateInitiation, array('class' => 'form-control','format'=>'mm/dd/yyyy','id' => 'dpd1'))}}
                                            <span class='bg-danger' id='_dateInitiation'>{{$errors->first('dateInitiation')}}</span>
                                            <p class="help-block">{{Lang::get('feeds.msg_start_date')}}</p></div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="dateEnd">{{Lang::get('feeds.ending_date')}}</label>
                                        <div class="controls form-group">
                                            <div class="col-md-10">
                                            {{Form::text('dateEnd',$key->dateEnd, array('class' => 'form-control','format'=>'mm/dd/yyyy','id'=>'dpd2'))}}
                                            <span class='bg-danger' id='_dateEnd'>{{$errors->first('dateEnd')}}</span>
                                            <p class="help-block">{{Lang::get('feeds.msg_ending_date')}}</p></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
    @endforeach                        
                    <div class="description">
                            <ul class="pager wizard">
                                <li class="previous">
                                    <button class="btn btn-primary pull-left"><i class="fa fa-caret-left"></i> {{Lang::get('feeds.previous')}}</button>
                                </li>
                                <li class="next">
                                    <button class="btn btn-primary pull-right" >{{Lang::get('feeds.next')}} <i class="fa fa-caret-right"></i></button>
                                </li>
                                <li class="finish" style="display: none">
                                    <button class="btn btn-success pull-right" id='saveUpdFeed'>{{Lang::get('feeds.save')}} <i class="fa fa-check"></i></button>
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
