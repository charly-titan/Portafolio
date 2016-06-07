@extends(Config::get( 'app.main_template' ).'.main')

@section('css')
@parent

        {{ HTML::style('packages/kmd/logviewer/css/style.css') }}
@stop



@section('scripts')
@parent
        <!--[if lt IE 9]>
            <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        {{ HTML::script('//cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.min.js') }}
        
        <script>window.jQuery || document.write('<script src="{{ URL::to("packages/kmd/logviewer/js/jquery-1.10.2.min.js") }}"><\/script>')</script>
        
        {{ HTML::script('packages/kmd/logviewer/js/script.js') }}

@stop

@section('content')        

        

            <div class="container-fluid">

                <header>
                    <div class=" navbar "><!-- navbar navbar-static-top navbar-inverse -->
                        <div class="navbar-inner">
                            <div class="container-fluid"><h2 class="row-seperator-header"><i class="fa fa-reorder"></i> {{ HTML::link($url, Lang::get('logviewer::logviewer.title'), array('class' => 'brand')) }}</h2>
                                
                                <ul class="nav navbar-nav">
                                    {{ HTML::nav_item($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/all', ucfirst(Lang::get('logviewer::logviewer.levels.all'))) }}
                                    @foreach ($levels as $level)
                                        {{ HTML::nav_item($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/'.$level, ucfirst(Lang::get('logviewer::logviewer.levels.'.$level))) }}
                                    @endforeach
                                </ul>
                                @if ( ! $empty)
                                    <div class="pull-right">
                                        {{ HTML::link('#delete_modal', Lang::get('logviewer::logviewer.delete.btn'), array('class' => 'btn btn-danger', 'data-toggle' => 'modal', 'data-target' => '#delete_modal')) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </header>

                <div class="row-fluid">

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
                        <div id="nav" class="well">
                            <ul class="nav nav-list">
                                @if ($logs)
                                    @foreach ($logs as $type => $files)
                                        @if ( ! empty($files['logs']))
                                            <?php $count = count($files['logs']) ?>
                                            @foreach ($files['logs'] as $app => $file)
                                                @if ( ! empty($file))
                                                    <li class="nav-header">{{ ($count > 1 ? $app.' - '.$files['sapi'] : $files['sapi']) }}</li>
                                                    <ul class="nav nav-list">
                                                        @foreach ($file as $f)
                                                            {{ HTML::decode(HTML::nav_item($url.'/'.$app.'/'.$type.'/'.$f, $f)) }}
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10">
                        <div class="row-fluid{{ ! $has_messages ? ' hidden' : '' }}">
                            <div class="span12" id="messages">
                                @if (Session::has('success'))
                                    <div class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (Session::has('error'))
                                    <div class="alert alert-error">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                                @if (Session::has('info'))
                                    <div class="alert alert-info">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        {{ Session::get('info') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                {{ $paginator->links() }}
                                <div id="log" class="well">
                                    @if ( ! $empty && ! empty($log))
                                        @foreach ($log as $l)
                                            @if (strlen($l['stack']) > 1)
                                                <div class="alert alert-block alert-{{ $l['level'] }}">
                                                    <span title="Click to toggle stack trace" class="toggle-stack"><i class="icon-expand-alt"></i></span>
                                                    <span class="stack-header">{{ $l['header'] }}</span>
                                                    <pre class="stack-trace">{{ $l['stack'] }}</pre>
                                                </div>
                                            @else
                                                <div class="alert alert-block alert-{{ $l['level'] }}">
                                                    <span class="toggle-stack">&nbsp;&nbsp;</span>
                                                    <span class="stack-header">{{ $l['header'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @elseif ( ! $empty && empty($log))
                                        <div class="alert alert-block">
                                            {{ Lang::get('logviewer::logviewer.empty_file', array('sapi' => $sapi, 'date' => $date)) }}
                                        </div>
                                    @else
                                        <div class="alert alert-block">
                                            {{ Lang::get('logviewer::logviewer.no_log', array('sapi' => $sapi, 'date' => $date)) }}
                                        </div>
                                    @endif
                                </div>
                                {{ $paginator->links() }}
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        

        <div id="delete_modal" class="modal hide fade">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>{{ Lang::get('logviewer::logviewer.delete.modal.header') }}</h3>
            </div>
            <div class="modal-body">
                <p>{{ Lang::get('logviewer::logviewer.delete.modal.body') }}</p>
            </div>
            <div class="modal-footer">
                {{ HTML::link($url.'/'.$path.'/'.$sapi_plain.'/'.$date.'/delete', Lang::get('logviewer::logviewer.delete.modal.btn.yes'), array('class' => 'btn btn-success')) }}
                <button class="btn btn-danger" data-dismiss="modal">{{ Lang::get('logviewer::logviewer.delete.modal.btn.no') }}</button>
            </div>
        </div>

        
@stop