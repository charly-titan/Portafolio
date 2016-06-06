$(function(){
  
var gender = $("#gender").val();
var location = window.location.origin;

$("#"+gender).attr('checked',true);

/* APLICA PARA AMBOS UPDATE Y NEW USER CON PERMISOS*/
 
$("#selectSite").on('change',function(){

      $("#selectRol").empty();
       var selectSite = $(this).val();

                            
      if(selectSite!=0){

      $.ajax({
              url: location+'/userPermission/selectsite',
              type: 'POST',
              data: {selectSite:selectSite},
              dataType: 'JSON',
              success: function(data) { 

                  if(data != null){
                    
                      $.each(data, function(index, val) {

                           $("#selectRol").append($("<option>",{text:val.name,id:val.id,value:val.name}));
                      });
                  }
              }//fin success
            })//fin ajax
       }
})

$('.date-picker').datepicker({
     autoclose: true, 
}).on('changeDate', function(e){
    $('#birthdate').val($(this).data('date'));
    $(this).datepicker('hide');
});


                          $("#addPermission").on('click',function(){

                            var valSite = $("#selectSite").val()
                            var nameSite = $("#selectSite option:selected").text();
                            var nameRol = $("#selectRol option:selected").text();
                            var valRol = $("#selectRol").val()

                            var idGroup = [];

                            $('#selectRol :selected').each(function(i, selected){ 
                              idGroup[i] = $(selected).attr('id'); 
                            });
                     
                          if(valSite!=0 && valRol!=null){

                                  if($('[id="'+nameSite+'"]').length){

                                              for (var i = 0; i < valRol.length; i++) {

                                                  if($('[id="'+nameSite+'"]').find("#"+valRol[i]).length){
                                                      alert('Ya asignaste el permiso');
                                                      $("#tableAccountSetting").hide();
                                                      break;
                                                  }else{
                                                      /* UPDATE ACCOUNT*/
                                                     $("#valSitePermAct").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));
                                                     /* NEW ACCOUNT */

                                                     $("#valSitePerm").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));

                                                    
                                                      $('[id="'+nameSite+'"]').append($('<tr>',{id:idGroup[i]}).append($('<td>')).append($('<td>').append($('<i>').addClass('fa fa-check-circle')).append($('<label>',{text:valRol[i],id:valRol[i]})))
                                                                                        .append($('<td>').append($('<button>',{id:valSite}).addClass('btn btn-danger btn-sm btnDel')
                                                                                                          .append($('<i>').addClass('fa fa-trash-o fa-lg')))));
                                                  } 
                                              };

                                  }else{
                                                      

                                      /* UPDATE ACCOUNT*/

                                       $("#tablePerm").append($("<tr>",{id:nameSite})
                                                      .append($('<tr>').append($('<th>')
                                                       .append($('<i>').addClass('fa fa-briefcase')
                                                          .append($('<label>',{text:nameSite}))))));

                                       /* NEW ACCOUNT*/
                                       $("#tablePermNew").append($('<tr>',{id:nameSite})
                                                                .append($('<tr>')
                                                                   .append($('<th>').append($('<i>').addClass('fa fa-briefcase').append($('<label>',{text: nameSite}))))
                                                          ));

                                           for (var i = 0; i < valRol.length; i++) {

                                                   /*UPDATE ACCOUNT*/
                                                   $("#valSitePermAct").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));

                                                   /* NEW ACCOUNT*/
                                                  $("#valSitePerm").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));

                                                  $('[id="'+nameSite+'"]').append($('<tr>',{id:idGroup[i]}).append($('<td>').addClass('hidden-xs dropdown')).append($('<td>').append($('<i>').addClass('fa fa-check-circle')
                                                                              .append($('<label>',{text:valRol[i],id:valRol[i]}))))
                                                                                    .append($('<td>').append($('<button>',{id:valSite}).addClass('btn btn-danger btn-sm btnDel')
                                                                                                          .append($('<i>').addClass('fa fa-trash-o fa-lg')))));
                                                                      
                                          };
                                  }

                            $("#CurrentPermission").show();
                            $('#selectSite').val('');
                            $("#selectRol").empty();

                                    
                           }

                        
                $(".btnDel").on('click',function(){

                    var rowCount = $('[id="'+nameSite+'"]').children("tr").length;    
                    var GroupId =  $(this).parents('tr').first().attr('id');

                    if(rowCount == 2){
                        //$(this).parents().parents('tr').remove();
                        $(this).parents().parents('tr').remove();
                        $("#"+valSite+'_'+GroupId).remove();
                    
                    }else{
                       $(this).parents('tr').first().remove();
                       $("#"+valSite+'_'+GroupId).remove();
                    }
                })
                           
        })
                        
})//fin function