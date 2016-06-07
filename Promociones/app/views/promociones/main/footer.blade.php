@section('footer')

    <div class="container-footer">
        <footer class="c5-footer">
            <div class="c5-logof">
                <a href="http://www.televisa.com/canal5/" title="logotipo canal 5" target="_blank">
                    <i class="c5-logo"></i>
                </a>
            </div>
            @if(isset($short_name))
            <div class="c5-txtf">{{Lang::get('promociones.footerMsg')}}
            <a href="/canal5/{{{ isset($short_name) ? $short_name : '' }}}/bases-concurso" target="_blank">{{Lang::get('promociones.footerBc')}}</a>, 
            <a href="/canal5/{{{ isset($short_name) ? $short_name : '' }}}/aviso-privacidad" target="_blank">{{Lang::get('promociones.footerAp')}}</a>, 
            Permiso DG/0392/15
            
            @endif
        </footer>
    </div>

@show