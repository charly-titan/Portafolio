$(function(){


var lang = $("#language-combo").val(),
    deleterol,deleteSection,deletePermission,
    location = window.location.origin;


   switch (lang) {
      case 'es': 
                msg = '¿Está seguro de que lo desea eliminar?';
                deleteRol = 'Eliminar Rol'; 
                deleteSection = 'Eliminar Sección';
                deletePermission = 'Eliminar Permiso';
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
  $("#col_md").removeClass();
  $("#col_md").addClass('col-md-7');
  $("#colCreateSite").show();
})

/* ***********  ROLES  ******************* */


$("#creaRol").on('click',function(){
  $('#errorName').hide();
  $("#col_mdRol").removeClass();
  $("#col_mdRol").addClass('col-md-7');
  $("#colCreateRol").show();
})

$("#cancelRol").on("click",function(){
  $("#colCreateRol").hide();
  $("#col_mdRol").removeClass();
  $("#col_mdRol").addClass('col-md-10 col-md-offset-1');
})

$("#cancelIndx").on("click",function(){
  $("#colCreateSite").hide();
  $("#col_md").removeClass();
  $("#col_md").addClass('col-md-9 col-md-offset-1');
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

                $.each(groupSitesData,function(val,key){

                  

                       $("#tbRol").append($("<tr>")
                                    .append($("<td>")
                                      .append($('<label>').addClass('checkbox')
                                            .append($("<input>",{type:'checkbox',name:'id_group[]',text:key.name,id:key.name,value:key.id}).addClass('iCheck RolCheck'))
                                              .append($('<span>',{id:'link_'+key.id,text:key.name}).attr('for',key.name))))
                                    .append($("<td>")
                                        .append($("<form>",{action:'/roles/deleterol/'+key.id+'/'+key.name+'/'+id_site}) 
                                            .append($("<button>").addClass('btn btn-danger btn-sm pull-right').attr('onclick', "return confirm('"+msg+"')")
                                              .append($('<i>').addClass('fa fa-trash-o fa-lg')).append($('<span>',{text:deleteRol}).addClass('hidden-xs dropdown'))))));
                                       
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
                                                 .append($("<button>").addClass('btn btn-danger btn-sm pull-right').attr('onclick', "return confirm('"+msg+"')")
                                                   .append($('<i>').addClass('fa fa-trash-o fa-lg')).append($('<span>',{text:deleteSection}).addClass('hidden-xs dropdown'))))));


                  $("[id='"+section[i]+"']").attr("href", location+"/roles/permissonnew/"+rute+'/'+section[i]);
                }
                 for (var i = 0; i < permission.length; i++) {  
                            $("#tbPermission").append($("<tr>")
                                        .append($("<td>").append($("<label>",{text:permission[i],id:permission[i]}).css('color','#9bd0f6')))
                                            .append($("<td>")
                                            .append($("<form>",{action:'/roles/deletepermission/'+idGroup+'/'+nameSection+"."+permission[i]+'/'+countpermission})
                                              .append($("<button>").addClass('btn btn-danger btn-sm pull-right').attr('onclick', "return confirm('"+msg+"')")
                                                .append($('<i>').addClass('fa fa-trash-o fa-lg')).append($('<span>',{text:deletePermission}).addClass('hidden-xs dropdown'))))));
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

      $("#col_mdSection").removeClass();
      $("#col_mdSection").addClass('col-md-offset-1');
      $("#colCreateSection").hide();               
     }else{
      $("#errorName").show();
     }
 
})




$("#creaSection").on('click',function(){
  $("#errorName").hide();
  $("#col_mdSection").removeClass();
  $("#col_mdSection").addClass('col-md-7');
  $("#colCreateSection").show();
})

$("#cancelSection").on("click",function(){
  $("#colCreateSection").hide();
  $("#col_mdSection").removeClass();
  $("#col_mdSection").addClass('col-md-10 col-md-offset-1');
})

$("#creaPermission").on('click',function(){
  $("#errorName").hide();
  $("#col_mdPermission").removeClass();
  $("#col_mdPermission").addClass('col-md-7');
  $("#colCreatePermission").show();
})

$("#cancelPermission").on("click",function(){
  $("#colCreatePermission").hide();
  $("#col_mdPermission").removeClass();
  $("#col_mdPermission").addClass('col-md-10 col-md-offset-1');
})

$("#cancelPermission").on("click",function(){
  $("#colCreateRol").hide();
  $("#col_mdRol").removeClass();
  $("#col_mdRol").addClass('col-md-10 col-md-offset-1');
})







 })//fin document