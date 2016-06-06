
var lang = $("#language-combo").val();

/* DATAPICKER RANGE*/
var nowTemp = new Date();

var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
var checkin = $('#dpd1').datepicker({
  onRender: function(date) {
    return date.valueOf() > now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  if (ev.date.valueOf() < checkout.date.valueOf()) {
    var newDate = new Date(ev.date)
    newDate.setDate(newDate.getDate() );
    checkout.setValue(newDate);
  }
  checkin.hide();
  $('#dpd2')[0].focus();
}).data('datepicker');
var checkout = $('#dpd2').datepicker({
  onRender: function(date) {
    //return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    return date.valueOf() > now.valueOf() ? 'disabled' : '';
  }
}).on('changeDate', function(ev) {
  checkout.hide();
}).data('datepicker');
/*------------*/

        $("#btnFeed").on('click',function(){

            var locations = location.origin;


            $(this).hide();

            (lang=='es') ? msg = 'Actualizando' : msg = 'Updating';
            (lang=='es') ? msgFin = 'Actualizado' : msgFin = 'Updated';

            if($("#dpd1").val()!='' && $("#dpd2").val()!=''){
                
              $("#_dateInitiation,#_dateEnd").text('');

              $("#espera").prepend($('<span>').addClass('spinner').append($("<i>").addClass('fa fa-spinner fa-spin fa-2x')).append($('<span>',{text:msg})));  
            }

            $.ajax({
                        url: locations+'/escaletas/feedsprev',
                        type: 'POST',
                        data: $('#formFeedsPrev').serialize(),
                        dataType: 'JSON',
                        success: function(data) { 
        

                            if(data.success == false){

                                    $.each(data.errors,function(index,value){
                                        $('#_'+index).text(value);
                                    });
                                    $("#btnFeed").show();
                            }else{
                                $("#espera").empty();
                                alert(msgFin)
                                window.location.href = locations+"/adminFeeds/feedsProcessRes";
                            }

                        }//fin success
                })

        })

    $(".select-block-level").each(function(){
        $(this).select2($(this).data());
    });
