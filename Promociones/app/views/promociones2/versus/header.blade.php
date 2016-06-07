@section('header')
<style type="text/css">

    @if (isset($info->properties['UrlImgLogo']))
        div#tui-logo{
                background-image: url({{isset($info->properties['UrlImgLogo'])?$info->properties['UrlImgLogo']:'';}});
                height: 60px;
                width: 60px;
        
        }
    @endif

</style>   

<header>
    <div class="header-promo">
        <div class="cintillo-promo">
            <div id="tui-logo">
                <a href="http://www.televisa.com/canal5/" target="_blank">
                    @if (!isset($info->properties['UrlImgLogo']))
                        <i class="c5-logo"></i>
                    @endif
    
                </a>
            </div>
            <section id="cintillo" class="cintillo-bar-back">
                <div class="tui-wrapper-bar-content cintillo">
                    <div class="cintillo-left">
                        <p class="cintillo_t">
                            <a href="http://www.televisa.com/canal5/" target="_blank">{{isset($info->properties['titlePleca'])?$info->properties['titlePleca']:''}}</a>
                        </p>
                        <!--p class="caption">Participa y gana</p-->
                    </div>
                </div>
            </section>
            <!--div class="shareall">
                <div class="mobile">
                    <div id="open2" class="a-btn close">
                        <div class="a-btn-slide-show">
                            <div>
                                <a href="mailto:?subject={{(isset($info->properties['namePromotion']))?$info->properties['namePromotion']:''}}&amp;body=http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}" class="cintillo_t">
                                    <i class="c5-mensaje"></i>
                                </a>
                            </div>
                            <div>
                                <a href="https://twitter.com/home?status={{(isset($info->properties['namePromotion']))?$info->properties['namePromotion']:''}} - http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=626,height=436');return false;" class="cintillo_t">
                                    <i class="c5-twitter"></i>
                                </a>
                            </div>
                            <div>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=626,height=436');return false;" class="cintillo_t"> 
                                    <i class="c5-facebook"></i>
                                </a>
                            </div>
                            <div>
                                <a href="https://pinterest.com/pin/create/button/?url=http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}&amp;media=&amp;description={{(isset($info->properties['namePromotion']))?$info->properties['namePromotion']:''}}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=626,height=436');return false;" class="cintillo_t">
                                    <i class="c5-pinterest"></i>
                                </a>
                            </div>
                            <div>
                                <a href="https://plus.google.com/share?url=http://tvsa.mx/{{(isset($info->properties['shortUrlContest']))?$info->properties['shortUrlContest']:''}}" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=626,height=436');return false;" class="cintillo_t">
                                    <i class="c5-plus"></i>
                                </a>
                            </div>
                        </div>
                        <a class="a-btn-icon-right icon">
                            <i class="canal-5 c5-share"></i>
                        </a>
                    </div>
                </div>
            </div-->

        </div>
    </div>
</header>
<!-- END: HEADER -->
    
@show