if(bandRow == "undefined"){
    var bandRow = '';
    var htmlData = '';
    var flag = true;
}
var fireline = {
    config : {
        templates : {
            row : '<tr>'+
                    '<td>%dateStart%</td><td>%dateEnd%</td>'+
                    '<td>%band%</td><td>%tag%</td>'+
                        '<td>'+
                            '<a data-toggle="modal" data-target="#myModal" class="btn btn-warning fa fa-edit" data-id="%idband%"></a>&nbsp;'+
                            '<a class="btn btn-danger fa fa-remove btn-fireline-rm" data-idrow="%idrow%"></a>'+
                        '</td>'+
                    '</tr>'
        },
        eventosRef : ''
    },

    getEventsTimeline : function(){
        var f_inicio_format, f_fin_format;
        this.config.eventosRef.on('value', function(snapshot){
            $("#content-timeline-data").empty();  
            snapshot.forEach(function(childSnapshot) {
            var aux = childSnapshot.val()['startDate'].split(",");
            var aux2 = childSnapshot.val()['endDate'].split(",");
            htmlData = bandRow.replace("%dateStart%", aux[2]+"/"+aux[1]+"/"+aux[0]+" "+aux[3]+"-"+aux[4]+"-"+aux[5])
                                .replace("%dateEnd%", aux2[2]+"/"+aux2[1]+"/"+aux2[0]+" "+aux2[3]+"-"+aux2[4]+"-"+aux2[5])
                                .replace("%band%", childSnapshot.val()['headline'])
                                .replace("%tag%", childSnapshot.val()['tag'])
                                .replace("%idband%", childSnapshot.key())
                                .replace("%idrow%", childSnapshot.key());
            $("#content-timeline-data").append(htmlData);
            $(".btn-fireline-rm").unbind();
            $(".btn-fireline-rm").click(function(){
                fireline.clearData($(this).attr("data-idrow"));
            });

            bandRow = fireline.config.templates.row; 
            htmlData = "";
            });
            $("[data-target='#myModal']").click(function(){
                var idrecord = $(this).attr("data-id");
                fireline.getOnlyOne(idrecord);
            });
        });
    },

    getOnlyOne : function(id){
        this.config.eventosRef.child(id).once("value", function(snapshot){
            fireline.setFormData(id, snapshot.val()['startDate'], snapshot.val()['endDate'], snapshot.val()['headline'], snapshot.val()['tag']);    
        });
    },

    setFormData : function(idsnap, startDate, endDate, headline, tag){
        //console.info(startDate + " - " + endDate + " - " + headline +" - "+ tag);
        var forma = $("#myModal");

        var startFecha = startDate.split(",");
        var f_inicio = { anno : startFecha[0], mes : startFecha[1], dia : startFecha[2], hora : startFecha[3], min : startFecha[4], seg : 00};
        forma.find("input[name='datestart']").val(f_inicio.dia+"/"+f_inicio.mes+"/"+f_inicio.anno);
        forma.find("input[name='horainicio']").val(f_inicio.hora + ":" + f_inicio.min);

        var endFecha = endDate.split(",");
        var f_fin = { anno : endFecha[0], mes : endFecha[1], dia : endFecha[2], hora : endFecha[3], min : endFecha[4], seg : 00};
        forma.find("input[name='dateend']").val(f_fin.dia+"/"+f_fin.mes+"/"+f_fin.anno);
        forma.find("input[name='horafin']").val(f_fin.hora+":"+f_fin.min);

        forma.find("input[name='headline']").val(headline);
        forma.find("input[name='tag']").val(tag);

        forma.find("#btn-save-fire").unbind().click(function(){
            fireline.updateEventData(idsnap);
        });
    },

    updateEventData : function(idsnap){
        var dataUpdate = {};
        var response = fireline.getDataToSave();
        var arre_inicio = response.fechainicio.split("/");
        var h_inicio = response.horainicio.split(":");
            //h_inicio[0] = (10 > parseInt(h_inicio[0])) ? "0"+h_inicio[0] : h_inicio[0];
        var fecha_inicio = arre_inicio[2]+","+arre_inicio[1]+","+arre_inicio[0]+","+h_inicio[0]+","+h_inicio[1]+",00";

        var arre_fin = response.fechafin.split("/");
        var h_fin = response.horafin.split(":");
            //h_fin[0] = (10 > parseInt(h_fin[0])) ? "0"+h_fin[0] : h_fin[0];
        var fecha_fin = arre_fin[2]+","+arre_fin[1]+","+arre_fin[0]+","+h_fin[0]+","+h_fin[1]+",00";
        var banda = response.banda;
        var grouptag = response.tag;
        dataUpdate = {
            startDate : fecha_inicio,
            endDate   : fecha_fin,
            tag       : grouptag,
            headline  : banda
        }
        this.config.eventosRef.child(idsnap).update(dataUpdate, fireline.responseUpdateFire);
    },

    responseUpdateFire : function(error){
        if (error) {
            console.log('Synchronization failed');
        } else {
            if($("#msg-fireline-created").size()){
                $("#msg-fireline-created").remove();
            }
                $("#content-msg-tabl-fireline").html('<div id="msg-fireline-created" class="alert alert-success fade in">'+
                '<button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-check"></i><strong>Super </strong> Registro Actualizado.</div>');
            
            $("#myModal").modal('hide');
        }
    },

    clearData : function(snap){
            //console.log(snap);
        this.config.eventosRef.child(snap).remove(fireline.onRemoveComplete);
    },

    onRemoveComplete : function(error){
        if (error) {
            console.log('Synchronization failed');
        } else {
            if($("#msg-fireline-created").size()){
                $("#msg-fireline-created").remove();
            }
                $("#content-msg-tabl-fireline").html('<div id="msg-fireline-created" class="alert alert-success fade in">'+
                '<button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-check"></i><strong>Super </strong> Registro Eliminado.</div>');
            
        }
    },

    getDataToSave : function(){
        var responseInfo = {};
        var forma = $("#myModal");
        responseInfo = {
            fechainicio : forma.find("input[name='datestart']").val(),
            horainicio : forma.find("input[name='horainicio']").val(),
            fechafin : forma.find("input[name='dateend']").val(),
            horafin : forma.find("input[name='horafin']").val(),
            banda : forma.find("input[name='headline']").val(),
            tag : forma.find("input[name='tag']").val()
        }
        return responseInfo;
    },

    prepareEeventData : function(){
       var formulario = $("#form-new-event");
       var eventData = [];
       eventData["fechainicio"] = formulario.find("input[name='datestart']").val();
       eventData["fechafin"] = formulario.find("input[name='dateend']").val();
       eventData["horainicio"] = formulario.find("input[name='hourone']").val();
       eventData["horafin"] = formulario.find("input[name='hourtwo']").val();
       eventData["headline"] = formulario.find("input[name='headline']").val();
       eventData["tag"] = formulario.find("input[name='tag']").val();
       var complete = fireline.validInput("form-new-event");
       if(complete){

            var f_inicio = eventData["fechainicio"].split("/");
            var h_inicio = eventData["horainicio"].split(":");
            var fecha_inicio = f_inicio[2]+","+f_inicio[1]+","+f_inicio[0]+","+h_inicio[0]+","+h_inicio[1]+",00";

            var f_fin = eventData["fechafin"].split("/");
            var h_fin = eventData["horafin"].split(":");
            var fecha_fin = f_fin[2]+","+f_fin[1]+","+f_fin[0]+","+h_fin[0]+","+h_fin[1]+",00";

            fireline.config.eventosRef.push({
                    startDate : fecha_inicio,
                    endDate: fecha_fin,
                    headline: eventData["headline"],
                    tag: eventData["tag"],
                    text : "",
                    classname: "storyjs-embed full-embed"
            });
            document.getElementById("form-new-event").reset();
            //$("#msg-fireline-created").remove();
            if($("#msg-fireline-created").size()){
                $("#msg-fireline-created").remove();
            }
                $("#content-msg-tabl-fireline").html('<div id="msg-fireline-created" class="alert alert-success fade in">'+
                '<button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-check"></i><strong>Super </strong> Registro creado.</div>');
            
            $("#modalNew").modal('hide');
       }else{
            if(formulario.find("#alertmsg-fireline").size()<=0){
                  $("#content-msg-fireline").html('<div id="alertmsg-fireline" class="alert alert-warning fade in">'+
                                '<button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-warning"></i>'+
                                '<strong>Ooop!</strong> Todos los campos son requeridos.</div>');
            }
            //formulario.find("#alertmsg-fireline").show();
       }
    },

    validInput : function(idform){
        var aprobado = true;
        $("#"+idform).find(':input').each(function() {
         var elemento= this;
            if(elemento.value.length <= 0){ 
                //console.log("invalid: "+elemento.name);
                aprobado = false; 
            } 
        });
        return aprobado;
    },

    init : function(){
        bandRow = this.config.templates.row;
        this.config.eventosRef = new Firebase('https://timelinelive.firebaseio.com/timeline/date');
        this.getEventsTimeline();
    }
}

fireline.init();