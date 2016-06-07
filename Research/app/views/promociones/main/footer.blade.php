@section('footer')

    <div class="container-footer">
        <footer class="c5-footer">
            <div class="c5-logof">
                <a href="http://www.televisa.com/canal5/" title="logotipo canal 5" target="_blank">
                    <i class="c5-logo"></i>
                </a>
            </div>
            <div class="c5-txtf">{{Lang::get('promociones.footerMsg')}}
            <a href="#1">{{Lang::get('promociones.footerBc')}}</a>, 
            <a href="#2">{{Lang::get('promociones.footerAp')}}</a>, 
            <a href="#3">{{Lang::get('promociones.footerTc')}}</a></div>
        </footer>
    </div>

@show