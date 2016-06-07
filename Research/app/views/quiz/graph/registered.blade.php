<!DOCTYPE html>
<html lang="es">
    
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />    
        <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

        <title>  </title>
        <html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/font-awesome.min.css">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-production-plugins.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-production.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-skins.min.css">

        <!-- SmartAdmin RTL Support -->
        <link rel="stylesheet" type="text/css" media="screen" href="/css/smartadmin-rtl.min.css"> 

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update.
        <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

        <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
        <link rel="stylesheet" type="text/css" media="screen" href="/css/demo.min.css">

        <!-- FAVICONS -->
        <link rel="shortcut icon" href="img/favicon/favicon.ico" type="image/x-icon">
        <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">

        <!-- GOOGLE FONT -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- Specifying a Webpage Icon for Web Clip 
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">
            
          
            
        <style>

            body { overflow-x: hidden; }

            @media print {

                            body {-webkit-print-color-adjust: exact;}

                            .impre {display:none;}

                            @page {size: letter; margin: 0.5cm;}
                            
                            .saltopagina{page-break-before:always; }
                        } 

            #head{height:50px;background-color: white; border: 1px solid #c3c3c3;}

            #content{}

            #columns .column {height:auto !important;min-height:400px;width:100%; list-style-type: none;}

            #columns .donus {width:30%;border-radius:0px;border: 1px solid #c3c3c3;margin: 10px 10px;background-color: white;float:left;}
            
            @media screen and (max-width:600px){
                
                #columns .donus {width:95%;border-radius:4px;border: 1px solid #c3c3c3;margin: 3px 3px;background-color: white;float:none;}
            
            }

            #social_network {height:auto !important;min-height:100px;width:30%; }

            #social_network .network { list-style-type: none; }

            #social_network .social_facebook {background-color: #3a589b;width: 20px;height: 20px; margin: 10px;}

            #social_network .social_twitter{background-color: #00acee; width: 20px;height: 20px; margin: 10px;}

            #social_network .social_gmail{background-color: #d0422a; width: 20px;height: 20px; margin: 10px;}

            .header{height: 30px; background-color:#FAFAFA;  border-bottom: 1px solid #C2C2C2;  text-align: center; padding-top: 5px; font-weight: bold;}

            #columns .line {width:93%;border-radius:0px;border: 1px solid #c3c3c3;margin: 1.5% 1%;background-color: white;float:left;}

            #widget{ position: relative;display:block;width:90%;padding:1px 1%;height:40%;}

            .eje_y{position: relative; left:0%; top:0%; font-size: 14px; font-weight: bold;}

            .eje_x{position: relative; left:91%; top:0%; font-size: 14px; font-weight: bold;}

            #registro {height:auto !important;width:30%;position: relative;left:50%;}

            #registro .genero { list-style-type: none; }

            #registro .rgenerom {background-color: #97bbcd;width: 20px;height: 20px; margin: 10px;}

            #registro .rgenerof {background-color: #fc9ac3;width: 20px;height: 20px; margin: 10px;}

            #registro .rgenerot {background-color: #d0422a;width: 20px;height: 20px; margin: 10px;}
            
            .total{text-align:center;}

        </style> 
    
    </head>
    
    <body>
        
        <div id="head">
            <h1 class="impre"></h1>
        </div>
        
        <div id="content">
            
            <div id="columns">
                
                <ul class="column">
                    <li class="donus" id="myPrintArea">
                        <header class="header">Total de Usuarios Registrados</header>
                        <div class="widget-body no-padding" style="width:100%;">
                            <div id="donut-graph-Total" class="chart no-padding" ></div>
                            <div id="social_network">
                                <ul class="network">
                                    <li class="social_facebook"><p style="margin-left: 30px;"><b>Facebook:</b>{{isset($qSocial_network[0])?$qSocial_network[0]->socialNetwork:0;}}</p></li>
                                    <li class="social_twitter"><p style="margin-left: 30px;"><b>Twitter:</b>{{isset($qSocial_network[2])?$qSocial_network[2]->socialNetwork:0;}}</p></li>
                                    <li class="social_gmail"><p style="margin-left: 30px;"><b>Google:</b>{{isset($qSocial_network[1])?$qSocial_network[1]->socialNetwork:0;}}</p></li>
                                </ul>
                            </div>
                            <p class="total"><b>Total:{{isset($socialTotal[0])?$socialTotal[0]->socialNetworkTotal:0;}}</b></p>
                        </div>
                    </li>
                    <li class="donus">
                        <header class="header">Usuarios Registrados Hombres</header>
                        <div class="widget-body no-padding" style="width:100%;">
                        <div id="donut-graph-Hombres" class="chart no-padding"></div>
                            <div id="social_network">
                                <ul class="network">
                                    <li class="social_facebook"><p style="margin-left: 30px;"><b>Facebook:</b>{{isset($qSocialGender[0])?$qSocialGender[0]->ageMale:0;}}</p></li>
                                    <li class="social_twitter"><p style="margin-left: 30px;"><b>Twitter:</b>{{isset($qSocialGender[2])?$qSocialGender[2]->ageMale:0;}}</p></li>
                                    <li class="social_gmail"><p style="margin-left: 30px;"><b>Google:</b>{{isset($qSocialGender[1])?$qSocialGender[1]->ageMale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <p class="total"><b>Total:{{$socialMaleTotal[0]->ageMale}}</b></p>
                        </div>
                    </li>
                    <li class="donus">
                        <header class="header">Usuarios Registrados Mujeres</header>
                        <div class="widget-body no-padding" style="width:100%;">
                            <div id="donut-graph-Mujeres" class="chart no-padding"></div>
                            <div id="social_network">
                                <ul class="network">
                                    <li class="social_facebook"><p style="margin-left: 30px;"><b>Facebook:</b>{{isset($qSocialGender[0])?$qSocialGender[0]->ageFemale:0;}}</p></li>
                                    <li class="social_twitter"><p style="margin-left: 30px;"><b>Twitter:</b>{{isset($qSocialGender[2])?$qSocialGender[2]->ageFemale:0;}}</p></li>
                                    <li class="social_gmail"><p style="margin-left: 30px;"><b>Google:</b>{{isset($qSocialGender[1])?$qSocialGender[1]->ageFemale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <p class="total"><b>Total:{{isset($socialFemaleTotal[0])?$socialFemaleTotal[0]->ageFemale:0;}}</b></p>
                        </div>
                    </li>
                </ul>
                
                <ul class="column">
                    <li class="line">
                        <header class="header">A.1) Total de Usuarios por Edad</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                    <ul class="genero">
                                        <li class="rgenerot"><p style="margin-left: 30px;"><b>Total:</b>{{isset($dataAgeTotal[0])?$dataAgeTotal[0]->ageTotal:0;}}</p></li>
                                    </ul>                                
                            </div>
                            <canvas id="lineChartTEdad" width="100" height="30"></canvas>
                            <div class="eje_x">X:Edad</div>
                        </div>
                    </li>
                    <li class="line">
                        <header class="header">A.2) Usuarios por Edad	</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                <ul class="genero">
                                    <li class="rgenerom"><p style="margin-left: 30px;"><b>Masculino:</b>{{isset($dataAgeMale[0])?$dataAgeMale[0]->ageMale:0;}}</p></li>
                                    <li class="rgenerof"><p style="margin-left: 30px;"><b>Femenino:</b>{{isset($dataAgeFemale[0])?$dataAgeFemale[0]->ageFemale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <canvas id="lineChartEdad" height="80"></canvas>
                            <div class="eje_x">X:Edad</div>
                        </div>    
                    </li>
                    <li class="line">
                        <header class="header">B.1) Total de Registros por Pa&iacute;s</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                    <ul class="genero">
                                        <li class="rgenerot"><p style="margin-left: 30px;"><b>Total:</b>{{isset($dataCountryTotal[0])?$dataCountryTotal[0]->countryTotal:0;}}</p></li>
                                    </ul>                                
                            </div>
                            <canvas id="lineChartTPais" height="80"></canvas>  
                            <div class="eje_x">X:Pa&iacute;s</div>
                        </div>    
                    </li>     
                    <li class="line">
                        <header class="header">B.2) Registros por Pa&iacute;s	</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                <ul class="genero">
                                    <li class="rgenerom"><p style="margin-left: 30px;"><b>Masculino:</b>{{isset($dataCountryMale[0])?$dataCountryMale[0]->countryMale:0;}}</p></li>
                                    <li class="rgenerof"><p style="margin-left: 30px;"><b>Femenino:</b>{{isset($dataCountryFemale[0])?$dataCountryFemale[0]->countryFemale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <canvas id="lineChartPais" height="80"></canvas>  
                            <div class="eje_x">X:Pa&iacute;s</div>
                        </div>    
                    </li>   
                    <li class="line" style="padding-bottom: 6%;">
                        <header class="header">C.1) Total de Registros por D&iacute;a	</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                    <ul class="genero">
                                        <li class="rgenerot"><p style="margin-left: 30px;"><b>Total:</b>{{isset($dataDayTotal[0])?$dataDayTotal[0]->dayTotal:0;}}</p></li>
                                    </ul>                                
                            </div>
                            <canvas id="lineChartTDia" height="80"></canvas> 
                            <div class="eje_x">X:D&iacute;a</div>
                        </div>    
                    </li>

                    <li class="line saltopagina" >
                        <header class="header">C.2) Registro por D&iacute;a		</header>
                        <div id="widget">
                            <div class="eje_y">Y:Registros</div>
                            <div id="registro">
                                <ul class="genero">
                                    <li class="rgenerom"><p style="margin-left: 30px;"><b>Masculino:</b>{{isset($dataDayMale[0])?$dataDayMale[0]->dayMale:0;}}</p></li>
                                    <li class="rgenerof"><p style="margin-left: 30px;"><b>Femenino:</b>{{isset($dataDayFemale[0])?$dataDayFemale[0]->dayFemale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <canvas id="lineChartDia" height="80"></canvas>  
                            <div class="eje_x">X:D&iacute;a</div>
                        </div>    
                    </li>    
                    <li class="line">
                        <header class="header">D.1) Total de Registros por Estado		</header>
                        <div id="widget">
                            <div class="eje_y">X:Registros</div>
                            <div id="registro">
                                    <ul class="genero">
                                        <li class="rgenerot"><p style="margin-left: 30px;"><b>Total:</b>{{isset($dataStateTotal[0])?$dataStateTotal[0]->stateTotal:0;}}</p></li>
                                    </ul>                                
                            </div>
                            <canvas id="lineChartTEstado" height="80"></canvas> 
                            <div class="eje_x">Y:Estado</div>
                        </div>    
                    </li> 
                    <li class="line" style="padding-bottom: 6%;">
                        <header class="header">D.2) Registros por Estado</header>
                        <div id="widget">
                            <div class="eje_y">X:Registros</div>
                            <div id="registro">
                                <ul class="genero">
                                    <li class="rgenerom"><p style="margin-left: 30px;"><b>Masculino:</b>{{isset($dataStateMale[0])?$dataStateMale[0]->stateMale:0;}}</p></li>
                                    <li class="rgenerof"><p style="margin-left: 30px;"><b>Femenino:</b>{{isset($dataStateFemale[0])?$dataStateFemale[0]->stateFemale:0;}}</p></li>
                                </ul>                                
                            </div>
                            <canvas id="lineChartEstado" height="80"></canvas> 
                            <div class="eje_x">Y:Estado</div>
                        </div>    
                    </li> 
                    
                    <li class="line impre">
                        
                        <header class="header"> E) Registros por Horas</header>

                        <div class="form-group" style="position: relative; width: 100%; text-align: left;">
                            {{Form::label('','Selecciona el dia:',array('class'=>'section'))}}
                            <div class="input-group ">
                                <span class="input-group-addon">
                                    <input type="text" name="datePicker" placeholder="" class="datepicker" data-dateformat='dd/mm/yy' id="dataHours">
                                    {{Form::submit('Registro',array('type'=>'button','class'=>'btn btn-primary','id'=>'button_registro'))}}
                                </span>
                            </div>
                            
                        </div>
                        
                    </li>
                    
                    <div id="line"></div>
                    
                </ul>
                
            </div>
            
        </div>


        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="/js/plugin/pace/pace.min.js"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script>
                if (!window.jQuery) {
                        document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
                }
        </script>

        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script>
                if (!window.jQuery.ui) {
                        document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
                }
        </script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="/js/app.config.js"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

        <!-- BOOTSTRAP JS -->
        <script src="/js/bootstrap/bootstrap.min.js"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="/js/notification/SmartNotification.min.js"></script>

        <!-- JARVIS WIDGETS -->
        <script src="/js/smartwidgets/jarvis.widget.min.js"></script>

        <!-- EASY PIE CHARTS -->
        <script src="/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

        <!-- SPARKLINES -->
        <script src="/js/plugin/sparkline/jquery.sparkline.min.js"></script>

        <!-- JQUERY VALIDATE -->
        <script src="/js/plugin/jquery-validate/jquery.validate.min.js"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="/js/plugin/select2/select2.min.js"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

        <!-- browser msie issue fix -->
        <script src="/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

        <!-- FastClick: For mobile devices -->
        <script src="/js/plugin/fastclick/fastclick.min.js"></script>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- Demo purpose only -->
        <script src="/js/demo.min.js"></script>

        <!-- MAIN APP JS FILE -->
        <script src="/js/app.min.js"></script>

        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <!-- Voice command : plugin -->
        <script src="/js/speech/voicecommand.min.js"></script>

        <!-- SmartChat UI : plugin -->
        <script src="/js/smart-chat-ui/smart.chat.ui.min.js"></script>
        <script src="/js/smart-chat-ui/smart.chat.manager.min.js"></script>

        <!-- PAGE RELATED PLUGIN(S) -->

        <!-- Morris Chart Dependencies -->
        <script src="/js/plugin/morris/raphael.min.js"></script>
        <script src="/js/plugin/morris/morris.min.js"></script> 

        <script>
            
            
                var myarray = [];
                
                $("#button_registro").click(function() {
                    
                    datepicker = $('.datepicker').val();
                    
                    $.ajax({
                        url:'/report-registered/{{$contest_id}}',
                        type:'get',
                        data:{'datepicker':datepicker},
                        success: function(data){
                            
                            if (data) {
                                
                                if($.inArray($('.datepicker').val(), myarray)!== -1) {
                                    
                                    alert("El Registro ya Fue Agregado !");
                                    
                                } else {
                                    
                                            if(Object.keys(JSON.parse(data.dataHours)).length != 0){
                                                
                                                    myarray.push(datepicker);
                                                    
                                                    if($('.datepicker').length > 0 && datepicker != ""){

                                                            $('#line').append('<li class="line" style="padding-bottom: 2.5%;">\n\
                                                                                    <header class="header">Total de Registros por Horas ('+datepicker+')</header>\n\
                                                                                    <div id="widget">\n\
                                                                                        <div class="eje_y">Y:Registros</div>\n\
                                                                                        <div id="registro">\n\
                                                                                            <ul class="genero">\n\
                                                                                                <li class="rgenerot"><p style="margin-left: 30px;">Total:'+Object.keys(JSON.parse(data.dataHours)).length+'</p></li>\n\
                                                                                            </ul>\n\
                                                                                        </div>\n\
                                                                                        <canvas id="'+datepicker+'T" height="80"></canvas>\n\
                                                                                        <div class="eje_x">X:Horas</div>\n\
                                                                                    </div>\n\
                                                                                </li>');

                                                            $('#line').append('<li class="line" style="padding-bottom: 2.5%;">\n\
                                                                                    <header class="header">Total de Registros por Horas ('+datepicker+')</header>\n\
                                                                                    <div id="widget">\n\
                                                                                        <div class="eje_y">Y:Registros</div>\n\
                                                                                        <div id="registro">\n\
                                                                                            <ul class="genero">\n\
                                                                                                <li class="rgenerom">\n\
                                                                                                    <p style="margin-left: 30px;">Masculino:'+Object.keys(JSON.parse(data.dataHoursMale)).length+'</p>\n\
                                                                                                </li>\n\
                                                                                                <li class="rgenerof">\n\
                                                                                                    <p style="margin-left: 30px;">Femenino:'+Object.keys(JSON.parse(data.dataHoursFemale)).length+'</p>\n\
                                                                                                </li>\n\
                                                                                            </ul>\n\
                                                                                        </div>\n\
                                                                                        <canvas id="'+datepicker+'" height="80"></canvas>\n\
                                                                                        <div class="eje_x">X:Horas</div>\n\
                                                                                    </div>\n\
                                                                                </li>');

                                                            function init() {

                                                                pageSetUp();

                                                                var x = data.dataHours;
                                                                var element = JSON.parse(x);

                                                                dataHours = [];
                                                                dataHoursTotal = [];
                                                                dataHoursMale = [];
                                                                dataHoursFemale = [];

                                                                for(i=0;i<Object.keys(element).length;i++){

                                                                    console.log(element[i].hours);

                                                                    dataHours[i] = element[i].hours;
                                                                    dataHoursTotal[i] = element[i].hoursTotal;
                                                                    dataHoursMale[i] = element[i].hoursMale;
                                                                    dataHoursFemale[i] = element[i].hoursFemale;

                                                                }                                    


                                                                var lineDataRT = { labels: dataHours,
                                                                                    datasets: [
                                                                                            {
                                                                                                label: "My First dataset",
                                                                                                fillColor: "rgba(208,66,42,0.2)",
                                                                                                strokeColor: "rgba(208,66,42,1)",
                                                                                                pointColor: "rgba(208,66,42,1)",
                                                                                                pointStrokeColor: "#fff",
                                                                                                pointHighlightFill: "#fff",
                                                                                                pointHighlightStroke: "rgba(208,66,42,1)",
                                                                                                data: dataHoursTotal
                                                                                            }
                                                                                        ]
                                                                };
                                                                var ctxRT = document.getElementById(datepicker+'T').getContext("2d");
                                                                var myNewChartRT = new Chart(ctxRT).Line(lineDataRT, lineOptions);

                                                                var lineDataR = { labels: dataHours,
                                                                    datasets: [
                                                                            {
                                                                                label: "My First dataset",
                                                                                fillColor: "rgba(252,154,195,0.2)",
                                                                                strokeColor: "rgba(252,154,195,1)",
                                                                                pointColor: "rgba(252,154,195,1)",
                                                                                pointStrokeColor: "#fff",
                                                                                pointHighlightFill: "#fff",
                                                                                pointHighlightStroke: "rgba(220,220,220,1)",
                                                                                data: dataHoursFemale
                                                                            },
                                                                            {
                                                                                label: "My Second dataset",
                                                                                fillColor: "rgba(151,187,205,0.2)",
                                                                                strokeColor: "rgba(151,187,205,1)",
                                                                                pointColor: "rgba(151,187,205,1)",
                                                                                pointStrokeColor: "#fff",
                                                                                pointHighlightFill: "#fff",
                                                                                pointHighlightStroke: "rgba(151,187,205,1)",
                                                                                data: dataHoursMale 
                                                                            }
                                                                        ]
                                                                };
                                                                var ctxR = document.getElementById(datepicker).getContext("2d");
                                                                var myNewChartR = new Chart(ctxR).Line(lineDataR, lineOptions);
                                                            };
                                                            init();      
                                                        }

                                            }else{alert("No existen registros !");}
                                    } 
                                
                            }
                            
                        }

                    });                    
                });    
        </script> 
        
        <script type="text/javascript">
            
                $(document).ready(function() {
                    
                        pageSetUp();
                        
                        if ($('#donut-graph-Total').length) {
                                Morris.Donut({
                                        element : 'donut-graph-Total',
                                        data : [{
                                                value : <?=round(((isset($qSocial_network[0])?$qSocial_network[0]->socialNetwork:0)*100)/(($socialTotal[0]->socialNetworkTotal)>0?$socialTotal[0]->socialNetworkTotal:1),2);?>,
                                                label : 'Facebook'
                                        }, {
                                                value : <?=round(((isset($qSocial_network[2])?$qSocial_network[2]->socialNetwork:0)*100)/(($socialTotal[0]->socialNetworkTotal)>0?$socialTotal[0]->socialNetworkTotal:1),2);?>,
                                                label : 'Twitter'
                                        }, {
                                                value : <?=round(((isset($qSocial_network[1])?$qSocial_network[1]->socialNetwork:0)*100)/(($socialTotal[0]->socialNetworkTotal)>0?$socialTotal[0]->socialNetworkTotal:1),2);?>,
                                                label : 'Google'
                                        }],
                                        formatter : function(x) {
                                                return x + "%"
                                        }
                                });
                        } 
                        
                        if ($('#donut-graph-Hombres').length) {
                                Morris.Donut({
                                        element : 'donut-graph-Hombres',
                                        data : [{
                                                value : <?=round(((isset($qSocialGender[0])?$qSocialGender[0]->ageMale:0)*100)/(($socialMaleTotal[0]->ageMale)>0?$socialMaleTotal[0]->ageMale:1),2);?>,
                                                label : 'Facebook'
                                        }, {
                                                value : <?=round(((isset($qSocialGender[2])?$qSocialGender[2]->ageMale:0)*100)/(($socialMaleTotal[0]->ageMale)>0?$socialMaleTotal[0]->ageMale:1),2);?>,
                                                label : 'Twitter'
                                        }, {
                                                value : <?=round(((isset($qSocialGender[1])?$qSocialGender[1]->ageMale:0)*100)/(($socialMaleTotal[0]->ageMale)>0?$socialMaleTotal[0]->ageMale:1),2);?>,
                                                label : 'Google'
                                        }],
                                        formatter : function(x) {
                                                return x + "%"
                                        }
                                });
                        }
                        
                        if ($('#donut-graph-Mujeres').length) {
                                Morris.Donut({
                                        element : 'donut-graph-Mujeres',
                                        data : [{
                                                value : <?=round(((isset($qSocialGender[0])?$qSocialGender[0]->ageFemale:0)*100)/(($socialFemaleTotal[0]->ageFemale)>0?$socialFemaleTotal[0]->ageFemale:1),2);?>,
                                                label : 'Facebook'
                                        }, {
                                                value : <?=round(((isset($qSocialGender[2])?$qSocialGender[2]->ageFemale:0)*100)/(($socialFemaleTotal[0]->ageFemale)>0?$socialFemaleTotal[0]->ageFemale:1),2);?>,
                                                label : 'Twitter'
                                        }, {
                                                value : <?=round(((isset($qSocialGender[1])?$qSocialGender[1]->ageFemale:0)*100)/(($socialFemaleTotal[0]->ageFemale)>0?$socialFemaleTotal[0]->ageFemale:1),2);?>,
                                                label : 'Google'
                                        }],
                                        formatter : function(x) {
                                                return x + "%"
                                        }
                                });
                        }   
                });
        </script>

        <script src="/js/plugin/chartjs/chart.min.js"></script>
        
        <script type="text/javascript">
            
            lineOptions = {
                        ///Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines : true,
                        //String - Colour of the grid lines
                        scaleGridLineColor : "rgba(0,0,0,.05)",
                        //Number - Width of the grid lines
                        scaleGridLineWidth : 1,
                        //Boolean - Whether the line is curved between points
                        bezierCurve : true,
                        //Number - Tension of the bezier curve between points
                        bezierCurveTension : 0.4,
                        //Boolean - Whether to show a dot for each point
                        pointDot : true,
                        //Number - Radius of each point dot in pixels
                        pointDotRadius : 4,
                        //Number - Pixel width of point dot stroke
                        pointDotStrokeWidth : 1,
                        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                        pointHitDetectionRadius : 20,
                        //Boolean - Whether to show a stroke for datasets
                        datasetStroke : true,
                        //Number - Pixel width of dataset stroke
                        datasetStrokeWidth : 2,
                        //Boolean - Whether to fill the dataset with a colour
                        datasetFill : true,
                        //Boolean - Re-draw chart on page resize
                        responsive: true,
                        //String - A legend template
                        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
                };
                
            $(document).ready(function() {

                pageSetUp();
//---------------------- Usuarios Registrados por Edad ------------------------// 
                var x = '<?php print_r($dataAge);?>';
                var element = JSON.parse(x);
                
                dataAge = [];
                dataAgeTotal = [];
                dataAgeMale = [];
                dataAgeFemale = [];

                for(i=0;i<Object.keys(element).length;i++){
                       
                    dataAge[i] = element[i].age;
                    dataAgeTotal[i] = element[i].ageTotal;
                    dataAgeMale[i] = element[i].ageMale;
                    dataAgeFemale[i] = element[i].ageFemale;
                    
                }
                
                var lineDataTEdad = { labels:dataAge,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(208,66,42,0.2)",
                                strokeColor: "rgba(208,66,42,1)",
                                pointColor: "rgba(208,66,42,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(208,66,42,1)",
                                data: dataAgeTotal
                            }
                        ]
                }; 
                var ctxTEdad = document.getElementById("lineChartTEdad").getContext("2d");
                var myNewChartTEdad = new Chart(ctxTEdad).Line(lineDataTEdad, lineOptions);               
                
                var lineDataEdad = { labels:dataAge,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(252,154,195,0.2)",
                                strokeColor: "rgba(252,154,195,1)",
                                pointColor: "rgba(252,154,195,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: dataAgeFemale
                            },
                            {
                                label: "My Second dataset",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: dataAgeMale
                            }
                        ]
                };
                var ctxEdad = document.getElementById("lineChartEdad").getContext("2d");
                var myNewChartEdad = new Chart(ctxEdad).Line(lineDataEdad, lineOptions);

//-----------------------------------------------------------------------------//

                var dCountry = '<?php print_r($dataCountry);?>';
                var jCountry = JSON.parse(dCountry);
                
                dataCountry = [];
                dataCountryTotal = [];
                dataCountryMale = [];
                dataCountryFemale = [];

                for(i=0;i<Object.keys(jCountry).length;i++){
                       
                    dataCountry[i] = jCountry[i].country;
                    dataCountryTotal[i] = jCountry[i].countryTotal;
                    dataCountryMale[i] = jCountry[i].countryMale;
                    dataCountryFemale[i] = jCountry[i].countryFemale;
                    
                } 

                var lineDataTPais = { labels:dataCountry,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(208,66,42,0.2)",
                                strokeColor: "rgba(208,66,42,1)",
                                pointColor: "rgba(208,66,42,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(208,66,42,1)",
                                data: dataCountryTotal 
                            }
                        ]
                };
                    
                var ctxTPais = document.getElementById("lineChartTPais").getContext("2d");
                var myNewChartTPais = new Chart(ctxTPais).Line(lineDataTPais, lineOptions);   

                var lineDataPais = { labels:dataCountry,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(252,154,195,0.2)",
                                strokeColor: "rgba(252,154,195,1)",
                                pointColor: "rgba(252,154,195,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: dataCountryFemale
                            },
                            {
                                label: "My Second dataset",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: dataCountryMale
                            }
                        ]
                };
                    
                var ctxPais = document.getElementById("lineChartPais").getContext("2d");
                var myNewChartPais = new Chart(ctxPais).Line(lineDataPais, lineOptions); 
//-----------------------------------------------------------------------------//

                var dDay = '<?php print_r($dataDay);?>';
                var jDay = JSON.parse(dDay);
                
                dataDay = [];
                dataDayTotal = [];
                dataDayMale = [];
                dataDayFemale = [];

                for(i=0;i<Object.keys(jDay).length;i++){
                       
                    dataDay[i] = jDay[i].dia;
                    dataDayTotal[i] = jDay[i].dayTotal;
                    dataDayMale[i] = jDay[i].dayMale;
                    dataDayFemale[i] = jDay[i].dayFemale;
                    
                } 
                
                var lineDataTDia = { labels: dataDay,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(208,66,42,0.2)",
                                strokeColor: "rgba(208,66,42,1)",
                                pointColor: "rgba(208,66,42,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(208,66,42,1)",
                                data: dataDayTotal
                            }
                        ]
                };

                var ctxTDia = document.getElementById("lineChartTDia").getContext("2d");
                var myNewChartTDia = new Chart(ctxTDia).Line(lineDataTDia, lineOptions);   
              
                var lineDataDia = { labels: dataDay,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(252,154,195,0.2)",
                                strokeColor: "rgba(252,154,195,1)",
                                pointColor: "rgba(252,154,195,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: dataDayFemale
                            },
                            {
                                label: "My Second dataset",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: dataDayMale
                            }
                        ]
                };

                var ctxDia = document.getElementById("lineChartDia").getContext("2d");
                var myNewChartDia = new Chart(ctxDia).Line(lineDataDia, lineOptions);
              
//-----------------------------------------------------------------------------/   

                var dState = '<?php print_r($dataState);?>';
                var jState = JSON.parse(dState);
                
                dataState = [];
                dataStateTotal = [];
                dataStateMale = [];
                dataStateFemale = [];

                for(i=0;i<Object.keys(jState).length;i++){
                       
                    dataState[i] = jState[i].state;
                    dataStateTotal[i] = jState[i].stateTotal;
                    dataStateMale[i] = jState[i].stateMale;
                    dataStateFemale[i] = jState[i].stateFemale;
                    
                } 

                var lineDataTEstado = { labels: dataState,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(208,66,42,0.2)",
                                strokeColor: "rgba(208,66,42,1)",
                                pointColor: "rgba(208,66,42,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(208,66,42,1)",
                                data: dataStateTotal
                            }
                        ]
                };
                
                var ctxTEstado = document.getElementById("lineChartTEstado").getContext("2d");
                var myNewChartTEstado = new Chart(ctxTEstado).Line(lineDataTEstado, lineOptions); 
                
                var lineDataEstado = { labels: dataState,
                    datasets: [
                            {
                                label: "My First dataset",
                                fillColor: "rgba(252,154,195,0.2)",
                                strokeColor: "rgba(252,154,195,1)",
                                pointColor: "rgba(252,154,195,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: dataStateFemale
                            },
                            {
                                label: "My Second dataset",
                                fillColor: "rgba(151,187,205,0.2)",
                                strokeColor: "rgba(151,187,205,1)",
                                pointColor: "rgba(151,187,205,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointHighlightStroke: "rgba(151,187,205,1)",
                                data: dataStateMale
                            }
                        ]
                };

                var ctxEstado = document.getElementById("lineChartEstado").getContext("2d");
                var myNewChartEstado = new Chart(ctxEstado).Line(lineDataEstado, lineOptions);
                                         
                });
                
        </script>                 
        
    </body>

</html>