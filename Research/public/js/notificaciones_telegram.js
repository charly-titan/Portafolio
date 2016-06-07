notificaciones_telegram = {

	myDataRef : new Firebase("https://notificaciones-tim.firebaseio.com/"),
	msgSendOk	  	: "Se ha enviado exitosamente tu mensaje",
	msgCreateGroup 	: "Se ha creado un nuevo grupo",
	msgError		: "Error al enviar el mensaje",
	msgEmpty 		: "No has ingresado el mensaje a enviar",

	smallBox : function(title){

		$.smallBox({
			title : title,
			//content : "<i class='fa fa-clock-o'></i> <i>2 seconds ago...</i>",
			color : "#296191",
			iconSmall : "fa fa-thumbs-up bounce animated",
			timeout : 4000
		});

	},
	list_groups : function(){

		//$("#listUsers").prop("disabled", true);
		//$("#listUsers").select2('disable');

    	notificaciones_telegram.myDataRef.once("value", function(snapshot) {

			var  groups = snapshot.child("groups").exists();

			if(groups){

				notificaciones_telegram.myDataRef.on("value",function(snapshot){

		    		data = snapshot.val();
		    		groups = data.groups;

		    		$("#option_group").empty().append($("<option>",{text:"Selecciona un grupo...."}))

		    		$.each(groups,function(key,value){
		    			$("#option_group").append($("<option>",{text:value.name,value:value.name,id:key}));
		    		});
		    	});
			}
		});
	},
	text_msg_send:function(type){

		if(type == 'user'){
			dvMsg = $("#dvMsgUser");
			btnSend = $("#btnSendUser");
			msgTelegram = 'msgTelegramUser'
    		idBtnSend = 'sendMsgUser'
		}else{
			dvMsg = $("#dvMsgGroup");
			btnSend = $("#btnSendGroup");
			msgTelegram = 'msgTelegramGroup'
    		idBtnSend = 'sendMsgGroup'
		}

		dvMsg.empty().append($("<label>",{text:"Mensaje"}).addClass("col-md-2 control-label"))
    								.append($("<div>").addClass("col-md-10")
    									.append($("<textarea>",{rows:4,placeholder:"Mensaje",id:msgTelegram}).addClass('form-control')));

    	btnSend.empty().append($("<button>",{id:idBtnSend}).addClass("btn btn-primary").append($("<i>",{text:" Enviar"}).addClass("fa fa-send")));

	},
	text_msg_empty:function(){

		$("#dvMsgUser,#dvMsgGroup").prepend($("<article>").addClass("col-sm-12").append($("<div>").addClass("alert alert-warning fade in")
	    											.append($("<button>",{text:"x"}).addClass("close").attr("data-dismiss","alert"))
	    											.append($("<i>").addClass("fa-fw fa fa-warning"))
	    											.append($("<strong>",{text:"Falta agregar el mensaje a enviar"}))));  
	},
	remove_text_msg:function(){
		$("#dvMsgUser,#btnSendUser,#dvMsgGroup,#btnSendGroup").empty();
		$("#user_group").hide();
	},
	list_users :function(){

		var option_user = $("#option_user");

		option_user.on("change",function(){

    			users = $(this).select2('data');

    			if(users){

    				notificaciones_telegram.text_msg_send('user');

    				$("#sendMsgUser").on('click',function(){

    					msgUser = $("#msgTelegramUser").val();

    					if(msgUser){
    						
	    					var postsRef = notificaciones_telegram.myDataRef.child("mesagges_telegram");
							var newPostRef = postsRef.push();

	    					$.ajax({
	    						url:'/notifications/send-message-user',
	    						type:'GET',
	    						data: { id_user:users.id, msg_telegram:msgUser },
	    						dataType:'JSON',
	    						success:function(data){

	    							if(data.result == 'SUCCESS'){
										status_result = 1;
										notificaciones_telegram.smallBox(notificaciones_telegram.msgSendOk);
	    							}else{
	    								status_result = 0;
	    								notificaciones_telegram.smallBox(notificaciones_telegram.msgError);
	    							}

	    							newPostRef.set({
										users: 		$.makeArray( users.text ),
										message: 	msgUser,
										status: 	status_result
									});

				    				notificaciones_telegram.remove_text_msg();
				    				option_user.select2('val','');
	    						}
	    					});

	    				}else{

	    					notificaciones_telegram.smallBox(notificaciones_telegram.msgEmpty);
	    				}
    				});

    			}else{
    				notificaciones_telegram.text_msg_empty();
    			}

    	});
    	

	},
	send_mesg_group : function(user_id,user_name,option_group){

		msgGroup = $("#msgTelegramGroup").val();

		var group_users = notificaciones_telegram.myDataRef.child('groups').child(idGroup);
		var postsRef = notificaciones_telegram.myDataRef.child("mesagges_telegram");
		var newPostRef = postsRef.push();

		if(msgGroup){

		    $.ajax({
			    url:'/notifications/send-message-group',
			    type:'GET',
			    data: { list_users:user_id, msg_telegram:msgGroup},
			    dataType:'JSON',
			    success:function(data){

			    	if(data.result == 'SUCCESS'){
			    		status_result = 1;
			    		notificaciones_telegram.smallBox(notificaciones_telegram.msgSendOk);
			    	}else{
			    		status_result = 0;
			    		notificaciones_telegram.smallBox(notificaciones_telegram.msgError);
			    	}

			    	group_users.update({
						users: user_name
					});	

					newPostRef.set({
						users: 		user_name,
						message: 	msgGroup,
						status: 	status_result
					});

					notificaciones_telegram.remove_text_msg();
					   option_group.select2('val','');
			    }
			});

		}else{
		    notificaciones_telegram.text_msg_empty();
		}

	},
	list_users_groups : function(){

		var option_group = $("#option_group");

		option_group.on("change",function(){

			var name_group_selected = $(this).val();
				idGroup = $("#option_group option:selected").attr('id');
				listUsers = $('#listUsers');
				$("#addGroup").hide();

			try {

					notificaciones_telegram.myDataRef.child('groups').on('value',function(snapshot){
				    	var data = snapshot.val();
				    			
				    	$.each(data,function(id,info){
				    				
				    		if(info.name === name_group_selected){

				    			optionValue = [];

				    			for (var i = 0; i < info.users.length; i++) {
				    				valueOption = $('#listUsers option:contains('+info.users[i]+')').val();
				    				optionValue.push(valueOption);
				    			};

				    			listUsers.select2( 'val', optionValue );
				    			notificaciones_telegram.text_msg_send('group');
				    		}		
				    	})
				    });
				    
				}
				catch(err) {
				    console.log(err.message)
				}


				if(name_group_selected){

					$("#user_group").show();

					listUsers.on('change',function(){

						users_group = listUsers.select2('data');

						if(users_group){

							notificaciones_telegram.text_msg_send('group');

							userGroupName = [];
							userGroupId = [];

							for (var i = 0; i < users_group.length; i++) {
								userGroupName.push(users_group[i].text)
								userGroupId.push(users_group[i].id)
							}

							$("#sendMsgGroup").on('click',function(){
		    					notificaciones_telegram.send_mesg_group(userGroupId,userGroupName,option_group);
		    				});
						}
	    				
	    			});

					$("#sendMsgGroup").on('click',function(){
					
						users_group = listUsers.select2('data');
						userGroupName = [];
						userGroupId = [];

						for (var i = 0; i < users_group.length; i++) {
							userGroupName.push(users_group[i].text)
							userGroupId.push(users_group[i].id)
						}

						notificaciones_telegram.send_mesg_group(userGroupId,userGroupName,option_group);
					})

				}
		});
	},
	save_group_users : function(){

		$("#saveGroup").on('click',function(){

			var nameGroup = $("#name-group").val();
			var addUsersGroup = $("#userGroup option:selected").text();
			var usersGroup = $("#userGroup").val();


			if(nameGroup && addUsersGroup!=''){

				notificaciones_telegram.myDataRef.once("value", function(snapshot) {

				var existTableGroups = snapshot.child("groups").exists();

				  if(!existTableGroups){

				  	var postsRef = notificaciones_telegram.myDataRef.child("groups");
					var newPostRef = postsRef.push();
				  
					newPostRef.set({
						name: nameGroup,
						users: usersGroup
					});

					notificaciones_telegram.smallBox(notificaciones_telegram.msgCreateGroup);
					$("#addGroup").hide();
					location.reload();

				  }else{
				  		
				  		tables = [];

						$.each(data.groups,function(id,table){
							tables.push(table.name);
						});
						
						if($.inArray(nameGroup,tables) == -1){

							var postsRef = notificaciones_telegram.myDataRef.child("groups");
							var newPostRef = postsRef.push();
						  
							newPostRef.set({
								name: nameGroup,
								users: usersGroup
							});

							notificaciones_telegram.smallBox(notificaciones_telegram.msgCreateGroup);
							$("#addGroup").hide();

						}else{
							alert("ya existe el grupo")
						}
				  }

				 
				});

			}else{
				$("#addGroup").find("form").find("article").remove();
				$("#addGroup").find("form").prepend($("<article>").addClass("col-sm-12").append($("<div>").addClass("alert alert-warning fade in")
    											.append($("<button>",{text:"x"}).addClass("close").attr("data-dismiss","alert"))
    											.append($("<i>").addClass("fa-fw fa fa-warning"))
    											.append($("<strong>",{text:"Es obligatorio llenar los campos"}))));  

			}

			


		});



	},
	add_group : function(){

		$("#btnAddGroup").on('click',function(){
			$("#addGroup").show();
			$('#option_group').select2('val','');
			$("#dvMsgGroup,#btnSendGroup").empty();
			$("#user_group").hide();
		});

		$("#closeAddGroup").on('click',function(){
			$("#addGroup").hide();
		});
		
	},
	status_msg : function(){



		notificaciones_telegram.myDataRef.once("value", function(snapshot) {

				var mesagges_telegram = snapshot.child("mesagges_telegram").exists();

				//if(mesagges_telegram){

					notificaciones_telegram.myDataRef.on("value", function(snapshot) {

						var data = snapshot.val();


						$("#statusMsg").empty();

						$.each(data.mesagges_telegram,function(id,value){

							var datos;

							for (var i = 0; i < value.users.length; i++) {

								if(value.status){
									classBtn = 'btn-success';
									classIcon = "glyphicon glyphicon-ok";
									msgInfo	= " Success";
								}else{
									classBtn ='btn-warning';
									classIcon = "fa fa-gear fa-spin";
									msgInfo = " In proccess"
								}
								
								datos+= "<tr><td>"+value.users[i]+"</td><td>"+value.message+"</td><td><button class='btn btn-xs "+classBtn+"'><i class='"+classIcon+"'></i>"+msgInfo+"</button></td></tr>";
							};

							$("#statusMsg").prepend(datos);

						});

					});
				//}
		});

	},
	init : function(){
		pageSetUp();
		this.list_groups();
		this.list_users();
		this.list_users_groups();
		this.save_group_users();
		this.add_group();
		this.status_msg();
	}
}

notificaciones_telegram.init();