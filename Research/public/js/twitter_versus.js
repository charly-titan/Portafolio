pageSetUp();
$(".select2-hidden-accessible").remove();

/* BASIC ;*/
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;
				
	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};
	
	$('#dt_basic').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
		// Initialize the responsive datatables helper once.
			if (!responsiveHelper_dt_basic) {
				responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
			}
		},
		"rowCallback" : function(nRow) {
			responsiveHelper_dt_basic.createExpandIcon(nRow);
		},
		"drawCallback" : function(oSettings) {
			responsiveHelper_dt_basic.respond();
		}
	});
	
/* END BASIC */

		Status_checkbox();

		$("#option_service").on('change',function(){
			service = $(this).select2('data');

			$("#active_service").empty().append($("<label>").addClass('checkbox-inline')
													.append($("<input>",{type:'checkbox',id:'chkStatus'}).addClass('checkbox style-0'))
													.append($("<span>",{id:'status-type-service',text:'Activar'})));


			$("#save_service_versus").empty().append($("<button>",{text:'Guardar',id:'btnSaveService'}).addClass('btn btn-primary'));


			$("#chkStatus").on('change',function(){

				var status_type_service = $("#status-type-service"),
					desactivar = 'Desactivar',
					activar = 'Activar';

				if ( $(this).is(':checked') ){
					status_type_service.text(desactivar);
				}else{
					status_type_service.text(activar);
				}
			});


			$("#btnSaveService").on('click',function(){

				status = $("#chkStatus").is(':checked')? 1 : 0;

				$.ajax({
					url: './save-service-versus',
					type: 'GET',
					data: {id:service.id,name_service:service.text,status:status},
					dataType:'JSON',
					success:function(data){

						if(data == 'exists'){

							$.smallBox({
								title : 'Información',
								content : "<i class=''></i> <i>Ya se agrego el servicio con nombre: "+service.text+"</i>",
								color : "#296191",
								iconSmall : "fa fa-info bounce animated",
								timeout : 4000
							});
		
						}else{
							//location.reload();
							$("#listVersus").empty();
							
							$.each(data,function(key,value){

								if(value.status){
									msgChk = 'Desactivar';
									statusChk = true;
								}else{
									msgChk = 'Activar';
									statusChk = false;
								}

								$("#listVersus").append($("<tr>")
															.append($("<td>",{text:value.id}))
															.append($("<td>",{text:value.name_service}))
															.append($("<td>")
																.append($("<label>").addClass('checkbox-inline')
																	.append($("<input>",{type:'checkbox',checked:statusChk,id:value.id}).addClass('checkbox style-0 chkStatus'))
																	.append($("<span>",{text:msgChk})))));

							})
						}

						$("#option_service").select2('val','');
						$("#chkStatus").attr('checked',false).next('span').text('Activar');
					}
				});

			});

		});



		function Status_checkbox(){

			$(".chkStatus").on('change',function(){

				id = $(this).attr('id');

				if ( $("#"+id).is(':checked') ){
					msgVersus = 'Desactivar';
					status = 1;
				}else{
					msgVersus = 'Activar';
					status = 0;
				}

				$("#"+id).next('span').text(msgVersus);

				$.ajax({
					url: './change-status-versus',
					type: 'GET',
					data: {id:id,status:status},
					dataType:'JSON',
					success:function(data){
						data
					}
				});
			});
		}


$(".myModal").on('click',function(){
		$("#modalVersus").empty();
		$("#myModalLabel").text( $(this).text() );
	});

myDataRef = new Firebase("https://versus-twitter.firebaseio.com/");

myDataRef.once("value", function(snapshot) {

	var  data = snapshot.val();

	$.each(data,function(k,v){
		$.each(v,function(k1,v1){

			$("#"+k).on('click',function(){

				for (var i = 0; i < v1.length; i++) {

					$("#modalVersus").append($('<tr>')
										.append($('<td>',{text:v1[i]['hashtag']}))
										.append($('<td>',{text:v1[i]['tweets']})));

				};
			});
		});
	});
});