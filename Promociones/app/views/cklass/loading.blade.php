<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <style type="text/css">
/* centered columns styles */
.row-centered {
    text-align:center;
}
.col-centered {
    display:inline-block;
    float:none;
    /* reset the text-align */
    text-align:left;
    /* inline-block space fix */
    margin-right:-4px;
}
.col-fixed {
    /* custom width */
    width:320px;
}
.col-min {
    /* custom min width */
    min-width:320px;
}
.col-max {
    /* custom max width */
    max-width:320px;
}

/* visual styles */
body {
    padding-bottom:40px;
}
h1 {
    margin:40px 0px 20px 0px;
    color:#FFF;
    font-size:28px;
    line-height:34px;
    text-align:center;
}

h1 a{
    color:#FFF;
}
[class*="col-"] {
    padding-top:10px;
    padding-bottom:15px;
    /*border:1px solid #80aa00;*/
    /*background:#d6ec94;*/
}
[class*="col-"]:before {
    display:block;position:relative;
    /*content:"COLUMN";*/
    margin-bottom:8px;
    font-family:sans-serif;
    font-size:10px;
    letter-spacing:1px;
    /*color:#658600;*/
    text-align:left;
}
.item {
    width:100%;
    height:100%;
    /*border:1px solid #cecece;*/
    padding:16px 8px;
    /*background:#ededed;*/
    /*background:-webkit-gradient(linear, left top, left bottom,color-stop(0%, #f4f4f4), color-stop(100%, #ededed));
    background:-moz-linear-gradient(top, #f4f4f4 0%, #ededed 100%);
    background:-ms-linear-gradient(top, #f4f4f4 0%, #ededed 100%);*/
}

/* content styles */
.item {
    display:table;
}
.content {
    display:table-cell;
    vertical-align:middle;
    text-align:center;
}
.content:before {
    /*content:"Content";*/
    font-family:sans-serif;
    font-size:12px;
    letter-spacing:1px;
    /*color:#747474;*/
}

/* centering styles for jsbin */
html,
body {
    width:100%;
    height:100%;
    background-color: #000;
}
html {
    display:table;
}
body {
    display:table-cell;
    vertical-align:middle;
}
        </style>
    </head>
    <body>

<div class="container">
    <div class="row row-centered">
        <div class="full-video">

            <div class="col-xs-12 col-md-6  col-centered"><div class="item"><div class="content">
            <div class="cerrarv video-f"><i class="icon-close"></i></div>
            <div class="cont-full slideDownVideo">

                                <div class="box_content" id="content_iframe">
                                    <span class="text-box"><h1>Cargando Video</h1></span>
                                    

                                </div>

                            </div>

                        </div></div></div>
            </div>
    </div>
</div>




        
    
<script>

var onPlayEvent = function() {
        var url = (window.location != window.parent.location)
                    ? document.referrer
                    : document.location;

        if (url.indexOf("://") > -1) {  
        domain = url.split('/')[2];
        protocol = url.split('/')[0]+ "//";

    }
    else {
        domain = url.split('/')[0];
        protocol = "http://"
    }
    domain = protocol + domain;

        data={"videoId" : {{$videoId}}};
            try {
            window.parent.postMessage(data, "http://television.televisa.com/");
        }
        catch (error) {
            console.log("El error :" + error);
                console.log("El dominio :" + domain);
        }
      
    }

    onPlayEvent();
</script>



    </body>
</html>