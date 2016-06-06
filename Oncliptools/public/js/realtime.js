$(function(){
    function pageLoad(){
        var seriesData = [ [], [], [], [] ];
        //var random = new Rickshaw.Fixtures.RandomData(1);
        var palette = new Rickshaw.Color.Palette( { scheme: 'colorwheel' } );
        var contador=0,start=0,end=0;

        var today = new Date();
        var tiempo=(today.getTime()/1000)-(6*3600);
        for (var i = 0; i < 4 ; i++) {
            temp=[];
            for (var j = 0; j < 360 ; j++) {
                temp[359-j]={x:tiempo-(j*10), y: Math.floor((Math.random() * 100) + 1)}
            }
            seriesData[i]=temp;
        }
        //console.log(seriesData);

// instantiate our graph!
        var graph = new Rickshaw.Graph( {
            element: document.getElementById("realtime-chart"),
            width: $("#chart-container").width(),
            height: 100,
            renderer: 'line',
            stroke: true,
            preserve: true,
            series: [{
                color: 'steelblue',
                data: seriesData[0],
                name: ''
            }
            ]
        } );

        graph.render();

        PjaxApp.onResize(function(){
            graph.width = $("#chart-container").width();
            graph.render();
        });

        var hoverDetail = new Rickshaw.Graph.HoverDetail( {
            graph: graph,
            //xFormatter: function(x) { return x + "seconds" },
            yFormatter: function(y) { return "Click para crear corte" }
        } );

        var annotator = new Rickshaw.Graph.Annotate( {
            graph: graph,
            element: document.getElementById('timeline')
        } );

        var legend = new Rickshaw.Graph.Legend( {
            graph: graph,
            element: document.getElementById('legend')

        } );

        var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
            graph: graph,
            legend: legend
        } );

        var order = new Rickshaw.Graph.Behavior.Series.Order( {
            graph: graph,
            legend: legend
        } );

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight( {
            graph: graph,
            legend: legend
        } );

        var ticksTreatment = 'glow';

        var xAxis = new Rickshaw.Graph.Axis.Time( {
            graph: graph,
            ticksTreatment: ticksTreatment
        } );

        xAxis.render();

        var yAxis = new Rickshaw.Graph.Axis.Y( {
            graph: graph,
            tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
            ticksTreatment: ticksTreatment
        } );

        yAxis.render();

        function addMin(data) {
            var today = new Date();
            var index = data[0].length;
            var tiempo=(today.getTime()/1000)-(6*3600);
            data.forEach( function(series) {
                series.shift();
            });
            data.forEach( function(series) {
                series.push( { x: tiempo, y: Math.floor((Math.random() * 100) + 1)});
            });
        }


        /* add some data every so often

        var messages = [
            "Set in",
            "Set out  <button id='crearClip' type='button' onClick='window.open(\""+$('#signal').val()+"/"+"start="+start+"end="+end+"\", this.target, \"width=300,height=400\"); return false;'>Crear corte</button>"
        ];*/

        setInterval( function() {
            addMin(seriesData);
            graph.update();
            //console.log(seriesData);
            
        }, 10000 );

        $("#realtime-chart").on('click',function(){
                graph: graph;
                var timeX = $('.x_label').html();
                var detalle= $('.detail');
                var mydate = new Date(timeX);
                var valor=mydate.getTime()/1000;//utilizado para buscar la posicion donde se crea el annotator
                var cutTime=valor+(6*3600);//ajuste del tiempo real para hacer el corte
                var id_player=$("#akamai-media-player object").attr('id');
                var player = document.getElementById(id_player);
                
                for (var i = 0; i < graph.series.active().length; i++){
                    for (var j = 0; j < 360 ; j++) {
                        var index=parseInt(seriesData[i][j].x);
                        if (valor===index){
                            break;
                        }        
                    }    
                }
                if (contador<=1){
                    if (contador==0){
                        start=cutTime;
                        mensaje="Set in";
                        /*Calculo para mover el player al tiempo solicitado
                        actTime=new Date().getTime()/1000;
                        difTime=actTime-cutTime;
                        playerTime=amp.getCurrentTime();
                        player.seek(playerTime-difTime);//posicionamiento
                        */
                    }else{
                        if (cutTime<=start) {
                             alert("Valore no permitidos");
                             return false;
                        }
                        end=cutTime;
                        mensaje="Set out";
                        $("#crearClip").show();
                    }                  
                    annotator.add(seriesData[i][j].x, mensaje);
                    contador++;
                }else{
                    $('#timeline .annotation').each (function(){
                        this.remove();
                    });
                    $('#realtime-chart .annotation_line').each (function(){
                        this.remove();
                    });
                    contador=0;
                    start=cutTime;
                    end=0;
                    annotator.add(seriesData[i][j].x, "Set in");
                    contador++;
                    $("#crearClip").hide();
                }
                graph.update();
                $('#timeline .annotation').addClass("active")
                $('#realtime-chart .annotation_line').addClass("active");
                $('#start').val(start);
                $('#end').val(end);
                console.log("inicio:"+start+" fin:"+end);
                
        });
        
        $("#crearClip").on('click',function(){
                $("#crearClip").hide();
                $('#timeline .annotation').each (function(){
                    this.remove();
                });
                $('#realtime-chart .annotation_line').each (function(){
                    this.remove();
                });
                start=0;
                end=0;
                return true;
                
        });

        $("#setIn").on('click',function(){
                $("#crearClip").hide();
                $('#timeline .annotation').each (function(){
                    this.remove();
                });
                $('#realtime-chart .annotation_line').each (function(){
                    this.remove();
                });
                var mydate = new Date(seriesData[0][359].x);
                var valor=mydate.getTime();//utilizado para buscar la posicion donde se crea el annotator
                var cutTime=valor+(6*3600)-60;
                start=cutTime;
                end=0;
                annotator.add(seriesData[0][359].x, "Set in");
                contador++;
                graph.update();
                $('#timeline .annotation').addClass("active")
                $('#realtime-chart .annotation_line').addClass("active");
                $('#start').val(start);
                $('#end').val(end);
                console.log("inicio:"+start+" fin:"+end);
        });
        
        $("#setOut").on('click',function(){
                if(start==0){
                    alert('Debes seleccionar el inicio');
                    return false;
                }
                var idx=0, name;
                $("#crearClip").hide();
                /*Se elimina alguna otra anotacion de Set out*/
                $('#timeline .annotation').each (function(){
                    name=$(this).find('.content').html();
                    if (name=="Set out"){
                        this.remove();
                        $('#realtime-chart .annotation_line').eq(idx).remove();
                    }
                    idx=idx+1;
                });
                            
                var mydate = new Date(seriesData[0][359].x);
                var valor=mydate.getTime();//utilizado para buscar la posicion donde se crea el annotator
                var cutTime=valor+(6*3600);
                end=cutTime;
                annotator.add(seriesData[0][359].x, "Set out");
                contador++;
                graph.update();
                $('#timeline .annotation').addClass("active")
                $('#realtime-chart .annotation_line').addClass("active");
                $('#end').val(end);
                console.log("inicio:"+start+" fin:"+end);
                
        });

        $("#cutClip").on('click',function(){
                
                $("#crearClip").hide();
                if(!end || !start){
                    alert("Debe seleccionar valores de inicio y fin");
                    return false;
                }
                if((end<=start)){
                    alert("Debe seleccionar valores validos");
                    return false;
                }
                timeTotal=end-start;
                if(timeTotal<0||timeTotal>(5*3600)){
                    alert("El tiempo debe estar entre 1 y 300 minutos");
                    return false;
                }

                $('#timeline .annotation').each (function(){
                    this.remove();
                });
                $('#realtime-chart .annotation_line').each (function(){
                    this.remove();
                });
                start=0;
                end=0;
                return true;
                
        });

        $("#golbutton").on('click',function(){

                var mydate = new Date(seriesData[0][359].x);
                var valor=mydate.getTime();//utilizado para buscar la posicion donde se crea el annotator
                var cutTime=valor+(6*3600)-60;
                
                annotator.add(seriesData[0][359].x, "Gol");
                
                graph.update();
                $('#timeline .annotation').addClass("active")
                $('#realtime-chart .annotation_line').addClass("active");
                console.log("Gol:"+valor);
                var parametros = {
                    "canal" :1,
                    "time": cutTime
                }; 
                $.ajax({
                    url: '/gol',
                    type: 'post',
                    data: parametros,
                    success: function(result) {
                        console.log(result);
                    },
                    error: function(result) {
                        console.log(result);
                    }
                }); 
                
        });

        $("#gol_local").on('click',function(){
            var mydate = new Date(seriesData[0][359].x);
            var valor=mydate.getTime();//utilizado para buscar la posicion donde se crea el annotator
            var cutTime=valor+(6*3600)-60;
            
            console.log("Gol de equipo local:"+valor);
            var parametros = {
                "canal" :$("#signal").val(),
                "time": cutTime,
                "partido": parseInt($("#game").val()),
                "equipo":"local"
            }; 
            $.ajax({
                url: '/gol',
                type: 'post',
                data: parametros,
                success: function(result) {
                    console.log(result);
                },
                error: function(result) {
                    console.log(result);
                }
            }); 
            
        });

        $("#gol_visit").on('click',function(){
            var mydate = new Date(seriesData[0][359].x);
            var valor=mydate.getTime();//utilizado para buscar la posicion donde se crea el annotator
            var cutTime=valor+(6*3600)-60;
            
            console.log("Gol de equipo visitante:"+valor);
            var parametros = {
                "canal" :$("#signal").val(),
                "time": cutTime,
                "partido": parseInt($("#game").val()),
                "equipo":"visit"
            }; 
            $.ajax({
                url: '/gol',
                type: 'post',
                data: parametros,
                success: function(result) {
                    console.log(result);
                },
                error: function(result) {
                    console.log(result);
                }
            }); 
            
        });
        
    }

    pageLoad();

    PjaxApp.onPageLoad(pageLoad);
});

