/* UPDATE FORM ACCOUNT */

var gender = $("#gender").val();


$("#"+gender).attr('checked',true);


    var perfilPermission = JSON.parse($('#perfilPermission').val());


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
                                        .append($('<tr>').append($('<th>')
                                            .append($('<i>').addClass('fa fa-briefcase')
                                                .append($('<label>',{text:name_Site,id:id_Site}))))));


                            for (var i = 0; i < name_Group.length; i++) {

                                
                                 $('[id="'+name_Site+'"]').append($('<tr>',{id:id_Group[i]})
                                                    .append($('<td>'))
                                                        .append($('<td>',{id:id_Site}).append($('<i>').addClass('fa fa-check-circle').append($('<label>',{id:name_Group[i],text:name_Group[i]}))))
                                                            .append($('<td>').append($('<button>',{type:'submit',id:id_Group[i]+','+id_Site}).addClass('btn dropdown-toggle btn-sm clearfix btn-danger pull-right btndelete')
                                                                                                          .append($('<i>').addClass('fa fa-trash-o fa-lg')))));
                            };          


                     $(".btndelete").on('click',function(){

                        var ids = $(this).attr('id');
                        var idNew =  ids.split(',');
                        idDelGroup = idNew[0];
                        idDelSite = idNew[1];

                        $("#formDelete").attr("action", "/userPermission/deletepermission/"+idDelGroup+'/'+idUser+'/'+idDelSite);
                     })

              }

        });//fin each

        $("#editPerm").on('click',function(){
            $("#tableAccountSetting").show();
        })
