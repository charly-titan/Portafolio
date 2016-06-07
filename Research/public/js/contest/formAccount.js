$(function(){

	pageSetUp();

	var valGender = $("#gender").val();
	var location = window.location.origin;
  var valUserPermissionRoles = $("#valUserPermissionRoles").val();
  var optRoles = JSON.parse(valUserPermissionRoles);



	if(!$("#id_users").val()){
		$("#tableAccountSetting").show();
	}
	

	$('#genders option[value="'+valGender+'"]').attr('selected','selected');


	/***********************************************/

	$("#selectSite").on('change',function(){

      $("#selectRol").empty();
       var selectSite = $(this).val();

      if(selectSite!=0){

      $.ajax({
              url: location+'/user/selectsite',
              type: 'GET',
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

var idGroup = [];

	$("#addPermission").on('click',function(){

                            var valSite = $("#selectSite").val()
                            var nameSite = $("#selectSite option:selected").text();
                            var nameRol = $("#selectRol option:selected").text();
                            var valRol = $("#selectRol").val()

                            $('#selectRol :selected').each(function(i, selected){ 
                              idGroup.push($(selected).attr('id'));
                            });

                     
                          if(valSite!=0 && valRol!=null){

                                  if($('[id="'+nameSite+'"]').length){

                                              for (var i = 0; i < valRol.length; i++) {

                                                  if($('[id="'+nameSite+'"]').find('[id="'+valRol[i]+'"]').length){
                                                      alert('Ya asignaste el permiso');
                                                      //$("#tableAccountSetting").hide();
                                                      break;
                                                  }else{

                                                      for (var j = 0; j < idGroup.length; j++) {
                                                        $("#valSitePermAct").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[j],id:valSite+'_'+idGroup[j],type:'hidden'}));
                                                          
                                                        $("#valSitePerm").append($("<input>",{name:'accountPerm['+valSite+']['+j+']',value:idGroup[j],id:valSite+'_'+idGroup[j],type:'hidden'})); 
                                                      } 

                                                      $('[id="'+nameSite+'"]').append($('<tr>',{id:idGroup[i]})
                                                                                        .append($('<td>').addClass('delPermision1')
                                                                                          .append($('<label>',{text:valRol[i],id:valRol[i]})))
                                                                                                .append($('<td>').addClass('delPermision').append($('<button>',{id:valSite,text:'x'}).addClass('btn btn-danger btn-xs btnDel pull-right'))));
                                                      };     
                                              };

                                  }else{
                                                      

                                      /* UPDATE ACCOUNT*/

                                       $("#tablePerm").append($("<tr>",{id:nameSite})
                                                      .append($('<tr>').append($('<th>')
                                                       .append($('<i>').addClass('fa fa-briefcase')
                                                          .append($('<label>',{text:nameSite}))))));

                                       /* NEW ACCOUNT*/

                                       $("#tablePermNew").append($('<tr>',{id:nameSite})
                                        .append($('<tr>').append($('<th>',{'colspan':3})
                                                /*.append($('<p>',{text:nameSite}).addClass('alert alert-success'))*/
                                                )));

                                           for (var i = 0; i < valRol.length; i++) {

                                                   /*UPDATE ACCOUNT*/
                                                   $("#valSitePermAct").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));

                                                   /* NEW ACCOUNT*/
                                                  $("#valSitePerm").append($("<input>",{name:'accountPerm['+valSite+']['+i+']',value:idGroup[i],id:valSite+'_'+idGroup[i],type:'hidden'}));

                                                  $('[id="'+nameSite+'"]').append($('<tr>',{id:idGroup[i]})
                                                                            .append($('<td>').addClass('delPermision1')
                                                                              .append($('<label>',{text:valRol[i],id:valRol[i]})))
                                                                                    .append($('<td>').addClass('delPermision').append($('<button>',{id:valSite,text:'x'}).addClass('btn btn-danger btn-xs btnDel pull-right'))));
                                                                      
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
        });



var  perfilPermission = JSON.parse($('#perfilPermission').val());


if(perfilPermission){
    var data = new Array();

        $.each(perfilPermission, function(index, val) {

            var id_Site = val.id_site;
            var name_Site = val.nameSite;
            var id_Group =  val.id;
            var name_Group = val.nameGroup;
            var idUser = $("#id_users").val();

            if(id_Site){

                    var id_Group = id_Group.split(',');
                    var name_Group = name_Group.split(',');
                    var name_Site = name_Site.split(',');



                    $("#tablePerm").append($('<tr>',{id:name_Site})
                                        .append($('<tr>').append($('<th>',{'colspan':3})
                                                /*.append($('<p>',{text:name_Site,id:id_Site}).addClass('alert alert-success'))*/
                                                )));


                            for (var i = 0; i < name_Group.length; i++) {


                                $('[id="'+name_Site+'"]').append($('<tr>',{id:id_Group[i]})
                                                              .append($('<td>',{id:id_Site}).append($('<label>',{id:name_Group[i],text: name_Group[i]})))
                                                                .append($('<td>').addClass('delPermision').append($('<button>',{type:'submit',id:id_Group[i]+','+id_Site,text:'x'}).addClass('btn dropdown-toggle btn-xs clearfix btn-danger pull-right btndelete'))));
                                                                
                                                         
                                                           

                            };          


                     $(".btndelete").on('click',function(){

                        var ids = $(this).attr('id');
                        var idNew =  ids.split(',');
                        idDelGroup = idNew[0];
                        idDelSite = idNew[1];

                        $(".formDelete").attr("action", "/user/deletepermission/"+idDelGroup+'/'+idUser+'/'+idDelSite);
                     })

              }

        });//fin each

        $("#editPerm").on('click',function(){
            $("#tableAccountSetting").show();
            $("#editPerm").hide();
        })
}


  /********* Button delete  *********/


  if(optRoles['update']==0){
    $(".btndelete,#editPerm").remove();

  }

});