$("#newFeed").on('click',function(){
    $("#adminEscaletaRes").empty().prepend($('<span>').css('padding-left','500px').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin fa-3x')));
    $("#adminEscaletaRes").load( locations+"/escaletas/newfeed" );
});

$(".updFeed").on('click',function(){
    var idUpdFeed = $(this).attr('id');
    $("#adminEscaletaRes").empty().prepend($('<span>').css('padding-left','500px').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin fa-3x')));
    $("#adminEscaletaRes").load(locations+"/escaletas/edit/"+idUpdFeed);
});

$(".select-block-level").each(function(){
        $(this).select2($(this).data());
});


$("#idChannelUpd").val($("#channel").val()).trigger("change");

/* Barra de navegacion depende la pestaña*/

        $("#wizard").bootstrapWizard({onTabShow: function(tab, navigation, index) {
                    var $total = navigation.find('li').length;
                    var $current = index+1;
                    var $percent = ($current/$total) * 100;
                    var $wizard = $("#wizard");
                    $wizard.find('.progress-bar').css({width:$percent+'%'});

                    if($current >= $total) {
                        $wizard.find('.pager .next').hide();
                        $wizard.find('.pager .finish').show();
                        $wizard.find('.pager .finish').removeClass('disabled');
                    } else {
                        $wizard.find('.pager .next').show();
                        $wizard.find('.pager .finish').hide();
                    }
        }});


/* Select con style */

        $('.selectpicker').selectpicker();
        //selectpicker doesn't seem to be flexible enough (can't change template), so need to replace span.caret externally
        $('.selectpicker + .bootstrap-select span.caret').replaceWith("<i class='fa fa-caret-down'></i>");
        $('.selectpicker + .bootstrap-select span.pull-left').removeClass("pull-left");

/* Checkbox */

        $(".iCheck").iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });


function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

$("#mask-time,#mask-time2").mask("99:99");
    /* RANGE HOURS*/

        $("#mask-time").on('blur',function(){
            
            if($(this).val()!='__:__'){
                $("#mask-time2").on('blur',function(){

                    var val = $("#mask-time2").val();
   
                    if(val != ''){

                        var start_time = $("#mask-time").val();
                        var end_time  = $("#mask-time2").val();
                        
                        var diff = ( new Date("1970-1-1 " + end_time) - new Date("1970-1-1 " + start_time) ) / 1000 / 60 / 60; 

                            if(diff <= 0){
                                
                                alert("No puede ser igual o menor a la Hora Inicial ")
                                $("#mask-time2").val('');
                            } 
                    }
                })
            }
        });
    /*----------------*/


    
        /* DATAPICKER RANGE*/
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
         
        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');

/*  New Feed */

 $('#saveNewFeed').on('click',function(){

        var location = window.location.origin;

            $.ajax({
                        url: location+'/escaletas/feed',
                        type: 'POST',
                        data: $('.formNewFeed').serialize(),
                        dataType: 'JSON',
                        success: function(data) { 

                            $("#_nameFeed,#_urlFeed,#_cl,#_idChannel,#_timeConsultation,_nameDays,#_initiationTime,#_endTime,#_dateInitiation,#_dateEnd").text('');

                            if(data.success == false){

                                    $.each(data.errors,function(index,value){
                                        $('#_'+index).text(value);
                                    });

                                alert("Faltan llenar campos obligatorios")

                            }else{

                                window.location.href = location+"/adminFeeds";
                            }
                        }//fin success
                })
        });


/* UPD Feed */

        var nameDays = $("#nameDaysAct").val();

        if(nameDays){
			
			var nameDay = nameDays.split(",");
			
			$.each(nameDay,function(index,val){
                $("#"+val).iCheck('check');
            });

        }
        
        var hourOminuteSel = $("#hourOminuteSel").val();
        $('.filter-option').text(hourOminuteSel);

 		/* SAVE UPDATE*/

        $('#saveUpdFeed').on('click',function(){

        var location = window.location.origin,
            idFeed = $('#idFeed').val();

            $.ajax({
                        url: location+'/escaletas/feedupd/'+idFeed,
                        type: 'POST',
                        data: $('.formUpdFeed').serialize(),
                        dataType: 'JSON',
                        success: function(data) { 

                            $("#_nameFeed,#_urlFeed,#_cl,#_idChannel,#_timeConsultation,#_nameDays,#_initiationTime,#_endTime,#_dateInitiation,#_dateEnd").text('');

                            if(data.success == false){

                                    $.each(data.errors,function(index,value){
                                        $('#_'+index).text(value);
                                    });

                                alert("Faltan llenar campos obligatorios")

                            }else{

                                window.location.href = location+"/adminFeeds";
                            }
                        }//fin success
                })//fin ajax
        })