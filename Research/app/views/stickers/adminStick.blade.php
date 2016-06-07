@extends(Config::get( 'app.main_template' ).'.main')
@section('heads')
<!--
    /*******************************************************************/
    *                                                                   *
    *                                css                                *
    *                                                                   *
    /*******************************************************************/
-->
<link rel="stylesheet" href="{{asset('/css/stickers-admin.css')}}"/>
</style>
@endsection
@section('content')
<div id="girdCard"></div>
<button type="button" id="saveAll" class="btn-success btn-lg"><i id="saving" class="fa fa-save"></i></button>
@endsection
@section("scripts")
@parent
<!--
    /******************************************************************/
    *                                                                  *
    *                           scripts.js                             *
    *                                                                  *
    /******************************************************************/
-->
<script type="text/javascript">
    /******************************************************************/
    /* valida sitio y orientacion.                                    */
    /******************************************************************/
    $(document).ready(function() {
        mySite();
        downloadFlipCard();
    });
    /******************************************************************/
    $(document).on('keyup', 'input', function() {
        btnFa= $("#saving");
        btnFa.removeAttr("class").addClass('fa fa-save');
    })
    $(document).on('keyup', 'textarea', function() {
        btnFa= $("#saving");
        btnFa.removeAttr("class").addClass('fa fa-save');
    })
    /******************************************************************/
    $(document).on("click", "#saveAll", function(event) {
        var objects= ($("#girdCard").children());
        arr = {};
        $.each(objects, function(i, x){
            var myID= $(x)[0].id;
            var img = $('#img_'+myID)[0].src;
            var descripcion= ($("#ta_"+myID).val());
            var title = ($("#it_"+myID).val());
            arr[myID] = [img, descripcion, title];
        })
        $.ajax({
            url:"/admin-stickers/edit-stickers",
            type : "post",
            data:{site: site, data: arr},
            beforeSend: function() {
                btnFa= $("#saving");
                btnFa.removeClass("fa-save").addClass('fa-refresh fa-spin');
            },
            success: function (data){
                btnFa.removeClass("fa-refresh fa-spin").addClass('fa-check');
            },
            error: function(xhr, status, error) {
                console.log(status);
                btnFa.removeAttr("class").addClass('fa fa-save');
            },
        });
    })
    /******************************************************************/
    /* Se obtiene el nombre del site a partir de la url              */
    /******************************************************************/
    var mySite = function() {
        url  = $(location).attr('href');
        siteFull = url.split('/').pop();
        host = $(location).attr('hostname');
        newVar = (siteFull.split("?")[1]);
        newVar2 = (newVar.split("&"));
        $.each(newVar2, function(i, data){
            newVar3 = (data.split("="));
            if (newVar3[0] == "site") {
                site =  newVar3[1];
            }
        })
        promociones=  "promociones.sinpk2.com";
        if (host == "research.televisa.com.mx" || host == "gigya.televisa.com"){
            promociones=  "promociones.televisa.com.mx";
        }
        else {
            promociones=  "promociones.sinpk2.com";
        }
        return promociones;
    }
    var downloadFlipCard = function() {
        $.ajax({
            url: "//"+promociones+"/stickers/flip-card",
            dataType: 'jsonp',
            data: {site: site},
            jsonpCallback: "getFlipCard",
            error: function(xhr, status, error) {
                console.log(status);
            },
        });
    }
    var getFlipCard = function(data) {
        if (data.status == 404) {
            html_c=      '<H1>Sin información del álbum</H1';
            $("#girdCard").html(html_c);
        } else {
            html_b='';
            $.each(data.allStickers, function(i, x){
                $.each(x, function(key, y){
                    html_b+=      '<div class="col-xs-4 col-md-2" id="'+key+'">'+
                    '<div class="flip-container">'+
                    '<div class="thumbnail-container">'+
                    '<div class="flipper">'+
                    '<div class="thumbnail-body front">'+
                    '<img class="img-responsive thumbnail-img" id="img_'+key+'" src="'+y[0]+'" alt="'+key+'"/>'+
                    '</div>'+
                    '<div class="thumbnail-body back">'+
                    '<div class="textBack smart-form">'+
                    '<label class="textarea">'+
                    '<textarea class="myTextArea" id="ta_'+key+'" placeholder="descripción" name="descripcion" rows="11"></textarea>'+
                    '</label>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '<div class="thumbnail-footer">'+
                    '<div class="form-group">'+
                    '<input class="form-control" id="it_'+key+'" placeholder="title-'+key+'" name="title" type="text">'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                })
            });
            $("#girdCard").html(html_b);
            $.each(data.allStickers, function(k, z){
                $.each(z, function(key, object){
                    var title=object[2];
                    var description=object[1];
                    if (title != "null") {
                        $("#it_"+key).val(title);
                    };
                    if (description != "null") {
                        $("#ta_"+key).val(description);
                    };
                })
            });
        }
    }
</script>
@endsection
