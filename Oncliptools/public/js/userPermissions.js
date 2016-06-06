$(function(){

var location = window.location.origin;

 $('#tablePermissions').dataTable( {
            "columnDefs": [
                { type: "first_name", targets: 0 }

            ],
            "pagingType": "full_numbers"
   });
 


$("#selectSite").on('change',function(){

    $("#selectRol").empty();

    var selectSite = $(this).val();
                            
    if(selectSite!=0){
        
        $.ajax({
            url: location+'/userPermission/selectsiterol',
            type: 'POST',
            data: {selectSite:selectSite},
            dataType: 'JSON',
            success: function(data) {
                                     
                $.each(data, function(index, val) {
                    
                    if(val.name != null){
                        $("#selectRol").append($("<option>",{text:val.name,value:val.id_group}));
                    }
                    
                });

             }//fin success
        })//fin ajax
    }
})


$("#btnSearch").on('click',function(){

var selectSite = $("#selectSite option:selected").map(function(){return this.value }).get().join(", ");
var selectRol  = $("#selectRol option:selected").map(function(){return this.value }).get().join(", ");


if(selectSite || selectRol){

    var site = new Array();
    var group = new Array();


    $("#selectSite option:selected").each(function() {
        site.push($(this).val());
    });

    $("#selectRol option:selected").each(function() {
        group.push($(this).val());
    });


    $.ajax({
            url: location+'/userPermission/searchsitegroup',
            type: 'POST',
            data: {site:site,group:group},
            dataType: 'JSON',
            success: function(data) {

                if(typeof(data)!='undefined'){

                        $("#datosTable").empty();

                        $.each(data, function(index, val) {

                            $("#datosTable").append($('<tr>')
                                               .append($('<td>',{text:val.first_name}).addClass('string-cell'))
                                               .append($('<td>',{text:val.gender}).addClass('string-cell'))
                                               .append($('<td>',{text:val.created_at}).addClass('string-cell'))
                                               .append($('<td>',{text:val.name}).addClass('string-cell'))
                                               .append($('<td>').addClass('input-group-btn')
                                                    .append($('<a>',{href:'userPermission/editprofile/'+val.id_profile}).addClass('btn btn-warning glyphicon  glyphicon-edit'))
                                                    .append($('<a>',{href:'userPermission/deleteprofile/'+val.id_profile}).addClass('btn btn-danger delete glyphicon glyphicon-remove'))));
                        }); 

                }else
                {

                    $("#datosTable").empty();

                    $("tbody").append($('<tr>').add('role','row').append($('<td>',{text:'hola'}).addClass('string-cell')));
                }
                //$("#tablePermissions").empty();

                //window.location.href =  '/userPermission/buscas/'+data;

                

             }//fin success
        })//fin ajax


}else{
    alert('Debes seleccionar algun filtro');
}



});


})//end function