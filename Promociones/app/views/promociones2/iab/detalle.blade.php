@extends(Config::get( 'app.main_template' ).'.iab.main')

@section('css')
    @parent
    <link href="/fasi/css/grid-gallery.css" rel="stylesheet">
    <link href="/fasi/css/style.css" rel="stylesheet">
@stop

@section('content')

<style>
#news{ 
    margin: 0px auto;
}
.img-responsive{ 
    max-width: 100%;
    width: 310px;
}
.mm-content-title { 
    color: #FFFFFF!important;
    background: #0062FF;
    text-transform: lowercase;
}

</style>
    
<!-- content -->
<div class="jp-wrapper">
    <div class="breaking" style="visibility: hidden;"></div>
    <section class="slice" id="news">
        <div class="row ">
            <div class="col-lg-12">
                <h1>Lorem ipsum dolor</h1>   
            </div>
            <div class="layout clearfix infinite-scrolling" id="iso" data-options="[mq_desktop=827, mq_tablet=500, mq_smartphone=220]" data-margins="[desktop=[top=18, left=24], tablet=[top=12, left=6], movil=[top=6, left=3]]" data-desktop="[items=15, vueltas=7]" data-tablet="[items=15, vueltas=7]" data-smartphone="[items=15, vueltas=7]" >

              @if ($fotos && count($fotos)>0)
                @foreach ($fotos as $value)
                    <div class="item" data-options="[desktop=1, tablet=1, movil=1, desktop_visible=true, tablet_visible=true, movil_visible=true]">
                      <article class="mm-container grid-element">
                          
                          <a href="{{$value->s3_url_original}}" class="mm-vinculo" target="_blank">
                              <div class="mm-img-container">
                                  {{ html_entity_decode(HTML::image($value->foto_url, "",['class'=>'img-responsive'])) }}
                              </div>
                              <h3 class="mm-content-title">{{$value->name}} </h3>
                          </a>
                      </article>
                    </div>
                    
                @endforeach
              @else
                <center><p>No se encontraron imagenes aprobadas</p></center>
              @endif
            </div>
            @if($fotos && count($fotos)>0)
            <center><a class="btn btn-lg" title="" href="{{$zip}}" target="blank"><i class="icon-download"></i>Descargar Im&aacute;genes</a>
            <a class="btn btn-lg" title="" href="#" target="blank"><i class="icon-forward"></i>Participar</a></center>
            @endif
        </div>
    </section>
<!-- content -->
</div>
<!-- global wrapper -->
@stop


@section('scripts')

        <script type="text/javascript" src="/aib/files/js-plugin/jquery/jquery.1.10.2.min.js"></script>
        <script type="text/javascript" src="/aib/files/js/head.load.min.js"></script>
        <script type="text/javascript" id="libs" src="/aib/files/js/finalpage-libs.js"></script>
@stop
