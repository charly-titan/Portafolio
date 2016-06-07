@section('scripts_googleTagService')

@if (isset($info) & $info->properties["advertisingOption"]==1)

    <script type="text/javascript">(function() { var useSSL = 'https:' == document.location.protocol; var src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js'; document.write('<scr' + 'ipt s' +'rc="' + src + '"></scr' + 'ipt>'); })();</script>
    
    <script type="text/javascript" >
    var mappingBanner = googletag.sizeMapping().
        addSize([980,140],[300,250]). //Desktop
        addSize([740, 140], [728,90]). //Tablets.
        addSize([320, 140], [320, 50]). // Iphones.
        addSize([0, 140], []).
        build();

    var mapping01 = googletag.sizeMapping().
        addSize([948,140],[728,90]). //Desktop
        addSize([607, 140],[728,90]). // Tablet.
        addSize([200, 140], [320,50]). // Mobile.
        build(); 

        var  parameterUnit = '{{(isset($adUnit))?$adUnit:null}}';
    
        (parameterUnit) ? adUnit = "es.televisa.ent/canal-5/promociones/"+parameterUnit : adUnit = "es.televisa.ent/canal-5/promociones";

        //  var adUnit = "es.televisa.ent/canal-5/promociones/cierre";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/confirmacion";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/espera";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/frase";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/gracias";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/login";
        //  var adUnit = "es.televisa.ent/canal-5/promociones/previo";
            var promo= "fast-and-furious";
            var superbanner = googletag.defineSlot("/5644/"+adUnit, [300,250],"ban01_televisa")
            .defineSizeMapping(mappingBanner)
            .addService(googletag.pubads())
            .setCollapseEmptyDiv(true)
            .setTargeting("position","btf");

            var slot01 = googletag.defineSlot("/5644/"+adUnit, [728,90],'ban01_versus')
            .defineSizeMapping(mapping01)
            .addService(googletag.pubads())
            .setCollapseEmptyDiv(true)
            .setTargeting('position', 'atf');

            var slot03 = googletag.defineSlot("/5644/"+adUnit, [728,90],'ban03_versus')
            .defineSizeMapping(mapping01)
            .addService(googletag.pubads())
            .setTargeting('position', 'atf')
            .setCollapseEmptyDiv(true);
            
            var PotesSponsor = googletag.defineOutOfPageSlot("/5644/"+adUnit, "oop-ad")
            .addService(googletag.pubads())
            .setTargeting("intertype","layer");

            googletag.pubads().enableSingleRequest();
            googletag.pubads().setTargeting("promocion", promo);
            googletag.pubads().enableSyncRendering();
            googletag.enableServices();
    </script>
@endif

@show