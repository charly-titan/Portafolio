$(function(){

	pageSetUp();


			/*   SELECT STEP   */

			var numStep = $("#numStep").val();

			if(numStep){
				$("#optStep li").removeClass('active');
				$("#"+numStep).addClass('active');
			}else{
				$("#step1").addClass('active');
			}

			/********************* Checkbox******************************/

			if($("#advertising").val()!=0){
				$('#advertisingOption').attr('checked', true);
			}

	/********** Evitar el enter *************/

		function stopRKey(evt) {
			var evt = (evt) ? evt : ((event) ? event : null);
			var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
			if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
		}
		
		document.onkeypress = stopRKey; 


			// START TIMEPICKER
				$('.timepicker').timepicker();


			/*$('.timepicker').timepicker({
				defaultTime: false,
			});*/

			/* funcion de add user*/

		if($("#autorizedPerson").val()){

			var IDUserPermison = $("#autorizedPerson").val();

			idUserArray = IDUserPermison.split(",");

			data=[];

			for (var i = 0; i < idUserArray.length; i++) {
				data[i] = idUserArray[i];
			};

		}else{

			data = [];
		}

		$("#addUser").on('click',function(){

			$("#userAdd").show();
			var idUser = $('#selectUser option:selected').attr('id');

			if(idUser){


				$("#dataAutorizedDatabase").val('');

				if($.inArray(idUser, data) < 0){

					data.push(idUser);

					$("#autorizedPerson").val(data)
			
					$("#userAdd").append($("<tr>")
									.append($("<td>",{text:$('#selectUser').val()}))
									.append($('<td>')
										.append($("<button>",{type:'button',id:'userTrash'+idUser}).addClass('btn btn-danger btn-xs').append($("<i>").addClass('fa fa-minus')))));
				}

				 $("#userTrash"+idUser).on('click',function(){

				 		var idDelete = $("#autorizedPerson").val(),
						idDel = idDelete.split(","),
						Idx = idDel.indexOf(idUser);

						idDel.splice(Idx,1);
						data.splice(Idx,1);

						$("#autorizedPerson").empty().val(idDel.toString());

						$(this).parent().parent().remove();

						if($("#userAdd tr").length == 1){$("#userAdd").hide();}
				 });

			}


		});



			/**************** USER AUTORIZED DOWNLOAD UPDATE **********************************/

			 if($("#dataAutorizedDatabase").val()){

			 	var dataAutorizedDatabase = JSON.parse($("#dataAutorizedDatabase").val()),
			 		newVal = [];

				 	$.each(dataAutorizedDatabase,function(val,key){

							$("#userAdd").append($("<tr>")
												.append($("<td>",{text:key}))
												.append($('<td>')
													.append($("<button>",{type:'button',id:'userTrash'+val}).addClass('btn btn-danger btn-xs deleteUser').append($("<i>").addClass('fa fa-minus')))));
								newVal.push(val);							
				 	});


				 var idDelete = $("#autorizedPerson").val(),
					 idDel = idDelete.split(","),
					 newElements = [];
						
						for (var i = 0; i < idDel.length; i++) {
								newElements[i] = parseInt(idDel[i]);
						}

				 $(".deleteUser").on('click',function(){

				 	var idUser = $(this).attr("id");

				 	$("#"+idUser).parent().parent().remove();

						Idx = newElements.indexOf(idUser);

						idDel.splice(Idx,1);
						data.splice(Idx,1);

						$("#autorizedPerson").empty().val(idDel.toString());

						$(this).parent().parent().remove();

						if($("#userAdd tr").length == 1){$("#userAdd").hide();}
				 });
			 }

			 if($("#userAdd tr").length == 1){$("#userAdd").hide();}


		/*********************************** VENTANA MODAL ******************************************

			/** Editor CK **/

			$('.editors').each(function(){

			    CKEDITOR.replace(  $(this).attr('id'), { 
                    height: '250px', 
                    startupFocus : true,
                    toolbar: [
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline'] },
                        { name: 'styles', items: ['Format', 'Font', 'FontSize' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',  '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                    ],
                    resize_enabled:false,
                } );
			});

			$(".optService").on('click',function(){

				var parameterService = $(this).data('service');

				$("#myModalLabel").text($(this).text());
				$("#typeDescription").val(parameterService);

				if($("#"+parameterService).val() != null){
					var contentHtml = $("#"+parameterService).val();
					CKEDITOR.instances['editContent'].setData(contentHtml);
				}
			});





			/*********** RADIO OPTION TYPE***********/

			var valOptSel = $("#typeContestOpt").val();
				$("#"+valOptSel).attr("checked",true);

				$("input[type=radio][name='typeContest']").change(function(){
				   // alert( $(this).val() + "--" + valOptSel);
				   if($(this).val()!=valOptSel)
				    	alert( 'Estas seguro que deseas cambiar '+ valOptSel+ " por " + $(this).val()+ ' se eliminaran las preguntas anteriores');
				});


			/**************** OWNER SELECT ***********************/

			var valSel = $("#ownerIDselect").val();
			$("#ownerInformationIDSel,#ownerInformationID").select2("val", [valSel]);
		


			 /**************** OPTION SOCIAL NETWORK ***************/


			 if($("#socialNetworkOpt").val()){

			 	var optionsNS = $("#socialNetworkOpt").val(),
			 		opt = JSON.parse(optionsNS);

			 	for (var i = 0; i < opt.length; i++) {
			 		$("#"+opt[i]).attr('checked',true);
			 	};
			 
			 }


			 /************** DropZone *******************/

			Dropzone.options.myDropzone = {
				maxFiles: 1,
				paramName: "file",
				addRemoveLinks : true,
				maxFilesize: 500,
				acceptedFiles: ".jpg, .jpeg, .gif, .png",
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
				dictResponseError: 'Error uploading file!',
			  init: function() {
			    this.on("success", function(file, responseText) {
			    		var UrlImg = responseText;

			      		$.each(UrlImg,function(key,val){
			      			$("#"+key+"Img").val(val);
			      		});
			      		
			    });
			  }
			};

			/***********  Load Img  *********/

			$("#imgLoad").html($("<img>").attr("src", $("#contestImg").val()));
			$("#imgLoadLogo").html($("<img>").attr("src", $("#logoImg").val()));
			$("#imgLoadStage").html($("<img>").attr("src", $("#stageImg").val()));
			$("#imgLoad1Versus").html($("<img>").attr("src", $("#1VersusImg").val()));
			$("#imgLoad2Versus").html($("<img>").attr("src", $("#2VersusImg").val()));
			

			/********************** DISABLE INPUTS ****************************************/
			
			var valUserPermission = $("#valUserPermission").val();

			if(valUserPermission == 0){

				$(":input[type=text],textarea,:radio:not(:checked),:checkbox,select,.datepicker,.timepicker").prop('disabled', true);

				$(".datepicker" ).removeClass('hasDatepicker');

				$('#addUser,.deleteUser,.optService').prop('disabled', true);

			} 



			/************************  Tabs Text *****************************/   

			$('#tabs').tabs();

			/************************  Versus *****************************/   
			$("#versusOptionTwo").on('click',function(){

				if($("#versusOptionTwo").is(':checked')) {  
					$("#stage").hide();
					$("#versus2").show();
				}else{
					$("#stage").show();
					$("#versus2").hide();
				}

			});

			/************************  Gigya *****************************/   
			$("#optionGigya").on('click',function(){

				if($("#optionGigya").is(':checked')) {  
					$("#facebook").removeAttr('checked');
					$("#twiter").removeAttr('checked');
					$("#google").removeAttr('checked');
					$("#facebook").attr('disabled','disabled');
					$("#twiter").attr('disabled','disabled');
					$("#google").attr('disabled','disabled');
					$("#optionGigya").val('1');
					
				}else{
					$("#facebook").removeAttr('disabled');
					$("#twiter").removeAttr('disabled');
					$("#google").removeAttr('disabled');
					$("#optionGigya").val('0');
					
				}

			});


			
});


