@extends('vcms.main')

@section('style')

    {{HTML::style('css/adminFeeds.css')}}

@stop

@section('content')

{{App::setLocale(Session::get('locale'))}}
        <div class="row" >

            <div class="col-md-14" class="col-md-offset-1">
                <section class="widget widget-tabs">
                    
                    <header>
                        <ul class="nav nav-tabs">
                            <li class="pestanaFeed">
                                <a href="#adminEscaletaRes" class='adminEscaletaRes' data-toggle="tab" id='/escaletas'>Escaletas</a>
                            </li>
                            <li class="pestanaFeed">
                                <a href="#feedsProcessRes" class='feedsProcessRes' data-toggle="tab" id='/escaletas/processfeedsprev'>{{Lang::get('feeds.feeds_process')}}</a>
                            </li>
                            <li class="pestanaFeed">
                                <a href="#tableFeedsRes" class='tableFeedsRes' data-toggle="tab" id='/escaletas/tablefeed'>{{Lang::get('feeds.table_feeds')}}</a>
                            </li>

                        </ul>
                    </header>
                    
                    <div class="body tab-content" id="tab-content">
                        <div id="adminEscaletaRes" class="tab-pane clearfix"></div>
                        <div id="feedsProcessRes" class="tab-pane clearfix"></div>
                        <div id="tableFeedsRes" class="tab-pane clearfix"></div>
                    </div>
                    
                </section>
            </div>
            
            <input type='hidden' value='{{$pestana}}' id='pestActiva'> 
        
        </div>
@stop

@section('scripts')
 @parent

    {{ HTML::script('light-blue/lib/jquery-maskedinput/jquery.maskedinput.js') }}
    {{ HTML::script('light-blue/lib/bootstrap/tab.js') }}
    {{ HTML::script('light-blue/lib/bootstrap-datepicker.js') }}
    {{ HTML::script('light-blue/lib/jquery.bootstrap.wizard.js') }}
    {{ HTML::script('light-blue/lib/icheck.js/jquery.icheck.js') }}
    {{ HTML::script('light-blue/lib/bootstrap/tooltip.js') }}
    {{ HTML::script('light-blue/lib/bootstrap/dropdown.js') }}

    {{ HTML::script('js/adminFeeds.js') }}

@stop