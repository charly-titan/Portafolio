@section('footer')
    <style type="text/css">
    @if (isset($info->properties['UrlImgLogo']))
        .c5-logof{
            background-image: url(/../img/television.png);
            background-repeat: no-repeat;
            background-position: center center;

        }
        footer.c5-footer .c5-logof{
            width: 50px;
        }
        
    @endif
    </style>
    <div class="container-footer">
        <footer class="c5-footer">
            <div class="c5-logof">
            @if (isset($info->properties['UrlImgLogo']))
                <a href="http://television.televisa.com/" title="logotipo {{isset($info->properties['channel'])?$info->properties['channel']:''}}" target="_blank">
            @else
                <a href="http://www.televisa.com/canal5/" title="logotipo {{isset($info->properties['channel'])?$info->properties['channel']:''}}" target="_blank">
                    <i class="c5-logo"></i>
            @endif
                </a>
            </div>
            @if(isset($short_name))
            
                @if (strtolower($info->contest_type)!="foto")
                <div class="c5-txtf">{{Lang::get('promociones.footerMsg')}}
                <a href="{{'/'.(isset($info->properties['channel'])?$info->properties['channel']:'').'/'.$short_name.'/bases-concurso'}}" target="_blank">{{Lang::get('promociones.footerBc')}}</a>, 
                @else
                <div class="c5-txtf">Consulta nuestro
                @endif

            <a href="{{'/'.(isset($info->properties['channel'])?$info->properties['channel']:'').'/'.$short_name.'/aviso-privacidad'}}" target="_blank">{{Lang::get('promociones.footerAp')}}</a>
            @endif
        </footer>
    </div>

@show