@section('footer')
    <style type="text/css">
    @if (isset($info->properties['UrlImgLogo']))
        .c5-logof{
            background-image: url('/img/ninos/r_logo_640.png');
            background-repeat: no-repeat;
        }
        footer.c5-footer .c5-logof{
            height: 48px;
            width: 65px;
        }
        
    @endif
    </style>
    <div class="container-footer">
        <footer class="c5-footer">
            <div class="c5-logof">
                <a href="http://ninos.televisa.com/" title="logotipo {{isset($info->properties['channel'])?$info->properties['channel']:''}}" target="_blank">
            
                </a>
            </div>
        </footer>
    </div>

@show