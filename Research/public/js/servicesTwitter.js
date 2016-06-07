var twitter = {

	rangeSlider : function(){

		var numTweets = $("#numTweets"),
			valNumTweets = $("#val_num_tweets");

		if(numTweets.children().length == 0){
		    		
		 	(typeof( valNumTweets.val() ) !='undefined' )? num = valNumTweets.val() : num = 0;
		  
			numTweets.append($("<input>",{type:'text',id:'range-slider-3'}));

			$("#range-slider-3").ionRangeSlider({
				   min: 0,
				   max: 100,
				   from: num,
				   to: 5,
				   type: 'single',
				   step: 1,
				   postfix: " tweets",
				   prettify: false,
				   hasGrid: true,
				   onChange: function (data) {
					   valNumTweets.val(data.fromNumber);
				},
			});
		}
	},
	msgInfo : function(msg){

		$.smallBox({
					title : "Informacion",
					content : "<i class=''></i> <i>"+ msg +"</i>",
					color : "#296191",
					iconSmall : "fa fa-info bounce animated",
					timeout : 4000
		});

	},
	searchNameService : function(){
			
		var ServiceName = $("#serviceName").val(),
			nameSettingsService =  $("#nameSettingsService");

		if(ServiceName){

			var location = window.location.pathname;
				url = location.split('/');

				(url.length == 4) ? pathname= '../' : pathname ='./'; 

			$.ajax({
					url: pathname+'verificar-nombre-servicio',
					type: 'GET',
					data: {ServiceName:ServiceName},
					dataType: 'JSON',
					success: function(data){

					    if(data){
					        msg = 'El nombre del servicio ya existe,asigna uno nuevo';
							twitter.msgInfo(msg);
							$("#dvTypeService,#dvSettingsService,#dvNumTweets").hide();
					    }else{
					        nameSettingsService.val(ServiceName);
					        $("#dvTypeService,#dvSettingsService,#check-status-service,#dvNumTweets").show();
					        twitter.rangeSlider();
					    }
					              	
					}
				});
		}else{
			msg = 'Debes agregar un nombre al servicio';
			twitter.msgInfo(msg);
		}

	},
	showEditServiceTwitter : function(){
	
		twitter.statusService();

		var serviceName = $("#serviceName"),
			btnServiceName = $("#btnServiceName"),
			nameSettingsService = $("#nameSettingsService");

		if( serviceName.val() ){

			//serviceName.attr('readonly',true);
			//btnServiceName.addClass('disabled');
			nameSettingsService.val(serviceName.val());
			$("#dvTypeService,#dvSettingsService,#listHashtags,#listPerfiles,#listList,#check-status-service,#dvNumTweets,#listYoutubeVideos").show();
			
			if( $("#listInstagram").find("li ol").children().length > 0){
				$("#listInstagram").show();
			}
			twitter.rangeSlider();
		}
	},
	contentTypeService: function(){

		twitter.clickSearchNameService();
		twitter.showEditServiceTwitter();	

		$("#typeService").on("change",function(){

			var inputTypeService =  $("#inputTypeService");
				textInputNameService = $(this).find('option').filter(':selected').text();

				inputTypeService.empty();
				typeService = $(this).val();

				if(typeService!=''){

					if(typeService == 'perfil' || typeService == 'lista' ){
						icon = '@';
						idOptionService = "verificar-"+typeService;
						placeholder = 'Perfil'
						textInputNameService1 = 'Perfil'
					}else if(typeService == 'hashtag'){
						icon = '#';
						idOptionService = "verificar-"+typeService;
					}else if(typeService == "instagram"){
						icon = '';
						idOptionService = "verificar-"+typeService;
					}else if(typeService == "facebook-feeds"){
						icon = 'https://www.facebook.com/';
						idOptionService = "verificar-"+typeService;
						placeholder = 'grupo'
					}else if(typeService == "facebook-videos"){
						icon = 'https://www.facebook.com/';
						idOptionService = "verificar-"+typeService;
						placeholder = 'grupo'
					}else if(typeService == "youtube-videos"){
						icon = 'https://youtu.be/';
						idOptionService = "verificar-"+typeService;
						placeholder = 'canal'
					}else if(typeService == "playlists-videos"){
						icon = 'https://youtu.be/';
						idOptionService = "verificar-"+typeService;
						placeholder = 'canal'
						textInputNameService = 'Canal'
						textInputNameService1 = 'Lista'
					}

					if(typeService == 'perfil' || typeService == 'hashtag'){

						inputTypeService.append($('<label>',{text:textInputNameService}).addClass('control-label col-md-2'))
										.append($('<div>').addClass('col-md-10')
											  	.append($('<div>').addClass('row')
											  		.append($('<div>').addClass('col-sm-12')
												  		.append($('<div>').addClass('input-group')
												  			.append($('<span>',{text:icon}).addClass('input-group-addon'))
												  			.append($('<input>',{type:'text',placeholder:typeService,id:'typeServiceValue'}).addClass('form-control'))
												  			.append($('<div>').addClass('input-group-btn')
												  				.append($('<button>',{id:idOptionService,type:'button'}).addClass('btn btn-success')
												  					.append($("<i>").addClass('fa fa-check fa-fw')))))
												  		.append($('<p>',{text:'Escribe el nombre del '+typeService}).addClass('note')))));

					}
					if(typeService == 'lista' || typeService == 'playlists-videos'){

						inputTypeService.append($('<section>')
											.append($('<label>',{text:textInputNameService}).addClass('control-label col-md-2'))
											.append($('<div>').addClass('col-md-4')
												  	.append($('<div>').addClass('row')
												  		.append($('<div>').addClass('col-sm-12')
													  		.append($('<div>').addClass('input-group')
													  			.append($('<span>',{text:icon}).addClass('input-group-addon'))
													  			.append($('<input>',{type:'text',placeholder:placeholder,id:'typeServiceValue'}).addClass('form-control'))
													  			.append($('<div>').addClass('input-group-btn')
													  				.append($('<button>',{id:idOptionService,type:'button'}).addClass('btn btn-success')
													  					.append($("<i>").addClass('fa fa-check fa-fw')))))))))
											  	.append($('<section>',{id:'dvLists'})
											  		.append($('<label>',{text:textInputNameService1}).addClass('control-label col-md-1'))
													.append($("<div>").addClass('col-md-4 input-group')
										  				.append($('<select>',{id:'optionList'}).addClass('form-control'))
										  				.append($('<div>').addClass('input-group-btn')
										  					.append($('<button>',{type:'button',id:'saveTypeService'}).addClass('btn btn-success ')
										  						.append($('<i>').addClass('fa fa-check fa-fw'))))));
					}
					if(typeService == 'instagram'){

						var location = window.location.pathname;
							url = location.split('/');

							(url.length == 4) ? pathname= '../' : pathname ='./'; 


						inputTypeService.append($('<label>',{text:'Nombre'}).addClass('control-label col-md-2'))
											.append($('<div>').addClass('col-md-6')
												.append($('<select>',{id:'optionInstagram'}).addClass('form-control')))
											.append($('<div>',{id:'addBtnInstagram'}));
						
						$.ajax({
							url: pathname+idOptionService,
							type: 'GET',
							dataType: 'JSON',
							success: function(data){

								$("#optionInstagram").empty().append($("<option>"));

								for (var i = 0; i < data.length; i++) {
									$("#optionInstagram").append($("<option>",{text:data[i]}))
								};

								list_instagram = [];

								$("#optionInstagram").on("change",function(){

									if(!$("#lista_instagram").children().length){
										list_instagram = [];
									}else{
										$("#lista_instagram :input[value!='']").each(function(){
											if($(this).val()){
												if( $.inArray($(this).val(),list_instagram) == -1){
													list_instagram.push( $(this).val() );
												}
											}
										});
									}

									$("#addBtnInstagram").empty().append($('<button>',{type:'button',id:'saveInstagram'}).addClass('btn btn-success').append($("<i>").addClass('fa fa-check fa-fw')));
									

									$("#saveInstagram").on('click',function(){

										name_option_instagram = $("#optionInstagram").val();

										if( $.inArray(name_option_instagram,list_instagram) == -1){
											list_instagram.push(name_option_instagram)

											$("#lista_instagram").append($("<li>").addClass('dd-item')
															.append($("<div>").addClass('dd3-content')
																.append($("<input>",{type:'text',text:name_option_instagram,value:name_option_instagram}).attr('name','ServiceSettings[type_services][instagrams][]').addClass('styleInputText'))
																.append($('<em>').addClass('label pull-right')
																	.append($('<button>',{type:'button',text:'x'}).addClass('btn btn-danger btn-xs btnDel')))));
										}else{

											msg = "El usuario "+name_option_instagram+" ya se agrego."
											twitter.msgInfo(msg);
										}

										

										$("#optionInstagram option:first").attr('selected','selected');
										twitter.deleteServiceAll();
										$("#listInstagram").show();
										$('#saveSettingsService').show();
									});


								});

								


							}
						});
					}

					if(typeService == 'facebook-feeds' || typeService == 'facebook-videos' || typeService == 'youtube-videos'){

						inputTypeService.append($('<label>',{text:textInputNameService}).addClass('control-label col-md-2'))
										.append($('<div>').addClass('col-md-10')
											  	.append($('<div>').addClass('row')
											  		.append($('<div>').addClass('col-sm-12')
												  		.append($('<div>').addClass('input-group')
												  			.append($('<span>',{text:icon}).addClass('input-group-addon'))
												  			.append($('<input>',{type:'text',placeholder:placeholder,id:'typeServiceValue'}).addClass('form-control'))
												  			.append($('<div>').addClass('input-group-btn')
												  				.append($('<button>',{id:idOptionService,type:'button'}).addClass('btn btn-success')
												  					.append($("<i>").addClass('fa fa-check fa-fw')))))
												  		.append($('<p>',{text:'Escribe el nombre de la pagina'}).addClass('note')))));					
					}

					$("#typeServiceValue").on('keypress',function(){
						if (event.which == 13) {
							twitter.callbackTwitterElements();
						}
					});

					$( "#"+idOptionService ).on('click',function(){ 
						twitter.callbackTwitterElements(); 
					});
				}

			});
	},
	statusService : function(){

		var status_service = $("#status_service"),
		val_status_service = $("#val_status_service"),
		status_type_service = $("#status-type-service")
		desactivar = 'Desactivar',
		activar = 'Activar';
			
		if (status_service.is(':checked')){
			status_type_service.text(desactivar)
		}else{
			status_type_service.text(activar)
		}

		status_service.on('click',function(){
			if($(this).is(':checked')){
	            status_type_service.text(desactivar)
	            val_status_service.val(1);
	        }
	        else{
	           	status_type_service.text(activar)
	            val_status_service.val(0);
	        }
		});

		twitter.deleteServiceAll();

	},
	callbackTwitterElements : function(){

		var typeServiceValue = $("#typeServiceValue"),
			nameTypeService = typeServiceValue.val(),
			nameService = $("#nameSettingsService").val(),
			AddItem = false;

		var location = window.location.pathname;
		url = location.split('/');

		(url.length == 4) ? pathname= '../' : pathname ='./'; 

		$("#verificar-lista").addClass('disabled').children().removeClass().addClass('fa fa-gear fa-spin')
		typeServiceValue.attr('disabled',true);


		if( nameTypeService ){

			if(typeService == 'perfil'){
				data = {perfil:nameTypeService};
				showlist = $("#listPerfiles");
				table_type_service = 'profiles';
				txt_msg = 'El perfil ';
			}else if(typeService == 'hashtag'){
				data = {hashtag:nameTypeService};
				showlist = $("#listHashtags");
				table_type_service = 'hashtags';
				txt_msg = 'El hashtag ';
			}else if(typeService == 'lista'){
				data = {lista:nameTypeService};
				showlist = $("#listList");
				table_type_service = 'lists';
				txt_msg = 'La lista ';
			}else if(typeService == 'facebook-feeds'){
				data = {facebook_feeds:nameTypeService};
				showlist = $("#listFacebookFeeds");
				table_type_service = 'facebook_feeds';
				txt_msg = 'El feed ';
			}else if(typeService == 'facebook-videos'){
				data = {facebook_videos:nameTypeService};
				showlist = $("#listFacebookVideos");
				table_type_service = 'facebook_videos';
				txt_msg = 'El video ';
			}else if(typeService == 'youtube-videos'){
				data = {youtube_videos:nameTypeService};
				showlist = $("#listYoutubeVideos");
				table_type_service = 'youtube_videos';
				txt_msg = 'El canal ';
			}else if(typeService == 'playlists-videos'){
				data = {'playlists-videos':nameTypeService};
				showlist = $("#PlayListsYoutube");
				table_type_service = 'playlists-videos';
				txt_msg = 'El canal ';
			}

			$.ajax({
					url: pathname+idOptionService,
					type: 'GET',
					data: data,
					dataType: 'JSON',
					success: function(data){

					    if(data!=0){

							if(typeService!='lista' && typeService!='playlists-videos'){

								//(typeService == 'hashtag')? nameTypeService = icon+nameTypeService : nameTypeService = icon+data['screen_name'];

								if(typeService == 'facebook-feeds' || typeService == 'facebook-videos' || typeService == 'youtube-videos' || typeService == 'playlists-videos'){
									nameTypeService = nameTypeService.toLowerCase();
								}else if(typeService == 'hashtag'){
									nameTypeService = icon+nameTypeService.toLowerCase()
								}else{
									nameTypeService = icon+data['screen_name'].toLowerCase();
								}

								$("#"+typeService+" input[type=text]").each(function(){
									if($(this).val() == nameTypeService){
										AddItem = true;
									}
								});



								if(!AddItem){

									$("#"+typeService).append($("<li>").addClass('dd-item')
														.append($("<div>").addClass('dd3-content')
															.append($("<input>",{type:'text',text:nameTypeService,value:nameTypeService}).attr('name','ServiceSettings[type_services]['+table_type_service+'][]').addClass('styleInputText'))
															.append($('<em>').addClass('label pull-right')
																.append($('<button>',{type:'button',text:'x'}).addClass('btn btn-danger btn-xs btnDel')))));

									$('#saveSettingsService').show();
								}else{
									msg = "El "+ typeService +" "+nameTypeService+" ya se agrego."
									twitter.msgInfo(msg);
								}

								if( showlist.find("li ol").children().length > 0){
									showlist.find('li').show();
								}

								showlist.show();
								
								
							}else{

								var optionList = $("#optionList");

								optionList.empty();
								optionList.append($("<option>",{text:'Selecciona una lista ...',value:''}));

								
								if(typeService!='lista'){

									optionList.attr('data-profile',nameTypeService);

									$.each(data,function(nameProfile,valueList){
										optionList.append($("<option>",{text:valueList,value:nameProfile}));
									});

								}else{

									$.each(data,function(nameProfile,valueList){

										optionList.attr('data-profile',icon+nameProfile);
													
										$.each(valueList,function(nameListSlug,nameList){
											optionList.append($("<option>",{text:nameList,value:nameListSlug}));
										});					
									});

								}
								

								if( optionList.children().length > 0){ $("#dvLists").show(); }

								twitter.addServiceList();

							}

							if(typeService!='lista' && typeService!='playlists-videos'){ typeServiceValue.val('') }
											
							$("#typeServiceValue").attr('disabled',false);
							$("#"+idOptionService).removeClass('disabled').children().removeClass().addClass('fa fa-check fa-fw');
							twitter.deleteServiceAll();
											
					    }else{
					        msg = txt_msg + icon + nameTypeService + " no existe."
							twitter.msgInfo(msg);
					        typeServiceValue.val('');
					        $("#dvLists").hide();
					        $("#typeServiceValue").attr('disabled',false);
							$("#"+idOptionService).removeClass('disabled').children().removeClass().addClass('fa fa-check fa-fw');
					    }	
					                  	
					}//fin success
			})//fin ajax

		}else{
			alert("Ingresa la informacion requerida")
			typeServiceValue.val('');
			$("#typeServiceValue").attr('disabled',false);
			$("#"+idOptionService).removeClass('disabled').children().removeClass().addClass('fa fa-check fa-fw');
		}

	},
	deleteServiceAll : function(){

		$(".btnDel").on("click",function(){
			
			listOpt = $(this).closest("li ol").parents('ol').attr('id');

			if(listOpt == 'lista'){

				$(this).parent().closest('ol').remove();
			
				if( $("#"+$(this).attr('data-nameProf') ).children('ol').length == 0){
					$("#"+$(this).attr('data-nameProf') ).remove();
				}
				listOpt = 'listList';

			}else{

				$(this).parent().closest('li').remove();
			}

			if($("#"+listOpt).find("li ol").children().length == 0){
				
				$("#"+listOpt).hide();

				if(listOpt == 'listList'){
					$("#dvLists").hide();
					$("#typeServiceValue").val('');
					$("#optionList").empty();
				}	
			}

			if( $("#listPerfiles").find("li ol").children().length == 0 &&  $("#listHashtags").find("li ol").children().length == 0 && $("#listList").find("li ol").children().length == 0 && $("#listInstagram").find("li ol").children().length == 0 && $("#listFacebookFeeds").find("li ol").children().length == 0 && $("#listFacebookVideos").find("li ol").children().length == 0 && $("#listYoutubeVideos").find("li ol").children().length == 0 && $("#PlayListsYoutube").find("li ol").children().length == 0){
				$("#saveSettingsService,#updateSettingsService").hide();
			}

		});

	},
	addServiceList  : function(){
		
		$("#saveTypeService").on('click',function(){

			AddItem = false;

			optionListVal = $("#optionList").val();
			optionListText = $("#optionList").find('option').filter(":selected").text();
			nameProfileList = $("#optionList").attr('data-profile');
			
			//NProfileList = nameProfileList.replace("@","");

			try {
			    NProfileList = nameProfileList.replace("@","");
			}
			catch(err) {
			    NProfileList = nameProfileList;
			}

			if(optionListVal){

				$("#"+typeService+" input[type=text]").each(function(index){
					if($(this).val() == nameProfileList){
						AddItem = true;
					}
				});


				if(!AddItem){

					$("#"+typeService).append($("<li>",{id:NProfileList}).addClass('dd-item')
										.append($("<div>").addClass('dd3-content')
										.append($("<input>",{type:'text',text:nameProfileList,value:nameProfileList,readonly:true}).addClass('styleInputText'))
											.append($('<em>').addClass('label pull-right')
											.append($('<button>',{type:'button',text:'x'}).addClass('btn btn-danger btn-xs btnDel')))));
				}

				idList = NProfileList+"_"+optionListVal;

				console.log(optionListText)
				console.log(table_type_service)
				console.log(nameProfileList)
				console.log(optionListVal)


				if( $("#"+idList).length == 0 ){

					$("#"+NProfileList).append($("<ol>").addClass('dd-list')
										.append($("<li>").addClass('dd-item')
											.append($("<div>").addClass('dd3-content')
												.append($("<input>",{text:optionListText,value:optionListText,readonly:true,type:'text',id:idList}).addClass('styleInputText').attr('name','ServiceSettings[type_services]['+table_type_service+']['+nameProfileList+']['+optionListVal+'][]')
																					)
												.append($('<em>').addClass('label pull-right')
												.append($('<button>',{type:'button',text:'x'}).attr('data-nameProf',NProfileList).addClass('btn btn-danger btn-xs btnDel')))
											)));

					showlist.show();
					$('#saveSettingsService').show();
				}else{
					msg = "La "+ typeService +" "+optionListText+" del perfil "+nameProfileList+" ya se agrego."
					//twitter.msgInfo(msg);
				}

				twitter.deleteServiceAll();

				if($("#listList li ol").children().length > 0 || $("#PlayListsYoutube li ol").children().length > 0){
					$("#listList li").show();
					$("#PlayListsYoutube li").show();
				}
			}
		});

	},
	clickSearchNameService : function(){

		$("#btnServiceName").on('click',function(){
			twitter.searchNameService();
		});

		$("#serviceName").on('keypress',function(){
			if (event.which == 13) { 
				twitter.searchNameService();
			}
		});
	},
	init : function(){
		pageSetUp();
		$('#nestable3').nestable();
		twitter.contentTypeService();
	}
}


twitter.init();
