$(function(){


var lang = $("#language-combo").val(),
    deleterol,deleteSection,deletePermission,
    location = window.location.origin;


   switch (lang) {
      case 'es': 
                msg = '¿Está seguro de que lo desea eliminar?';
                deleteRol = 'Eliminar'; 
                deleteSection = 'Eliminar';
                deletePermission = 'Eliminar';
                break;
      case 'en': 
                msg = 'Are you sure you want to delete?';
                deleteRol = 'Delete this Rol'; 
                deleteSection = 'Delete this Section';
                deletePermission = 'Delete this Permission';
                break;
  }

/* ***********   SITIOS ******************  */

$("#creaSite").on('click',function(){
  $('#errorDominio,#errorName').hide();
  $("#col_md").removeClass('col-lg-12').addClass('col-lg-8');
  $("#colCreateSite").show();
})



/* ***********  ROLES  ******************* */


$("#creaRol").on('click',function(){
  $('#errorName').hide();
  $("#col_mdRol").removeClass('col-lg-12').addClass('col-lg-8');
  $("#colCreateRol").show();
})

$("#cancelRol").on("click",function(){
  $("#colCreateRol").hide();
  $("#col_mdRol").removeClass('col-lg-8').addClass('col-lg-12');
})

$("#cancelIndx").on("click",function(){
  $("#colCreateSite").hide();
  $("#col_md").removeClass('col-lg-8').addClass('col-lg-12');
})

// Save Rol
// 
$("#saveRol").on('click',function(){

  var roles = $(".RolCheck:checkbox:checked").serializeArray(),
      id_site  = $("#id_site").val(),
      nameRol  = $("#nameRol").val();

              $.ajax({
                    url: location+'/roles/saverol/'+id_site,
                    type: 'POST',
                    data: roles,
                    dataType: 'JSON',
                    success: function(data) { 
                          window.location.href =  document.URL;
                    }//fin success
            })//fin ajax
})

var groupSites = $("#groupSites").val();

if(groupSites){
    var groupSitesData = JSON.parse(groupSites),
        id_group = JSON.parse($("#id_group").val()),
        id_site  = $("#id_site").val(),
        name  = $("#name").val();

      numG = Array();

$("#tbRol").empty();

                $.each(id_group, function(inG, valG) {
                      $.each(valG, function(index, val) {
                          numG.push(val);
                      });
                });

console.log(groupSitesData)
                $.each(groupSitesData,function(val,key){

                  

                       $("#tbRol").append($("<tr>")
                                    .append($("<td>").addClass('col col-4')
                                      .append($('<label>').addClass('checkbox')
                                            .append($("<input>",{type:'checkbox',name:'id_group[]',text:key.name,id:key.name,value:key.id}).addClass('iCheck RolCheck'))
                                            .append($("<i>"))
                                              .append($("<a>",{id:'link_'+key.id,text:key.name}).attr('for',key.name))))
                                    .append($("<td>")
                                        .append($("<form>",{action:'/roles/deleterol/'+key.id+'/'+key.name+'/'+id_site}) 
                                            .append($("<button>").addClass('btn btn-labeled btn-danger btn-xs pull-right').attr('onclick', "return confirm('"+msg+"')")
                                              //.append($("<span>").addClass("btn-label")
                                                //.append($('<i>').addClass('glyphicon glyphicon-trash')))))));
                                              .append("<span class='btn-label'><i class='glyphicon glyphicon-trash'></i></span>"+deleteRol)))));
                                       
                                     if($.inArray(key.id, numG)!= -1) {

                                      console.log(val+" -- "+key.name)

                                          $("[id='"+key.name+"']").attr('disabled',true).attr('checked',true);
                                          $("#link_"+key.id).empty();
                                          $("#link_"+key.id).append($('<a>',{value:key.name,text:key.name,id:'rutas_'+key.id}));
                                          $("#rutas_"+key.id).attr("href", "/roles/sectionnew/"+name+'/'+id_site+'/'+key.id+'/'+key.name);
                                     }     
                  });
}


/* ***********  SECTION  AND PERMISSION ******************* */

var permission = $("#permission").val(),
    rute = $("#rute").val(),
    idGroup = $("#id").val(),
    nameSection = $("#nameSection").val();



if(permission){

  var permissionsData = JSON.parse(permission);

                section = Array();
              permission = Array();



               $.each(permissionsData,function(val,key){
                  var typePermission = val.split(".");
                  
                  section.push(typePermission[0]);

                    if($.inArray(nameSection, typePermission) > -1 ){
                      
                      permission.push(typePermission[1]);
                    }
                });

                 section = $.unique(section);
                 permission = $.unique(permission);


                var countSection = section.length
                    countpermission = permission.length;

                for (var i = 0; i < section.length; i++) { 



                      $("#tbSection").append($("<tr>")
                                        .append($("<td>").append($("<a>",{text:section[i],id:section[i]}).addClass(section[i])))
                                            .append($("<td>")
                                               .append($("<form>",{action:'/roles/deletesection/'+idGroup+'/'+section[i]+'/'+countSection})
                                                 .append($("<button>").addClass('btn btn-labeled btn-danger btn-xs pull-right').attr('onclick', "return confirm('"+msg+"')")
                                                   //.append($('<i>').addClass('fa fa-trash-o fa-lg'))))));
                                                  .append("<span class='btn-label'><i class='glyphicon glyphicon-trash'></i></span>"+deleteSection)))));



                  $("[id='"+section[i]+"']").attr("href", location+"/roles/permissonnew/"+rute+'/'+section[i]);
                }
                 for (var i = 0; i < permission.length; i++) {  
                            $("#tbPermission").append($("<tr>")
                                        .append($("<td>").append($("<label>",{text:permission[i],id:permission[i]}).css('color','#3276b1')))
                                            .append($("<td>")
                                            .append($("<form>",{action:'/roles/deletepermission/'+idGroup+'/'+nameSection+"."+permission[i]+'/'+countpermission})
                                              .append($("<button>").addClass('btn btn-labeled btn-danger btn-xs pull-right').attr('onclick', "return confirm('"+msg+"')")
                                                //.append($('<i>').addClass('fa fa-trash-o fa-lg'))))));
                                                .append("<span class='btn-label'><i class='glyphicon glyphicon-trash'></i></span>"+deletePermission)))));
                  //$("[id='"+section[i]+"']").attr("href", location+"/roles/permissonnew");
                }
}





$("#saveSection").on('click',function(){

  var nameSection = $("#nameSection").val().toLowerCase();

      if(nameSection){

          $("#tbSection").append($("<tr>")
                          .append($("<td>").append($("<a>",{text:nameSection,id:nameSection}).addClass(nameSection)))
                           .append($("<td>")));
                  $("[id='"+nameSection+"']").attr("href", location+"/roles/permissonnew/"+rute+'/'+nameSection);

      $("#col_mdSection").removeClass('col-lg-8');
      $("#col_mdSection").addClass('col-lg-12');
      $("#colCreateSection").hide();               
     }else{
      $("#errorName").show();
     }
 
})




$("#creaSection").on('click',function(){
  $("#errorName").hide();
  $("#col_mdSection").removeClass('col-lg-12').addClass('col-lg-8');
  $("#colCreateSection").show();
})

$("#cancelSection").on("click",function(){
  $("#colCreateSection").hide();
  $("#col_mdSection").removeClass('col-lg-8').addClass('col-lg-12');
})

$("#creaPermission").on('click',function(){
  $("#errorName").hide();
  $("#col_mdPermission").removeClass('col-lg-12').addClass('col-lg-8');
  $("#colCreatePermission").show();
})

$("#cancelPermission").on("click",function(){
  $("#colCreatePermission").hide();
  $("#col_mdPermission").removeClass('col-lg-8').addClass('col-lg-12');
})








 })//fin document